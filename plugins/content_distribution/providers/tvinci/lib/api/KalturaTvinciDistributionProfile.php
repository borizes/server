<?php
/**
 * @package plugins.tvinciDistribution
 * @subpackage api.objects
 */
class KalturaTvinciDistributionProfile extends KalturaConfigurableDistributionProfile
{
	/**
	 * @var string
	 */
	public $ingestUrl;
	
	/**
	 * @var string
	 */
	public $username;

	/**
	 * @var string
	 */
	public $password;
	
// 	/**
// 	 * @var string
// 	 */
// 	public $broadcasterName;


// 	/**
// 	 * @var string
// 	 */
// 	public $notificationEmail;

// 	/**
// 	 * @var string
// 	 */
// 	public $sftpHost;

// 	/**
// 	 * @var int
// 	 */
// 	public $sftpPort;
	
// 	/**
// 	 * 
// 	 * @var string
// 	 */
// 	public $sftpLogin;
	
// 	/**
// 	 * 
// 	 * @var string
// 	 */
// 	public $sftpPublicKey;
	
// 	/**
// 	 * 
// 	 * @var string
// 	 */
// 	public $sftpPrivateKey;
	
// 	/**
// 	 * 
// 	 * @var string
// 	 */
// 	public $sftpBaseDir;
	
// 	/**
// 	 * 
// 	 * @var string
// 	 */
// 	public $ownerName;
	
// 	/**
// 	 * 
// 	 * @var string
// 	 */
// 	public $defaultCategory;
		
// 	/**
// 	 * 
// 	 * @var string
// 	 */
// 	public $allowComments;
	
// 	/**
// 	 * 
// 	 * @var string
// 	 */
// 	public $allowEmbedding;
	
// 	/**
// 	 * 
// 	 * @var string
// 	 */
// 	public $allowRatings;
	
// 	/**
// 	 * 
// 	 * @var string
// 	 */
// 	public $allowResponses;
	
// 	/**
// 	 * 
// 	 * @var string
// 	 */
// 	public $commercialPolicy;
	
// 	/**
// 	 * 
// 	 * @var string
// 	 */
// 	public $ugcPolicy;
		
// 	/**
// 	 * @var string
// 	 */
// 	public $target;
	
// 	/**
// 	 * @var string
// 	 */
// 	public $adServerPartnerId;
	
// 	/**
// 	 * @var bool
// 	 */
// 	public $enableAdServer;
	
// 	/**
// 	 * @var bool
// 	 */
// 	public $allowPreRollAds;
	
// 	/**
// 	 * @var bool
// 	 */
// 	public $allowPostRollAds;

// 	/**
// 	 * @var string
// 	 */
// 	public $strict;

// 	/**
// 	 * @var string
// 	 */
// 	public $overrideManualEdits;

// 	/**
// 	 * @var string
// 	 */
// 	public $urgentReference;

// 	/**
// 	 * @var string
// 	 */
// 	public $allowSyndication;

// 	/**
// 	 * @var string
// 	 */
// 	public $hideViewCount;

// 	/**
// 	 * @var string
// 	 */
// 	public $allowAdsenseForVideo;

// 	/**
// 	 * @var string
// 	 */
// 	public $allowInvideo;

// 	/**
// 	 * @var bool
// 	 */
// 	public $allowMidRollAds;

// 	/**
// 	 * @var string
// 	 */
// 	public $instreamStandard;

// 	/**
// 	 * @var string
// 	 */
// 	public $instreamTrueview;

// 	/**
// 	 * @var string
// 	 */
// 	public $claimType;

// 	/**
// 	 * @var string
// 	 */
// 	public $blockOutsideOwnership;

// 	/**
// 	 * @var string
// 	 */
// 	public $captionAutosync;

// 	/**
// 	 * @var bool
// 	 */
// 	public $deleteReference;

// 	/**
// 	 * @var bool
// 	 */
// 	public $releaseClaims;

	/*
		 * mapping between the field on this object (on the left) and the setter/getter on the object (on the right)
		 */
	private static $map_between_objects = array 
	(
// 		'feedSpecVersion',
		'ingestUrl',
		'username',
		'password',
// 		'broadcasterName',
// 		'sftpHost',
// 		'sftpPort',
// 		'sftpLogin',
// 		'sftpPublicKey',
// 		'sftpPrivateKey',
// 		'sftpBaseDir',
// 		'ownerName',
// 		'defaultCategory',
// 		'allowComments',
// 		'allowEmbedding',
// 		'allowRatings',
// 		'allowResponses',
// 		'commercialPolicy',
// 		'ugcPolicy',
// 		'target',
// 	    'adServerPartnerId',
// 	    'enableAdServer',
// 	    'allowPreRollAds',
// 	    'allowPostRollAds',
// 		'strict',
// 		'overrideManualEdits',
// 		'urgentReference',
// 		'allowSyndication',
// 		'hideViewCount',
// 		'allowAdsenseForVideo',
// 		'allowInvideo',
// 		'allowMidRollAds',
// 		'instreamStandard',
// 		'instreamTrueview',
// 		'claimType',
// 		'blockOutsideOwnership',
// 		'captionAutosync',
// 		'deleteReference',
// 		'releaseClaims',
	 );
		 
	public function getMapBetweenObjects()
	{
		return array_merge(parent::getMapBetweenObjects(), self::$map_between_objects);
	}
}