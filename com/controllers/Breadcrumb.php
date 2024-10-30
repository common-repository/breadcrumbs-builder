<?php
global $sgbb;
$sgbb->includeController('Controller');
$sgbb->includeView('Admin');
$sgbb->includeView('Breadcrumb');
$sgbb->includeModel('Breadcrumb');
$sgbb->includeModel('Theme');
$sgbb->includeModel('Position');

class SGBB_BreadcrumbController extends SGBB_Controller
{
	public $breadNavList = array();

	public function index()
	{
		global $sgbb;
		$sgbb->includeScript('page/scripts/save');
		$sgbb->includeScript('core/scripts/main');
		$sgbb->includeScript('core/scripts/sgbbRequestHandler');
		$review = new SGBB_BreadcrumbView();
		$createNewUrl = $sgbb->adminUrl('Breadcrumb/save');

		SGBB_AdminView::render('Breadcrumb/index', array(
			'createNewUrl' => $createNewUrl,
			'review' => $review
		));
	}

	public function sgbbShortcode($atts, $content)
	{
		$attributes = shortcode_atts(array(
			'id' => '1',
		), $atts);
		$sgbbId = (int)$attributes['id'];
		$breadcrumb = SGBB_BreadcrumbModel::finder()->findByPk($sgbbId);
		if(!$breadcrumb){
			return false;
		}
		$html = $this->prepareBreadcrumbHtml($sgbbId, $position = false, true);
		return $html;
	}


