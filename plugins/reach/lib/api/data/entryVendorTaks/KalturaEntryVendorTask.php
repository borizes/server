<?php
/**
 * @package plugins.reach
 * @subpackage api.objects
 */
class KalturaEntryVendorTask extends KalturaObject implements IRelatedFilterable
{
	/**
	 * @var int
	 * @readonly
	 * @filter eq,in,order
	 */
	public $id;
	
	/**
	 * @var int
	 * @readonly
	 */
	public $partnerId;
	
	/**
	 * @var int
	 * @filter eq,in
	 * @readonly
	 */
	public $vendorPartnerId;
	
	/**
	 * @var time
	 * @readonly
	 * @filter gte,lte,order
	 */
	public $createdAt;
	
	/**
	 * @var time
	 * @readonly
	 * @filter gte,lte,order
	 */
	public $updatedAt;
	
	/**
	 * @var time
	 * @readonly
	 * @filter gte,lte,order
	 */
	public $queueTime;
	
	/**
	 * @var time
	 * @readonly
	 * @filter gte,lte,order
	 */
	public $finishTime;
	
	/**
	 * @var string
	 * @filter eq
	 * @insertonly
	 */
	public $entryId;
	
	/**
	 * @var KalturaEntryVendorTaskStatus
	 * @filter eq,in
	 */
	//TODO update to requires permissions to insert or update
	public $status;
	
	/**
	 * The profile id from which this task base cnfig is taken from
	 * @var int
	 * @filter eq,in
	 * @insertonly
	 */
	public $vendorProfileId;
	
	/**
	 * The catalog item Id containing the task description 
	 * @var int
	 * @filter eq,in
	 * @insertonly
	 */
	public $catalogItemId;
	
	/**
	 * The charged price to execute this task
	 * @var int
	 * @readonly
	 */
	public $price;
	
	/**
	 * The ID of the user who created this task
	 * @var string
	 * @filter eq
	 * @readonly
	 */
	public $userId;
	
	/**
	 * The user ID that approved this task for execution (in case moderation is requested)
	 * @var string
	 * @readonly
	 */
	public $moderatingUser;
	
	/**
	 * Err description provided by provider in case job execution has failed
	 * @var string
	 * @requiresPermission insert, update
	 */
	public $errDescription;
	
	/**
	 * Access key generated by Kaltura to allow vendors to ingest the end result to the destination
	 * @var string
	 * @readonly
	 */
	public $accessKey;
	
	/**
	 * User generated notes that should be taken into account by the vendor while executing the task
	 * @var string
	 */
	public $notes;
	
	private static $map_between_objects = array
	(
		'id',
		'partnerId',
		'vendorPartnerId',
		'createdAt',
		'updatedAt',
		'queueTime',
		'finishTime',
		'entryId',
		'status',
		'vendorProfileId',
		'catalogItemId',
		'price',
		'userId',
		'moderatingUser',
		'errDescription',
		'accessKey',
		'notes',
	);
	
	/* (non-PHPdoc)
	 * @see KalturaCuePoint::getMapBetweenObjects()
	 */
	public function getMapBetweenObjects()
	{
		return array_merge(parent::getMapBetweenObjects(), self::$map_between_objects);
	}
	
	/* (non-PHPdoc)
 	 * @see KalturaObject::toInsertableObject()
 	 */
	public function toInsertableObject($object_to_fill = null, $props_to_skip = array())
	{
		if (is_null($object_to_fill))
			$object_to_fill = new EntryVendorTask();
		
		return parent::toInsertableObject($object_to_fill, $props_to_skip);
	}
	
	public function validateForInsert($propertiesToSkip = array())
	{
		$this->validatePropertyNotNull("vendorProfileId");
		$this->validatePropertyNotNull("catalogItemId");
		$this->validatePropertyNotNull("entryId");
		$this->validateEntryId();
		return parent::validateForInsert($propertiesToSkip);
	}
	
	private function validateEntryId()
	{
		$dbEntry = entryPeer::retrieveByPK($this->entryId);
		if (!$dbEntry)
			throw new KalturaAPIException(KalturaErrors::ENTRY_ID_NOT_FOUND, $this->entryId);
	}
	
	public function getExtraFilters()
	{
		return array();
	}
	
	public function getFilterDocs()
	{
		return array();
	}
}
