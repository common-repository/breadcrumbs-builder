<?php

global $sgbb;
$sgbb->includeModel('Model');

class SGBB_BreadcrumbModel extends SGBB_Model
{
	const TABLE = 'breadcrumb';
	protected $id;
	protected $title;
	protected $theme_id;
	protected $custom_css;
	protected $on_off;
	protected $options;

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
					  `title` varchar(255) NOT NULL,
					  `theme_id` int(10) NOT NULL,
					  `custom_css` LONGTEXT NOT NULL,
					  `on_off` int(10) NOT NULL,
					  `options` text NOT NULL,
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