	public function ajaxSave()
	{
		global $wpdb;

		$options = array();
		$customCss = array();
		$allThemes = array();
		$positions = array();
		$youAreHere = '';
		$addPositionPrTop = '';
		$addPositionSeTop = '';
		$addPositionBefore = '';
		$addPositionAfter = '';
		$addPositionPrBottom = '';
		$addPositionSeBottom = '';
		$breadcrumbId = 0;
		$isUpdate = false;

		if (count($_POST)) {
			$title = stripslashes(@$_POST['sgbb-title']);
			$theme = @$_POST['theme'];
			$addYouHereChecked = @$_POST['addYouHereChecked'];
			$showOnHomePage = @$_POST['showOnHomePage'];
			$addYouHereText = stripslashes(@$_POST['addYouHere']);
			$addHome = @$_POST['addHome'];
			$addHomeText = stripslashes(@$_POST['addHomeText']);
			$addAlignement = @$_POST['addAlignement'];
			$addMarginTop = (int)@$_POST['addMarginTop'];
			$addMarginRight = (int)@$_POST['addMarginRight'];
			$addMarginBottom = (int)@$_POST['addMarginBottom'];
			$addMarginLeft = (int)@$_POST['addMarginLeft'];

			$addMarginTopType = (int)@$_POST['addMarginTopType'];
			$addMarginRightType = (int)@$_POST['addMarginRightType'];
			$addMarginBottomType = (int)@$_POST['addMarginBottomType'];
			$addMarginLeftType = (int)@$_POST['addMarginLeftType'];

			$addPositionPrTop = @$_POST['addPositionPrTop'];
			$addPositionSeTop = @$_POST['addPositionSeTop'];
			$addPositionBefore = @$_POST['addPositionBefore'];
			$addPositionAfter = @$_POST['addPositionAfter'];
			$addPositionPrBottom = @$_POST['addPositionPrBottom'];
			$addPositionSeBottom = @$_POST['addPositionSeBottom'];

			$tabBackgroundColor = @$_POST['tabBackgroundColor'];
			$tabHoverColor = @$_POST['tabHoverColor'];
			$tabTextColor = @$_POST['tabTextColor'];
			$tabTextHoverColor = @$_POST['tabTextHoverColor'];

			$breadcrumbId = (int)$_POST['sgbb-id'];

			$isUpdate = false;

			if ($breadcrumbId) {
				$breadcrumbId = (int)$_POST['sgbb-id'];
				$breadcrumb = SGBB_BreadcrumbModel::finder()->findByPk($breadcrumbId);
				if (!$breadcrumb) {
					exit();
				}
				$options = $breadcrumb->getOptions();
				$customCss = $breadcrumb->getCustom_css();
				$customCss = json_decode($customCss, true);
				$options = json_decode($options, true);
				$themeId = $breadcrumb->getTheme_id();
				$selectedTheme = SGBB_ThemeModel::finder()->findByPk($themeId);
				if (!$selectedTheme) {
					exit();
				}
				$isUpdate = true;
			}
			else {
				$breadcrumb = new SGBB_BreadcrumbModel();
				$allThemes = SGBB_ThemeModel::finder()->findAll();
				if (empty($allThemes)) {
					exit();
				}
				$selectedTheme = $allThemes[0];
			}

			if (!$theme) {
				$theme = $selectedTheme->getId();
			}

			$options['youAreHere'] = '';
			$options['addHomeAndText'] = '';
			$options['addYouHereChecked'] = '';
			$options['showOnHomePage'] = '';
			$options['addAlignement'] = '';

			$options['addMarginTop'] = '';
			$options['addMarginRight'] = '';
			$options['addMarginBottom'] = '';
			$options['addMarginLeft'] = '';
			$options['addMarginTopType'] = 1;
			$options['addMarginRightType'] = 1;
			$options['addMarginBottomType'] = 1;
			$options['addMarginLeftType'] = 1;
			$customCss = array();

			if ($addYouHereChecked) {
				$options['youAreHere'] = $addYouHereText;
				$options['addYouHereChecked'] = 1;
			}
			if ($showOnHomePage) {
				$options['showOnHomePage'] = 1;
			}
			if ($addHome) {
				if ($addHome == 'homeText') {
					$options['addHomeText'] = $addHomeText;
				}
				else if ($addHome == 'both') {
					$options['addHomeText'] = $addHomeText;
					$options['addHomeAndText'] = 2;
				}
				else {
					$options['addHomeText'] = '';
				}
			}
			if ((int)$addMarginTop) {
				$options['addMarginTop'] = $addMarginTop;
				if ($addMarginTopType) {
					$options['addMarginTopType'] = $addMarginTopType;
				}
			}
			if ((int)$addMarginRight) {
				$options['addMarginRight'] = $addMarginRight;
				if ($addMarginRightType) {
					$options['addMarginRightType'] = $addMarginRightType;
				}
			}
			if ((int)$addMarginBottom) {
				$options['addMarginBottom'] = $addMarginBottom;
				if ($addMarginBottomType) {
					$options['addMarginBottomType'] = $addMarginBottomType;
				}
			}
			if ((int)$addMarginLeft) {
				$options['addMarginLeft'] = $addMarginLeft;
				if ($addMarginLeftType) {
					$options['addMarginLeftType'] = $addMarginLeftType;
				}
			}
			if ($addAlignement) {
				$options['addAlignement'] = $addAlignement;
			}
			if ($addPositionPrTop) {
				$positions['addPositionPrTop'] = $addPositionPrTop;
			}
			if ($addPositionSeTop) {
				$positions['addPositionSeTop'] = $addPositionSeTop;
			}
			if ($addPositionBefore) {
				$positions['addPositionBefore'] = $addPositionBefore;
			}
			if ($addPositionAfter) {
				$positions['addPositionAfter'] = $addPositionAfter;
			}
			if ($addPositionPrBottom) {
				$positions['addPositionPrBottom'] = $addPositionPrBottom;
			}
			if ($addPositionSeBottom) {
				$positions['addPositionSeBottom'] = $addPositionSeBottom;
			}

			if (SGBB_PRO_VERSION) {
				if ($tabBackgroundColor) {
					$customCss['tabBackgroundColor'] = $tabBackgroundColor;
				}
				if ($tabHoverColor) {
					$customCss['tabHoverColor'] = $tabHoverColor;
				}
				if ($tabTextColor) {
					$customCss['tabTextColor'] = $tabTextColor;
				}
				if ($tabTextHoverColor) {
					$customCss['tabTextHoverColor'] = $tabTextHoverColor;
				}
			}

			$options = json_encode($options);
			if (empty($customCss)) {
				$customCss = '';
			}
			else {
				$customCss = json_encode($customCss);
			}

			$breadcrumb->setTitle(sanitize_text_field($title));
			$breadcrumb->setTheme_id(sanitize_text_field($theme));
			$breadcrumb->setOn_off(1);
			$breadcrumb->setCustom_css(sanitize_text_field($customCss));
			$breadcrumb->setOptions(sanitize_text_field($options));
			$res = $breadcrumb->save();

			if ($breadcrumb->getId()) {
				$lastBreadcrumbId = $breadcrumb->getId();
			}
			else {
				if (!$res) return false;
				$lastBreadcrumbId = $wpdb->insert_id;
			}

			if (!empty($positions)) {
				SGBB_PositionModel::finder()->deleteAll('breadcrumb_id = %d', $lastBreadcrumbId);
				foreach ($positions as $position) {
					$newPosition = SGBB_PositionModel::finder()->find('position_id = %d', $position);
					if (!$newPosition) {
						$newPosition = new SGBB_PositionModel();
					}
					$newPosition->setBreadcrumb_id($lastBreadcrumbId);
					$newPosition->setPosition_id($position);
					$newPosition->save();
				}
			}
		}
		echo $lastBreadcrumbId;
		exit();
	}

