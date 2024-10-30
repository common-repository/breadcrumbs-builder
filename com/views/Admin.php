<?php

global $sgbb;
$sgbb->includeView('View');

class SGBB_AdminView extends SGBB_View
{
	public function configureLayouts($mainLayout)
	{
		return array($mainLayout);
	}

	public static function render($layout, $params=array())
	{
		$view = new self();
		$view->prepareView($layout, $params);
		$view->output();
	}
}
