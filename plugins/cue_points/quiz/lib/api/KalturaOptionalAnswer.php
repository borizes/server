<?php
/**
 * A representation of an optional answer for question cue point
 *
 * @package plugins.quiz
 * @subpackage api.objects
 */
class KalturaOptionalAnswer extends KalturaObject {

	/**
	 * @var string
	 */
	public $text;

	/**
	 * @var float
	 */
	public $weight = 1.0;

	private static $mapBetweenObjects = array
	(
		'text',
		'weight',
	);

	public function getMapBetweenObjects()
	{
		return array_merge(parent::getMapBetweenObjects(), self::$mapBetweenObjects);
	}

	/* (non-PHPdoc)
	 * @see KalturaObject::toObject($object_to_fill, $props_to_skip)
	 */
	public function toObject($dbObject = null, $propsToSkip = array())
	{
		if (!$dbObject)
		{
			$dbObject = new kOptionalAnswer();
		}

		return parent::toObject($dbObject, $propsToSkip);
	}

}