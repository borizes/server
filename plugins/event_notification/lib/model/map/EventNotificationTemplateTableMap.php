<?php


/**
 * This class defines the structure of the 'event_notification_template' table.
 *
 *
 *
 * This map class is used by Propel to do runtime db structure discovery.
 * For example, the createSelectSql() method checks the type of a given column used in an
 * ORDER BY clause to know whether it needs to apply SQL to make the ORDER BY case-insensitive
 * (i.e. if it's a text column type).
 *
 * @package plugins.eventNotification
 * @subpackage model.map
 */
class EventNotificationTemplateTableMap extends TableMap {

	/**
	 * The (dot-path) name of this class
	 */
	const CLASS_NAME = 'plugins.eventNotification.EventNotificationTemplateTableMap';

	/**
	 * Initialize the table attributes, columns and validators
	 * Relations are not initialized by this method since they are lazy loaded
	 *
	 * @return     void
	 * @throws     PropelException
	 */
	public function initialize()
	{
	  // attributes
		$this->setName('event_notification_template');
		$this->setPhpName('EventNotificationTemplate');
		$this->setClassname('EventNotificationTemplate');
		$this->setPackage('plugins.eventNotification');
		$this->setUseIdGenerator(true);
		// columns
		$this->addPrimaryKey('ID', 'Id', 'INTEGER', true, null, null);
		$this->addColumn('PARTNER_ID', 'PartnerId', 'INTEGER', true, null, null);
		$this->addColumn('NAME', 'Name', 'VARCHAR', true, 127, null);
		$this->addColumn('SYSTEM_NAME', 'SystemName', 'VARCHAR', false, 127, null);
		$this->addColumn('DESCRIPTION', 'Description', 'VARCHAR', false, 255, null);
		$this->addColumn('TYPE', 'Type', 'INTEGER', true, null, null);
		$this->addColumn('STATUS', 'Status', 'INTEGER', true, null, null);
		$this->addColumn('CREATED_AT', 'CreatedAt', 'TIMESTAMP', false, null, null);
		$this->addColumn('UPDATED_AT', 'UpdatedAt', 'TIMESTAMP', false, null, null);
		$this->addColumn('CUSTOM_DATA', 'CustomData', 'LONGVARCHAR', false, null, null);
		$this->addColumn('EVENT_TYPE', 'EventType', 'INTEGER', false, null, null);
		$this->addColumn('OBJECT_TYPE', 'ObjectType', 'INTEGER', false, null, null);
		// validators
	} // initialize()

	/**
	 * Build the RelationMap objects for this table relationships
	 */
	public function buildRelations()
	{
	} // buildRelations()

} // EventNotificationTemplateTableMap
