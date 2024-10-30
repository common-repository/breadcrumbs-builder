<?php

global $SGBB_AUTOLOAD;
$SGBB_AUTOLOAD = array();

$SGBB_AUTOLOAD['menu_items'] = array(
	array(
		'id' => 'showAll',
		'page_title' => 'All Breadcrumbs',
		'menu_title' => 'Breadcrumbs Builder',
		'capability' => 'manage_options',
		'icon' => 'dashicons-editor-insertmore',
		'controller' => 'Breadcrumb',
		'action' => 'index',
		'submenu_items' => array(
			array(
				'id' => 'showAll',
				'page_title' => 'All Breadcrumbs',
				'menu_title' => 'All Breadcrumbs',
				'capability' => 'manage_options',
				'controller' => 'Breadcrumb',
				'action' => 'index',
			),
			array(
				'id' => 'add',
				'page_title' => 'Add/Edit Breadcrumb',
				'menu_title' => 'Add Breadcrumb',
				'capability' => 'manage_options',
				'controller' => 'Breadcrumb',
				'action' => 'save',
			),
			array(
				'id' => 'sgPlugins',
				'page_title' => 'More Plugins',
				'menu_title' => 'More Plugins',
				'capability' => 'manage_options',
				'controller' => 'Breadcrumb',
				'action' => 'morePlugins',
			)
		),
	),
);

$SGBB_AUTOLOAD['network_admin_menu_items'] = array();

$SGBB_AUTOLOAD['shortcodes'] = array(
	array(
		'shortcode' => 'sgbb_breadcrumb',
		'controller' => 'Breadcrumb',
		'action' => 'sgbbShortcode',
	),
);

$SGBB_AUTOLOAD['front_ajax'] = array();

$SGBB_AUTOLOAD['admin_ajax'] = array(
	array(
		'controller' => 'Breadcrumb',
		'action' => 'ajaxSave',
	),
	array(
		'controller' => 'Breadcrumb',
		'action' => 'ajaxDelete',
	),
	array(
		'controller' => 'Breadcrumb',
		'action' => 'ajaxTurnOn',
	),
	array(
		'controller' => 'Breadcrumb',
		'action' => 'ajaxTurnOff',
	)
);

$SGBB_AUTOLOAD['admin_post'] = array(
	array(
		'controller' => 'Breadcrumb',
		'action' => 'delete',
	)
);

//use wp_ajax_library to include ajax for the frontend
$SGBB_AUTOLOAD['front_scripts'] = array();

//use wp_enqueue_media to enqueue media
$SGBB_AUTOLOAD['admin_scripts'] = array();

$SGBB_AUTOLOAD['front_styles'] = array();

$SGBB_AUTOLOAD['admin_styles'] = array();
