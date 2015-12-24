<?php
/**
 * @package plugins.facebookDistribution
 * @subpackage api.objects
 */
class KalturaFacebookDistributionJobProviderData extends KalturaConfigurableDistributionJobProviderData
{
	/**
	 * @var string
	 */
	public $videoAssetFilePath;
	
	/**
	 * @var string
	 */
	public $thumbAssetFilePath;

	/**
	 * @var KalturaCaptionDistributionInfoArray
	 */
	public $captionsInfo;

	public function __construct(KalturaDistributionJobData $distributionJobData = null)
	{
		parent::__construct($distributionJobData);
	    
		if( (!$distributionJobData) ||
			!($distributionJobData->distributionProfile instanceof KalturaFacebookDistributionProfile) ){
			KalturaLog::info("Distribution data given did not exist or was not facebook related, given: ".print_r($distributionJobData, true));
			return;
		}

		$this->videoAssetFilePath = $this->getValidVideoPath($distributionJobData);

		if(!$this->videoAssetFilePath){
			KalturaLog::err("Could not find a valid video asset");
			return;
		}


		$thumbAssets = assetPeer::retrieveByIds(explode(',', $distributionJobData->entryDistribution->thumbAssetIds));
		if(count($thumbAssets))
		{
			$syncKey = reset($thumbAssets)->getSyncKey(thumbAsset::FILE_SYNC_FLAVOR_ASSET_SUB_TYPE_ASSET);
			if(kFileSyncUtils::fileSync_exists($syncKey))
				$this->thumbAssetFilePath = kFileSyncUtils::getLocalFilePathForKey($syncKey, false);
		}

//		TODO add the captions
//		$this->addCaptionsData($distributionJobData);

	}
	
	private static $map_between_objects = array
	(
		"videoAssetFilePath",
		"thumbAssetFilePath",
		"captionsInfo"
	);

	public function getMapBetweenObjects ( )
	{
		return array_merge ( parent::getMapBetweenObjects() , self::$map_between_objects );
	}
	
	private function addCaptionsData(KalturaDistributionJobData $distributionJobData) 
	{
		$assetIdsArray = explode ( ',', $distributionJobData->entryDistribution->assetIds );
		if (empty($assetIdsArray)) return;
		$this->captionsInfo = new KalturaCaptionDistributionInfoArray();
		
		foreach ( $assetIdsArray as $assetId ) 
		{
			$asset = assetPeer::retrieveByIdNoFilter( $assetId );
			if (!$asset)
			{
				KalturaLog::err("Asset [$assetId] not found");
				continue;
			}
			if($asset->getType() != CaptionPlugin::getAssetTypeCoreValue ( CaptionAssetType::CAPTION )) //TODO - check format is srt
			{
				KalturaLog::debug("Asset [$assetId] is not a caption");
				continue;				
			}
			if ($asset->getStatus() == asset::ASSET_STATUS_READY) 
			{
				$syncKey = $asset->getSyncKey ( asset::FILE_SYNC_FLAVOR_ASSET_SUB_TYPE_ASSET );
				if (kFileSyncUtils::fileSync_exists ( $syncKey )) 
				{
					$captionInfo = $this->getCaptionInfo($asset, $distributionJobData, KalturaDistributionAction::SUBMIT);
					if($captionInfo)
					{
						$captionInfo->filePath = kFileSyncUtils::getLocalFilePathForKey ( $syncKey, false );
						$this->captionsInfo [] = $captionInfo;
					}					 
				}						
			}
			elseif($asset->getStatus()== asset::ASSET_STATUS_DELETED) 
			{
				$captionInfo = $this->getCaptionInfo($asset, $distributionJobData, KalturaDistributionAction::DELETE);
				if($captionInfo)
				{
						$this->captionsInfo [] = $captionInfo;
				}	
			}
			else
			{
				KalturaLog::err("Asset [$assetId] has status [".$asset->getStatus()."]. not added to provider data");
			}
		}
	}
	
	private function getLanguageCode($language = null)
	{
		$languageReflector = KalturaTypeReflectorCacher::get('KalturaLanguage');
		$languageCodeReflector = KalturaTypeReflectorCacher::get('KalturaLanguageCode');
		if($languageReflector && $languageCodeReflector)
		{
			$languageCode = $languageReflector->getConstantName($language);
			if($languageCode)
				return $languageCodeReflector->getConstantValue($languageCode);
		}
		return null;
	}
	
	private function getCaptionInfo($asset, KalturaDistributionJobData $distributionJobData, $action) 
	{
		$captionInfo = new KalturaCaptionDistributionInfo ();		
		$captionInfo->assetId = $asset->getId();
		$captionInfo->version = $asset->getVersion();
		$captionInfo->language = $this->getLanguageCode($asset->getLanguage());
		
		if(!$captionInfo->language)
		{
			KalturaLog::err('The caption ['.$asset->getId().'] has unrecognized language ['.$asset->getLanguage().']');
			return null;
		}
		
		$distributed = false;
		foreach ( $distributionJobData->mediaFiles as $mediaFile ) 
		{
			if ($mediaFile->assetId == $asset->getId ()) {
				$distributed = true;
				break;
			}
		}
		if ($distributed && $action == KalturaDistributionAction::DELETE || 
			!$distributed && $action == KalturaDistributionAction::SUBMIT)
		{
			$captionInfo->action = $action;
		}
		else 
		{
			return null;
		}
			
		return $captionInfo;
	}
	
	private function getValidVideoPath(KalturaDistributionJobData $distributionJobData)
	{
		$flavorAssets = array();
		$videoAssetFilePath = null;
		$isValidVideo = false;
		
		if(count($distributionJobData->entryDistribution->flavorAssetIds))
		{
			$flavorAssets = assetPeer::retrieveByIds(explode(',', $distributionJobData->entryDistribution->flavorAssetIds));
		}
		else 
		{
			$flavorAssets = assetPeer::retrieveReadyFlavorsByEntryId($distributionJobData->entryDistribution->entryId);
		}
		
		foreach ($flavorAssets as $flavorAsset) 
		{
			$syncKey = $flavorAsset->getSyncKey(flavorAsset::FILE_SYNC_FLAVOR_ASSET_SUB_TYPE_ASSET);
			if(kFileSyncUtils::fileSync_exists($syncKey))
			{
				$videoAssetFilePath = kFileSyncUtils::getLocalFilePathForKey($syncKey, false);
				$mediaInfo = mediaInfoPeer::retrieveByFlavorAssetId($flavorAsset->getId());
				if($mediaInfo)
				{
					try
					{
						FacebookGraphSdkUtils::validateVideoAttributes($videoAssetFilePath, $mediaInfo->getFileSize(), $mediaInfo->getVideoDuration(), $mediaInfo->getVideoWidth(), $mediaInfo->getVideoHeight());
						$isValidVideo = true;
					}
					catch(Exception $e)
					{
						KalturaLog::debug('Asset ['.$flavorAsset->getId().'] not valid for distribution: '.$e->getMessage());
					}	
				}
				if($isValidVideo)
					break;		
			}				
		}		
		return $videoAssetFilePath;
	}

}