	public function save()
	{
		global $wpdb;
		global $sgbb;

		$sgbb->includeScript('page/scripts/save');
		$sgbb->includeScript('page/scripts/bootstrap.min');
		$sgbb->includeScript('core/scripts/main');
		$sgbb->includeScript('core/scripts/sgbbRequestHandler');
		$sgbb->includeStyle('page/styles/bootstrap.min');
		$sgbb->includeStyle('page/styles/save');
		$sgbb->includeStyle('page/styles/sg-box-cols');

		$sgbbId = 0;
		$sgbbDataArray = array();
		$sgbbOptions = array();
		$sgbbCustomCssOptions = array();
		$sgbbThemes = array();
		$addPosition = array();
		$selectedPositions = array();
		$sgbbCurrentTheme = '';
		$sgbbBrCrumb = '';

		$sgbbId = isset($_GET['id']) ? (int)$_GET['id'] : 0;
		if ($sgbbId) {
			$sgbbBrCrumb = SGBB_BreadcrumbModel::finder()->findByPk($sgbbId);
		}

		$sgbbSaveUrl = $sgbb->adminUrl('Breadcrumb/save');
		$sgbbThemes = SGBB_ThemeModel::finder()->findAll();
		//If edit
		if ($sgbbBrCrumb) {
			$sgbbDataArray = array();
			$sgbbCurrentThemeId = $sgbbBrCrumb->getTheme_id();
			$sgbbCurrentTheme = SGBB_ThemeModel::finder()->findByPk($sgbbCurrentThemeId);
			$sgbbOptions = $sgbbBrCrumb->getOptions();
			$sgbbCustomCssOptions = $sgbbBrCrumb->getCustom_css();
			if ($sgbbCustomCssOptions) {
				$sgbbCustomCssOptions = json_decode($sgbbCustomCssOptions, true);
			}
			$sgbbOptions = json_decode($sgbbOptions, true);
			if (!$sgbbBrCrumb) {
				$sgbbBrCrumb = new SGBB_BreadcrumbModel();
				return;
			}
			$title = $sgbbBrCrumb->getTitle();
			$addYouHereChecked = @$sgbbOptions['addYouHereChecked'];
			$showOnHomePage = @$sgbbOptions['showOnHomePage'];
			$addYouHere = @$sgbbOptions['youAreHere'];
			$addHome = @$sgbbOptions['addHome'];
			$addHomeText = @$sgbbOptions['addHomeText'];
			$addHomeAndText = @$sgbbOptions['addHomeAndText'];
			$addAlignement = @$sgbbOptions['addAlignement'];

			$selectedPositions = SGBB_PositionModel::finder()->findAll('breadcrumb_id = %d', $sgbbId);
			if (!empty($selectedPositions)) {
				foreach ($selectedPositions as $selectedPosition) {
					$addPosition[] = $selectedPosition->getPosition_id();
				}
			}

			$addMarginTop = @$sgbbOptions['addMarginTop'];
			$addMarginRight = @$sgbbOptions['addMarginRight'];
			$addMarginBottom = @$sgbbOptions['addMarginBottom'];
			$addMarginLeft = @$sgbbOptions['addMarginLeft'];
			$addMarginTopType = @$sgbbOptions['addMarginTopType'];
			$addMarginRightType = @$sgbbOptions['addMarginRightType'];
			$addMarginBottomType = @$sgbbOptions['addMarginBottomType'];
			$addMarginLeftType = @$sgbbOptions['addMarginLeftType'];
			$tabBackgroundColor = @$sgbbCustomCssOptions['tabBackgroundColor'];
			$tabHoverColor = @$sgbbCustomCssOptions['tabHoverColor'];
			$tabTextColor = @$sgbbCustomCssOptions['tabTextColor'];
			$tabTextHoverColor = @$sgbbCustomCssOptions['tabTextHoverColor'];

			$sgbbDataArray['title'] = $title;
			$sgbbDataArray['theme'] = $sgbbCurrentThemeId;
			$sgbbDataArray['addYouHereChecked'] = $addYouHereChecked;
			$sgbbDataArray['showOnHomePage'] = $showOnHomePage;
			$sgbbDataArray['addYouHere'] = $addYouHere;
			$sgbbDataArray['addHome'] = $addHome;
			$sgbbDataArray['addHomeText'] = $addHomeText;
			$sgbbDataArray['addHomeAndText'] = $addHomeAndText;
			$sgbbDataArray['addAlignement'] = $addAlignement;
			$sgbbDataArray['addMarginTop'] = $addMarginTop;
			$sgbbDataArray['addMarginRight'] = $addMarginRight;
			$sgbbDataArray['addMarginBottom'] = $addMarginBottom;
			$sgbbDataArray['addMarginLeft'] = $addMarginLeft;

			$sgbbDataArray['$addMarginTopType'] = $addMarginTopType;
			$sgbbDataArray['addMarginRightType'] = $addMarginRightType;
			$sgbbDataArray['addMarginBottomType'] = $addMarginBottomType;
			$sgbbDataArray['addMarginLeftType'] = $addMarginLeftType;

			for ($i = 0;$i < count($addPosition); $i++) {
				if ($addPosition[$i] == SGBB_POSITION_TOP_1) {
					$sgbbDataArray['addPositionPrTop'] = $addPosition[$i];
				}
				if ($addPosition[$i] == SGBB_POSITION_TOP_2) {
					$sgbbDataArray['addPositionSeTop'] = $addPosition[$i];
				}
				if ($addPosition[$i] == SGBB_POSITION_AFTER) {
					$sgbbDataArray['addPositionAfter'] = $addPosition[$i];
				}
				if ($addPosition[$i] == SGBB_POSITION_BEFORE) {
					$sgbbDataArray['addPositionBefore'] = $addPosition[$i];
				}
				if ($addPosition[$i] == SGBB_POSITION_BOTTOM_1) {
					$sgbbDataArray['addPositionPrBottom'] = $addPosition[$i];
				}
				if ($addPosition[$i] == SGBB_POSITION_BOTTOM_2) {
					$sgbbDataArray['addPositionSeBottom'] = $addPosition[$i];
				}
			}
			$sgbbDataArray['addPosition'] = $addPosition;
			$sgbbDataArray['tabBackgroundColor'] = $tabBackgroundColor;
			$sgbbDataArray['tabHoverColor'] = $tabHoverColor;
			$sgbbDataArray['tabTextColor'] = $tabTextColor;
			$sgbbDataArray['tabTextHoverColor'] = $tabTextHoverColor;
		}
		else {
			$sgbbBrCrumb = new SGBB_BreadcrumbModel();
			$sgbbId = 0;
		}
		SGBB_AdminView::render('Breadcrumb/save', array(
			'sgbbDataArray' => $sgbbDataArray,
			'sgbbSaveUrl' => $sgbbSaveUrl,
			'sgbbBrCrumbId' => $sgbbId,
			'sgbbBrCrumb' => $sgbbBrCrumb,
			'sgbbThemes' => $sgbbThemes
		));
	}

