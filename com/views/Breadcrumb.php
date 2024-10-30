<?php

global $sgbb;
$sgbb->includeLib('Breadcrumb');
$sgbb->includeModel('Breadcrumb');
$sgbb->includeView('Theme');


class SGBB_BreadcrumbView extends SGBB_Breadcrumb
{
	public function __construct()
	{
		parent::__construct('sgbb');
		$themeView = new SGBB_ThemeView();
		$themeTablename = $themeView->getTablename();

		$this->setRowsPerPage(10);
		$this->setTablename(SGBB_BreadcrumbModel::TABLE);
		$this->setColumns(array(
			$this->tablename.'.id',
			$this->tablename.'.title',
			$this->tablename.'.on_off',
			$themeTablename.'.title AS theme_title'
		));
		$this->setDisplayColumns(array(
			'id' => 'ID',
			'title' => 'Title',
			'on_off' => 'Status',
			'theme_title' => 'Theme',
			'shortcode' => 'Shortcode',
			'options' => 'Options'

		));
		$this->setSortableColumns(array(
			'id' => array('id', false),
			'title' => array('title', true)
		));
		$this->setInitialSort(array(
			'id' => 'DESC'
		));
	}

	public function customizeRow(&$row)
	{
		global $sgbb;
		$id = $row[0];
		$turnedOn = $row[2];
		$spinnerPath = $sgbb->app_url.'/assets/page/img/spinner-2x.gif';

		if ($turnedOn == 0) {
			$row[2] = '<div class="sgbb-switcher-wrapper" style="background-color: #cccccc;">
						<div class="sgbb-switch-on-wrapper" style="float:left;"><div class="sgbb-switch-on sgbb-switcher" data-breadcrumb="'.$id.'"></div></div>
					</div><i class="sgbb-switcher-spinner"><img src="'.$spinnerPath.'"></i>';
		}
		else if ($turnedOn == 1) {
			$row[2] = '<div class="sgbb-switcher-wrapper" style="background-color: #428BCA;">
						<div class="sgbb-switch-off-wrapper" style="float:right;"><div class="sgbb-switch-off sgbb-switcher" data-breadcrumb="'.$id.'"></div></div>
					</div><i class="sgbb-switcher-spinner"><img src="'.$spinnerPath.'"></i>';
		}
		
		$editUrl = $sgbb->adminUrl('Breadcrumb/save','id='.$id);
		$row[4] = '<input type="text" onfocus="this.select();" style="font-size:12px;" readonly value="[sgbb_breadcrumb id='.$id.']" class="sgbb-large-text code">';
		$row[5] = '<a href="'.$editUrl.'">'.__('Edit', 'sgbb').'</a>&nbsp;&nbsp;<a href="#" onclick="SGBB.ajaxDelete('.$id.')">'.__('Delete', 'sgbb').'</a>';
	}

	public function customizeQuery(&$query)
	{
		$themeView = new SGBB_ThemeView();
		$themeTablename = $themeView->getTablename();
		$query .= ' LEFT JOIN '.$themeTablename.' ON '.$themeTablename.'.id='.$this->tablename.'.theme_id';
	}
}
