<?php

global $sgbb;
$sgbb->includeLib('Breadcrumb');
$sgbb->includeModel('Breadcrumb');

class SGBB_ThemeView extends SGBB_Breadcrumb
{
	public function __construct()
	{
		parent::__construct('sgbb');

		$this->setRowsPerPage(10);
		$this->setTablename(SGBB_ThemeModel::TABLE);
		$this->setColumns(array(
			'id',
			'title',
			'theme'
		));
		$this->setDisplayColumns(array(
			'id' => 'ID',
			'title' => 'Title',
			'theme' => 'Theme',
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
		$editUrl = $sgbb->adminUrl('Breadcrumb/save','id='.$id);
		$id = $row[0];
		$row[3] = "<input type='text' onfocus='this.select();' style='font-size:12px;' readonly value='[sgbb_page_nav id=".$id."]' class='sgbb-large-text code'>";
		$row[4] = '<a href="'.$editUrl.'">'.__('Edit', 'sgbb').'</a>&nbsp;&nbsp;<a href="#" onclick="SGBB.ajaxDelete('.$id.')">'.__('Delete', 'sgbb').'</a>';
	}

	public function customizeQuery(&$query)
	{
		//$query .= ' LEFT JOIN wp_sgbb_comment ON wp_sgbb_comment.review_id='.$this->tablename.'.id';
	}
}