	public function morePlugins()
	{
		global $sgbb;
		$sgbb->includeStyle('page/styles/save');
		$sgbb->includeStyle('page/styles/sg-box-cols');
		SGBB_AdminView::render('Breadcrumb/morePlugins');
	}

	public function ajaxDelete()
	{
		$id = (int)$_POST['id'];
		SGBB_BreadcrumbModel::finder()->deleteByPk($id);
		exit();
	}

	public function ajaxTurnOn()
	{
		$id = (int)$_POST['id'];
		$breadcrumbTurOn = SGBB_BreadcrumbModel::finder()->findByPk($id);
		if (!$breadcrumbTurOn) {
			exit();
		}
		$breadcrumbTurOn->setOn_off(1);
		/*$breadcrumbIsOn = SGBB_BreadcrumbModel::finder()->find('on_off = %d', 1);
		if ($breadcrumbIsOn) {
			$breadcrumbIsOn->setOn_off(0);
			$breadcrumbIsOn->save();
		}*/
		$breadcrumbTurOn->save();
		echo $id;
		exit();
	}

	public function ajaxTurnOff()
	{
		$id = (int)$_POST['id'];
		$breadcrumb = SGBB_BreadcrumbModel::finder()->findByPk($id);
		if (!$breadcrumb) {
			exit();
		}
		$breadcrumb->setOn_off(0);
		$breadcrumb->save();
		echo $id;
		exit();
	}

