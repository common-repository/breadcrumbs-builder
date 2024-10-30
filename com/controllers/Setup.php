<?php

global $sgbb;
$sgbb->includeController('Controller');
$sgbb->includeModel('Breadcrumb');
$sgbb->includeModel('Theme');
$sgbb->includeModel('Position');

class SGBB_SetupController extends SGBB_Controller
{
	public static function activate()
	{
		SGBB_BreadcrumbModel::create();
		SGBB_ThemeModel::create();
		SGBB_PositionModel::create();
		if (is_multisite()) {
			$sites = get_sites();
			foreach($sites as $site) {
				SGBB_BreadcrumbModel::create();
				SGBB_ThemeModel::create();
				SGBB_PositionModel::create();
			}
		}

	}

	public static function deactivate()
	{
		
	}

	public static function uninstall()
	{
		SGBB_BreadcrumbModel::drop();
		SGBB_ThemeModel::drop();
		SGBB_PositionModel::drop();
		if (is_multisite()) {
			$sites = get_sites();
			foreach($sites as $site) {
				SGBB_BreadcrumbModel::drop();
				SGBB_ThemeModel::drop();
				SGBB_PositionModel::drop();
			}
		}
	}

	public static function createBlog()
	{

	}

}
