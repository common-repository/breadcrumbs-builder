<?php

global $sgbb;
$sgbb->includeModel('Model');

class SGBB_PositionModel extends SGBB_Model
{
	const TABLE = 'position';
	protected $id;
	protected $breadcrumb_id;
	protected $position_id;

	public static function finder($class = __CLASS__)
	{
		return parent::finder($class);
	}

	public static function create()
	{
		global $sgbb;
		global $wpdb;
		$tablename = $sgbb->tablename(self::TABLE);

		$query = "CREATE TABLE IF NOT EXISTS $tablename (
					  `id` int(10) NOT NULL AUTO_INCREMENT,
					  `breadcrumb_id` int(10) NOT NULL,
					  `position_id` int(10) NOT NULL,
					  PRIMARY KEY (`id`)
					) ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=utf8;";
		$wpdb->query($query);
	}

	public static function drop()
	{
		global $sgbb;
		global $wpdb;
		$tablename = $sgbb->tablename(self::TABLE);
		$query = "DROP TABLE $tablename";
		$wpdb->query($query);
	}
}