	public function prepareBreadcrumbHtml($breadcrumbId, $position, $isShortCode)
	{
		$html = '';

		if ($isShortCode) { // show by shortcode
			$mainBreadcrumb = SGBB_BreadcrumbModel::finder()->findByPk($breadcrumbId);
			if ($mainBreadcrumb) {
				$html .= $this->createBreadcrumbHtml($breadcrumbId, $position, $isShortCode);
				return $html;
			}
		}

		$mainBreadcrumbs = SGBB_BreadcrumbModel::finder()->findAll('on_off = %d', 1);
		$checkedPositions = SGBB_PositionModel::finder()->findAll('position_id = %d', $position);
		if ($checkedPositions) {
			foreach ($checkedPositions as $checkedPosition) {
				$mainBreadcrumbId = $checkedPosition->getBreadcrumb_id();
				if ($mainBreadcrumbId) {
					$breadcrumbToShow = SGBB_BreadcrumbModel::finder()->find('id = %d && on_off = %d', array($mainBreadcrumbId, 1));
					if ($breadcrumbToShow) {
						$html .= $this->createBreadcrumbHtml($mainBreadcrumbId, $position, $isShortCode);
						return $html;
					}
				}
			}
		}
	}

	public function generateBreadList($page)
	{
		if (is_object($page)) {
			$this->breadNavList[] = $page;
			if ($page->post_parent != 0) {
				$parentPage = get_post($page->post_parent);
				$this->generateBreadList($parentPage);
			}
		}
		else {
			return $this->breadNavList;
		}
	}

	private function createBreadcrumbHtml($breadcrumbId = false, $position = false, $isShortCode = false)
	{
		$html = '';
		$breadcrumbHtml = '';
		$mainStyles = '';
		$youAreHere = '';
		$separator = '';
		$customCss = '';
		$tabBackgroundColor = '';
		$tabHoverColor = '';
		$currentPageId = 0;
		$homeLink = get_home_url();
		$breadcrumbOptions = array();
		$pages = array();
		$homeTextIcon = '';
		$addAlignement = '';
		$addMargin = '';
		$addMarginTop = 0;
		$addMarginRight = 0;
		$addMarginBottom = 0;
		$addMarginLeft = 0;
		$addMarginTopType = 'px';
		$addMarginRightType = 'px';
		$addMarginBottomType = 'px';
		$addMarginLeftType = 'px';

		$currentPageObject = get_queried_object();

		if ($currentPageObject) {
			$currentPageId = $currentPageObject->ID;
			$currentPageType = $currentPageObject->post_type;
			$currentPageParent = $currentPageObject->post_parent;
		}

		if ($currentPageId) {
			if (!$currentPageParent) {
				$pages[] = $currentPageObject;
			}
			else {
				$this->generateBreadList($currentPageObject);
				$pages = array_reverse($this->breadNavList);
			}
		}

		$mainBreadcrumb = SGBB_BreadcrumbModel::finder()->findByPk($breadcrumbId);
		if (!$mainBreadcrumb) {
			return '';
		}
		$theme = $mainBreadcrumb->getTheme_id();
		if ((!SGBB_PRO_VERSION && $theme > 5) || !$theme) {
			return false;
		}
		$mainTheme = SGBB_ThemeModel::finder()->findByPk($theme);
		if (!$mainTheme) {
			return false;
		}

		$breadcrumbOptions = $mainBreadcrumb->getOptions();
		$breadcrumbCustomCss = $mainBreadcrumb->getCustom_css();
		$breadcrumbCustomCss = json_decode($breadcrumbCustomCss, true);
		$breadcrumbOptions = json_decode($breadcrumbOptions, true);
		$isHFrontPage = is_front_page();
		$isHomePage = is_home();

		if (($isHomePage || $isHFrontPage) && !@$breadcrumbOptions['showOnHomePage']) {
			return '';
		}
		if (@$breadcrumbOptions['youAreHere']) {
			$youAreHere .= $breadcrumbOptions['youAreHere'];
		}

		if (!empty($breadcrumbCustomCss) ) {
			if (@$breadcrumbCustomCss['tabBackgroundColor']) {
				$tabBackgroundColor = $breadcrumbCustomCss['tabBackgroundColor'];
			}
			if (@$breadcrumbCustomCss['tabHoverColor']) {
				$tabHoverColor = $breadcrumbCustomCss['tabHoverColor'];
			}
			if (@$breadcrumbCustomCss['tabTextColor']) {
				$tabTextColor = $breadcrumbCustomCss['tabTextColor'];
			}
			if (@$breadcrumbCustomCss['tabTextHoverColor']) {
				$tabTextHoverColor = $breadcrumbCustomCss['tabTextHoverColor'];
			}
			$customCss = '<style>
								.sgbb-front-wrapper .sgbb-theme-type-1 .sgbb-main-wrapper ul li a,
								.sgbb-front-wrapper .sgbb-theme-type-1 .sgbb-main-wrapper li a:hover:before,
								.sgbb-front-wrapper .sgbb-theme-type-2 .sgbb-main-wrapper ul li a,
								.sgbb-front-wrapper .sgbb-theme-type-3 .sgbb-main-wrapper ul li a,
								.sgbb-front-wrapper .sgbb-theme-type-4 .sgbb-main-wrapper ul li a,
								.sgbb-front-wrapper .sgbb-theme-type-5 .sgbb-main-wrapper ul li a,
								.sgbb-front-wrapper .sgbb-theme-type-6 .sgbb-main-wrapper ul li a,
								.sgbb-front-wrapper .sgbb-theme-type-7 ul li:not(:last-child) a,
								.sgbb-front-wrapper .sgbb-theme-type-8 .sgbb-main-wrapper ul li a,
								.sgbb-front-wrapper .sgbb-theme-type-9 .sgbb-main-wrapper ul li a,
								.sgbb-front-wrapper .sgbb-theme-type-10 .sgbb-main-wrapper ul li a {
									background-color: '.$tabBackgroundColor.';
								}
								.sgbb-front-wrapper .sgbb-theme-type-1 .sgbb-main-wrapper ul li a:hover,
								.sgbb-front-wrapper .sgbb-theme-type-1 .sgbb-main-wrapper ul li a:hover:after,
								.sgbb-front-wrapper .sgbb-theme-type-2 .sgbb-main-wrapper ul li a:hover,
								.sgbb-front-wrapper .sgbb-theme-type-2 .sgbb-main-wrapper ul li a:hover:after,
								.sgbb-front-wrapper .sgbb-theme-type-3 .sgbb-main-wrapper ul li a:hover,
								.sgbb-front-wrapper .sgbb-theme-type-4 .sgbb-main-wrapper ul li a:hover,
								.sgbb-front-wrapper .sgbb-theme-type-5 .sgbb-main-wrapper ul li a:hover,
								.sgbb-front-wrapper .sgbb-theme-type-6 .sgbb-main-wrapper ul li a:hover,
								.sgbb-front-wrapper .sgbb-theme-type-7 ul li:not(:last-child) a:hover,
								.sgbb-front-wrapper .sgbb-theme-type-8 .sgbb-main-wrapper ul li a:hover,
								.sgbb-front-wrapper .sgbb-theme-type-9 .sgbb-main-wrapper ul li a:hover,
								.sgbb-front-wrapper .sgbb-theme-type-10 .sgbb-ul-list-wrapper li a:hover {
									background-color: '.$tabHoverColor.';
								}

								.sgbb-front-wrapper .sgbb-theme-type-6 .sgbb-ul-list-wrapper li a:hover:after,
								.sgbb-front-wrapper .sgbb-theme-type-7 ul li:not(:last-child) a:hover:after {
									border-left: 24px solid '.$tabHoverColor.';
								}
								.sgbb-front-wrapper .sgbb-theme-type-6 .sgbb-ul-list-wrapper li a:after,
								.sgbb-front-wrapper .sgbb-theme-type-7 ul li:not(:last-child) a:after {
									border-left: 24px solid '.$tabBackgroundColor.';
								}
								.sgbb-front-wrapper .sgbb-theme-type-1 .sgbb-main-wrapper ul li a:after,
								.sgbb-front-wrapper .sgbb-theme-type-2 .sgbb-main-wrapper ul li a:after,
								.sgbb-front-wrapper .sgbb-theme-type-3 .sgbb-main-wrapper ul li a:after,
								.sgbb-front-wrapper .sgbb-theme-type-4 .sgbb-main-wrapper ul li a:after,
								.sgbb-front-wrapper .sgbb-theme-type-5 .sgbb-main-wrapper ul li a:after,
								.sgbb-front-wrapper .sgbb-theme-type-8 .sgbb-main-wrapper ul li a:after,
								.sgbb-front-wrapper .sgbb-theme-type-9 .sgbb-main-wrapper ul li a:after {
									background-color: '.$tabBackgroundColor.';
									border-color: '.$tabBackgroundColor.';
								}
								.sgbb-front-wrapper .sgbb-main-wrapper .sgbb-ul-list-wrapper li:last-child a {
								 	background-color: '.$tabHoverColor.';
									border-color: '.$tabHoverColor.';
								}
								.sgbb-front-wrapper .sgbb-main-wrapper .sgbb-ul-list-wrapper li:last-child a:before {
								 	background-color: '.$tabBackgroundColor.';
									border-color: '.$tabBackgroundColor.';
								}
								.sgbb-front-wrapper .sgbb-theme-type-10 .sgbb-main-wrapper .sgbb-ul-list-wrapper li:not(:last-child) a:after {
									background-color: '.$tabBackgroundColor.';
								}
								.sgbb-front-wrapper .sgbb-theme-type-10 .sgbb-main-wrapper .sgbb-ul-list-wrapper li:not(:last-child) a:hover:after {
									background-color: '.$tabHoverColor.';
								}
								.sgbb-front-wrapper .sgbb-main-wrapper .sgbb-separator {
									background-color: '.$tabBackgroundColor.';
								}
						</style>';
		}

		$homeTextIcon .= '<i class="dashicons dashicons-admin-home sgbb-home-icon"></i>';
		if (@$breadcrumbOptions['addHomeText'] && (@$breadcrumbOptions['addHomeAndText'] != 2)) {
			$homeTextIcon = $breadcrumbOptions['addHomeText'];
		}
		if (@$breadcrumbOptions['addHomeAndText'] == 2) {
			$homeTextIcon = '<i class="dashicons dashicons-admin-home sgbb-home-icon"></i>'.$breadcrumbOptions['addHomeText'];
		}

		if (@$breadcrumbOptions['addAlignement']) {
			$addAlignement .= 'text-align: '.@$breadcrumbOptions['addAlignement'].';';
		}
		if (@$breadcrumbOptions['addMarginTop']) {
			$addMarginTop = @$breadcrumbOptions['addMarginTop'];
		}
		if (@$breadcrumbOptions['addMarginTopType'] && @$breadcrumbOptions['addMarginTopType'] == 2) {
			$addMarginTopType = '%';
		}
		if (@$breadcrumbOptions['addMarginRight']) {
			$addMarginRight = @$breadcrumbOptions['addMarginRight'];
		}
		if (@$breadcrumbOptions['addMarginRightType'] && @$breadcrumbOptions['addMarginRightType'] == 2) {
			$addMarginRightType = '%';
		}
		if (@$breadcrumbOptions['addMarginBottom']) {
			$addMarginBottom = @$breadcrumbOptions['addMarginBottom'];
		}
		if (@$breadcrumbOptions['addMarginBottomType'] && @$breadcrumbOptions['addMarginBottomType'] == 2) {
			$addMarginBottomType = '%';
		}
		if (@$breadcrumbOptions['addMarginLeft']) {
			$addMarginLeft = @$breadcrumbOptions['addMarginLeft'];
		}
		if (@$breadcrumbOptions['addMarginLeftType'] && @$breadcrumbOptions['addMarginLeftType'] == 2) {
			$addMarginLeftType = '%';
		}

		$addMargin .= 'margin: '.$addMarginTop.$addMarginTopType.' '.$addMarginRight.$addMarginRightType.' '.$addMarginBottom.$addMarginBottomType.' '.$addMarginLeft.$addMarginLeftType.';';
		$mainStyles .= 'style="'.$addMargin.$addAlignement.'"';

		if ($theme == SGBB_THEME_3) {
			$separator .= '<span class="sgbb-separator"> / </span>';
		}
		else if ($theme == SGBB_THEME_5) {
			$separator .= '<span class="sgbb-separator"> &raquo; </span>';
		}

		$themeCss = $mainTheme->getBb_css();
		$index = 1;
		$breadcrumbHtml .= '<div class="sgbb-theme-type-'.$theme.'">
								<div class="sgbb-btn-group sgbb-main-wrapper">
								<ul itemscope itemtype="http://schema.org/BreadcrumbList" class="sgbb-ul-list-wrapper">
								  <li itemprop="itemListElement" itemscope itemtype="http://schema.org/ListItem">
									<a itemprop="item" href="'.$homeLink.'" class="sgbb-home-link sgbb-btn sgbb-btn-default sgbb-label-link">
										<span itemprop="name">'.$youAreHere.$homeTextIcon.'</span>
									</a>
									<meta class="sgbb-display-none" itemprop="position" content="'.$index.'" /></li>'.$separator;
									if (!empty($pages)) {
										foreach ($pages as $page) {
											$selected = '';
											if ($page->ID == $currentPageId) {
												$selected = ' sgbb-selected-link';
											}
											$breadcrumbHtml .= '<li itemprop="itemListElement" itemscope itemtype="http://schema.org/ListItem">
												<a href="'.$page->guid.'" class="sgbb-btn sgbb-btn-default sgbb-label-link'.$selected.'">
													<span itemprop="name">'.$page->post_title.'</span>
												</a>
												<meta class="sgbb-display-none" itemprop="position" content="'.$index.'" /></li>'.$separator;
											$index++;
										}
									}
		$breadcrumbHtml .= '</ul></div>';

		$breadcrumbHtml .= '<div class="sgbb-theme-styles-wrapper"><style>'.$themeCss.'</style>'.$customCss.'</div>';
		$breadcrumbHtml .= '</div>';

		$html .= '<div id="sgbb-breadcrumb-'.$breadcrumbId.'" class="sgbb-front-wrapper" '.$mainStyles.'>'.$breadcrumbHtml.'</div>';
		return $html;
	}

}
