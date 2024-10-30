<?php
	global $sgbb;
	$sgbb->includeStyle('page/styles/jquery-ui-dialog');
	$sgbb->includeScript('core/scripts/jquery-ui-dialog');
	$themesCss = array();
	$index = 1;
	foreach ($sgbbThemes as $sgbbTheme) {
		$themesCss[$index] = '<style> '.$sgbbTheme->getBb_css().'</style>';
		$index++;
	}
?>
<div class="wrap">
<form class="sgbb-js-form">
	<div class="container-fluid">
		<div class="sgbb-top-bar">
			<input type="hidden" class="sgbbSaveUrl" value="<?php echo esc_attr($sgbbSaveUrl);?>">
			<h1 class="sgbb-add-edit-title">
				<?php echo (@$sgbbBrCrumb->getId() != 0) ? _e('Edit Breadcrumb', 'sgbb') : _e('Add New Breadcrumb', 'sgbb');?>
				<span class="sgbb-spinner-save-button-wrapper">
					<i class="sgbb-loading-spinner"><img src='<?php echo $sgbb->app_url.'/assets/page/img/spinner-2x.gif';?>'></i>
					<a href="javascript:void(0)"
						class="sgbb-js-update btn btn-sm btn-primary sgbb-pull-right"> <?php _e('Save changes', 'sgbb'); ?></a>
				</span>
			</h1>
			<input class="sgbb-text-input sgbb-title-input" value="<?php echo esc_attr(@$sgbbDataArray['title']); ?>"
					type="text" autofocus name="sgbb-title" placeholder="<?php _e('Enter title here', 'sgbb'); ?>">
		</div>
		<input type="hidden" name="sgbb-id" value="<?php echo esc_attr(@$_GET['id']); ?>">
		<input type="hidden" class="sgbb-pro-version" name="sgbb-pro-version" value="<?php echo SGBB_PRO_VERSION; ?>">
		<input class="sgbb-link" type="hidden" data-href="<?php echo esc_attr(@$sgbb->app_url);?>">

		<div class="sgbb-wiz-wrapper">
		<div class="row">
			<div class="col-xs-12">
				<ul class="nav nav-pills nav-justified thumbnail setup-panel">
					<li class="active"><a href="#step-1">
						<h4 class="list-group-item-heading">Step 1</h4>
						<p class="list-group-item-text">Select theme</p>
					</a></li>
					<li class=""><a href="#step-2">
						<h4 class="list-group-item-heading">Step 2</h4>
						<p class="list-group-item-text">Setup options</p>
					</a></li>
					<li class=""><a href="#step-3">
						<h4 class="list-group-item-heading">Step 3</h4>
						<p class="list-group-item-text">Set position on the page</p>
					</a></li>
				</ul>
			</div>
		</div>

		<div class="row">
			<div class="col-md-12">
				<h4 style="margin: 0 30px;">Live Preview</h4>
			</div>
		</div>
		<div class="row">
			<div class="col-md-12">
				<div class="sgbb-theme-box-content">
					<div class="sgbb-themes-preview sgbb-theme-type-1"<?php echo (($sgbbBrCrumbId && $sgbbDataArray['theme'] == SGBB_THEME_1) || !$sgbbBrCrumbId) ? '' : ' style="display: none;"';?>>
						<div class="sgbb-btn-group sgbb-main-wrapper">
							<ul class="sgbb-ul-list-wrapper">
								<li><a class="sgbb-btn sgbb-btn-default sgbb-label-link" href="#">
										<span class="sgbb-you-here-preview" <?php echo (@$sgbbDataArray['addYouHere']) ? '' : ' style="display:none;"';?>>You are here:</span>
										<i class="dashicons dashicons-admin-home sgbb-home-icon sgbb-home-icon-preview"<?php echo (@$sgbbDataArray['addHomeText'] == '' && @$sgbbDataArray['addHomeAndText'] == '' && $sgbbBrCrumbId != 0) ? '' : 'display:none;';?>></i>
										<span class="sgbb-home-text-preview"<?php echo (@$sgbbDataArray['addHomeText'] && @$sgbbDataArray['addHomeAndText'] != 2 && $sgbbBrCrumbId != 0) ? '' : 'style="display:none;"';?>>Home</span>
									</a></li>
								<li><a class="sgbb-btn sgbb-btn-default sgbb-label-link" href="#"><span>Label 1</span></a></li>
								<li><a class="sgbb-btn sgbb-btn-default sgbb-label-link" href="#"><span>Label 2</span></a></li>
								<li><a class="sgbb-btn sgbb-btn-default sgbb-label-link sgbb-you-here" href="#"><span>Label 3</span></a></li>
							</ul>
						</div>
						<div class="sgbb-themes-preview-css">
							<?php echo $themesCss[1];?>
						</div>
					</div>
					<div class="sgbb-themes-preview sgbb-theme-type-2"<?php echo ($sgbbBrCrumbId && $sgbbDataArray['theme'] == SGBB_THEME_2) ? '' : ' style="display: none;"';?>>
						<div class="sgbb-btn-group sgbb-main-wrapper">
							<ul class="sgbb-ul-list-wrapper">
								<li><a class="sgbb-btn sgbb-btn-default sgbb-label-link" href="#">
										<span class="sgbb-you-here-preview" <?php echo (@$sgbbDataArray['addYouHere']) ? '' : ' style="display:none;"';?>>You are here:</span>
										<i class="dashicons dashicons-admin-home sgbb-home-icon sgbb-home-icon-preview"<?php echo (@$sgbbDataArray['addHomeText'] == '' && @$sgbbDataArray['addHomeAndText'] == '' && $sgbbBrCrumbId != 0) ? '' : 'display:none;';?>></i>
										<span class="sgbb-home-text-preview"<?php echo (@$sgbbDataArray['addHomeText'] && @$sgbbDataArray['addHomeAndText'] != 2 && $sgbbBrCrumbId != 0) ? '' : 'style="display:none;"';?>>Home</span>
									</a></li>
								<li><a class="sgbb-btn sgbb-btn-default sgbb-label-link" href="#"><span>Label 1</span></a></li>
								<li><a class="sgbb-btn sgbb-btn-default sgbb-label-link" href="#"><span>Label 2</span></a></li>
								<li><a class="sgbb-btn sgbb-btn-default sgbb-label-link sgbb-you-here" href="#"><span>Label 3</span></a></li>
							</ul>
						</div>
						<div class="sgbb-themes-preview-css" style="display: none;">
							<?php echo $themesCss[2];?>
						</div>
					</div>
					<div class="sgbb-themes-preview sgbb-theme-type-3"<?php echo ($sgbbBrCrumbId && $sgbbDataArray['theme'] == SGBB_THEME_3) ? '' : ' style="display: none;"';?>>
						<div class="sgbb-btn-group sgbb-main-wrapper">
							<ul class="sgbb-ul-list-wrapper">
								<li><a class="sgbb-btn sgbb-btn-default sgbb-label-link" href="#">
										<span class="sgbb-you-here-preview" <?php echo (@$sgbbDataArray['addYouHere']) ? '' : ' style="display:none;"';?>>You are here:</span>
										<i class="dashicons dashicons-admin-home sgbb-home-icon sgbb-home-icon-preview"<?php echo (@$sgbbDataArray['addHomeText'] == '' && @$sgbbDataArray['addHomeAndText'] == '' && $sgbbBrCrumbId != 0) ? '' : 'display:none;';?>></i>
										<span class="sgbb-home-text-preview"<?php echo (@$sgbbDataArray['addHomeText'] && @$sgbbDataArray['addHomeAndText'] != 2 && $sgbbBrCrumbId != 0) ? '' : 'style="display:none;"';?>>Home</span>
									</a>
										<span class="sgbb-separator"> / </span>
									</li>
								<li><a class="sgbb-btn sgbb-btn-default sgbb-label-link" href="#"><span>Label 1</span></a><span class="sgbb-separator"> / </span></li>
								<li><a class="sgbb-btn sgbb-btn-default sgbb-label-link" href="#"><span>Label 2</span></a><span class="sgbb-separator"> / </span></li>
								<li><a class="sgbb-btn sgbb-btn-default sgbb-label-link sgbb-you-here" href="#"><span>Label 3</span></a></li>
							</ul>
						</div>
						<div class="sgbb-themes-preview-css" style="display: none;">
							<?php echo $themesCss[3];?>
						</div>
					</div>
					<div class="sgbb-themes-preview sgbb-theme-type-4"<?php echo ($sgbbBrCrumbId && $sgbbDataArray['theme'] == SGBB_THEME_4) ? '' : ' style="display: none;"';?>>
						<div class="sgbb-btn-group sgbb-main-wrapper">
							<ul class="sgbb-ul-list-wrapper">
								<li><a class="sgbb-btn sgbb-btn-default sgbb-label-link" href="#">
										<span class="sgbb-you-here-preview" <?php echo (@$sgbbDataArray['addYouHere']) ? '' : ' style="display:none;"';?>>You are here:</span>
										<i class="dashicons dashicons-admin-home sgbb-home-icon sgbb-home-icon-preview"<?php echo (@$sgbbDataArray['addHomeText'] == '' && @$sgbbDataArray['addHomeAndText'] == '' && $sgbbBrCrumbId != 0) ? '' : 'display:none;';?>></i>
										<span class="sgbb-home-text-preview"<?php echo (@$sgbbDataArray['addHomeText'] && @$sgbbDataArray['addHomeAndText'] != 2 && $sgbbBrCrumbId != 0) ? '' : 'style="display:none;"';?>>Home</span>
									</a></li>
								<li><a class="sgbb-btn sgbb-btn-default sgbb-label-link" href="#"><span>Label 1</span></a></li>
								<li><a class="sgbb-btn sgbb-btn-default sgbb-label-link" href="#"><span>Label 2</span></a></li>
								<li><a class="sgbb-btn sgbb-btn-default sgbb-label-link sgbb-you-here" href="#"><span>Label 3</span></a></li>
							</ul>
						</div>
						<div class="sgbb-themes-preview-css" style="display: none;">
							<?php echo $themesCss[4];?>
						</div>
					</div>
					<div class="sgbb-themes-preview sgbb-theme-type-5"<?php echo ($sgbbBrCrumbId && $sgbbDataArray['theme'] == SGBB_THEME_5) ? '' : ' style="display: none;"';?>>
						<div class="sgbb-btn-group sgbb-main-wrapper">
							<ul class="sgbb-ul-list-wrapper">
								<li><a class="sgbb-btn sgbb-btn-default sgbb-label-link" href="#">
										<span class="sgbb-you-here-preview" <?php echo (@$sgbbDataArray['addYouHere']) ? '' : ' style="display:none;"';?>>You are here:</span>
										<i class="dashicons dashicons-admin-home sgbb-home-icon sgbb-home-icon-preview"<?php echo (@$sgbbDataArray['addHomeText'] == '' && @$sgbbDataArray['addHomeAndText'] == '' && $sgbbBrCrumbId != 0) ? '' : 'display:none;';?>></i>
										<span class="sgbb-home-text-preview"<?php echo (@$sgbbDataArray['addHomeText'] && @$sgbbDataArray['addHomeAndText'] != 2 && $sgbbBrCrumbId != 0) ? '' : 'style="display:none;"';?>>Home</span>
									</a>
									<span class="sgbb-separator"> &raquo; </span>
									</li>
								<li><a class="sgbb-btn sgbb-btn-default sgbb-label-link" href="#"><span>Label 1</span></a><span class="sgbb-separator"> &raquo; </span></li>
								<li><a class="sgbb-btn sgbb-btn-default sgbb-label-link" href="#"><span>Label 2</span></a><span class="sgbb-separator"> &raquo; </span></li>
								<li><a class="sgbb-btn sgbb-btn-default sgbb-label-link sgbb-you-here" href="#"><span>Label 3</span></a></li>
							</ul>
						</div>
						<div class="sgbb-themes-preview-css" style="display: none;">
							<?php echo $themesCss[5];?>
						</div>
					</div>
					<div class="sgbb-themes-preview sgbb-theme-type-6"<?php echo (@$sgbbBrCrumbId && @$sgbbDataArray['theme'] == SGBB_THEME_6) ? '' : ' style="display: none;"';?>>
						<div class="sgbb-btn-group sgbb-main-wrapper">
							<ul class="sgbb-ul-list-wrapper">
								<li><a class="sgbb-btn sgbb-btn-default sgbb-label-link sgbb-home-link" href="#">
										<span class="sgbb-you-here-preview" <?php echo (@$sgbbDataArray['addYouHere']) ? '' : ' style="display:none;"';?>>You are here:</span>
										<i class="dashicons dashicons-admin-home sgbb-home-icon sgbb-home-icon-preview"<?php echo (@$sgbbDataArray['addHomeText'] == '' && @$sgbbDataArray['addHomeAndText'] == '' && $sgbbBrCrumbId != 0) ? '' : 'display:none;';?>></i>
										<span class="sgbb-home-text-preview"<?php echo (@$sgbbDataArray['addHomeText'] && @$sgbbDataArray['addHomeAndText'] != 2 && $sgbbBrCrumbId != 0) ? '' : 'style="display:none;"';?>>Home</span>
									</a></li>
								<li><a class="sgbb-btn sgbb-btn-default sgbb-label-link" href="#"><span>Label 1</span></a></li>
								<li><a class="sgbb-btn sgbb-btn-default sgbb-label-link" href="#"><span>Label 2</span></a></li>
								<li><a class="sgbb-btn sgbb-btn-default sgbb-label-link sgbb-you-here" href="#"><span>Label 3</span></a></li>
							</ul>
						</div>
						<div class="sgbb-themes-preview-css" style="display: none;">
							<?php echo $themesCss[6];?>
						</div>
					</div>
					<div class="sgbb-themes-preview sgbb-theme-type-7"<?php echo (@$sgbbBrCrumbId && @$sgbbDataArray['theme'] == SGBB_THEME_7) ? '' : ' style="display: none;"';?>>
						<div class="sgbb-btn-group sgbb-main-wrapper">
							<ul class="sgbb-ul-list-wrapper">
								<li><a class="sgbb-btn sgbb-btn-default sgbb-label-link sgbb-home-link" href="#">
										<span class="sgbb-you-here-preview" <?php echo (@$sgbbDataArray['addYouHere']) ? '' : ' style="display:none;"';?>>You are here:</span>
										<i class="dashicons dashicons-admin-home sgbb-home-icon sgbb-home-icon-preview"<?php echo (@$sgbbDataArray['addHomeText'] == '' && @$sgbbDataArray['addHomeAndText'] == '' && $sgbbBrCrumbId != 0) ? '' : 'display:none;';?>></i>
										<span class="sgbb-home-text-preview"<?php echo (@$sgbbDataArray['addHomeText'] && @$sgbbDataArray['addHomeAndText'] != 2 && $sgbbBrCrumbId != 0) ? '' : 'style="display:none;"';?>>Home</span>
									</a></li>
								<li><a class="sgbb-btn sgbb-btn-default sgbb-label-link" href="#"><span>Label 1</span></a></li>
								<li><a class="sgbb-btn sgbb-btn-default sgbb-label-link" href="#"><span>Label 2</span></a></li>
								<li><a class="sgbb-btn sgbb-btn-default sgbb-label-link sgbb-you-here" href="#"><span>Label 3</span></a></li>
							</ul>
						</div>
						<div class="sgbb-themes-preview-css" style="display: none;">
							<?php echo $themesCss[7];?>
						</div>
					</div>
					<div class="sgbb-themes-preview sgbb-theme-type-8"<?php echo (@$sgbbBrCrumbId && @$sgbbDataArray['theme'] == SGBB_THEME_8) ? '' : ' style="display: none;"';?>>
						<div class="sgbb-btn-group sgbb-main-wrapper">
							<ul class="sgbb-ul-list-wrapper">
								<li><a class="sgbb-btn sgbb-btn-default sgbb-label-link sgbb-home-link" href="#">
										<span class="sgbb-you-here-preview" <?php echo (@$sgbbDataArray['addYouHere']) ? '' : ' style="display:none;"';?>>You are here:</span>
										<i class="dashicons dashicons-admin-home sgbb-home-icon sgbb-home-icon-preview"<?php echo (@$sgbbDataArray['addHomeText'] == '' && @$sgbbDataArray['addHomeAndText'] == '' && $sgbbBrCrumbId != 0) ? '' : 'display:none;';?>></i>
										<span class="sgbb-home-text-preview"<?php echo (@$sgbbDataArray['addHomeText'] && @$sgbbDataArray['addHomeAndText'] != 2 && $sgbbBrCrumbId != 0) ? '' : 'style="display:none;"';?>>Home</span>
									</a></li>
								<li><a class="sgbb-btn sgbb-btn-default sgbb-label-link" href="#"><span>Label 1</span></a></li>
								<li><a class="sgbb-btn sgbb-btn-default sgbb-label-link" href="#"><span>Label 2</span></a></li>
								<li><a class="sgbb-btn sgbb-btn-default sgbb-label-link sgbb-you-here" href="#"><span>Label 3</span></a></li>
							</ul>
						</div>
						<div class="sgbb-themes-preview-css" style="display: none;">
							<?php echo $themesCss[8];?>
						</div>
					</div>
					<div class="sgbb-themes-preview sgbb-theme-type-9"<?php echo (@$sgbbBrCrumbId && @$sgbbDataArray['theme'] == SGBB_THEME_9) ? '' : ' style="display: none;"';?>>
						<div class="sgbb-btn-group sgbb-main-wrapper">
							<ul class="sgbb-ul-list-wrapper">
								<li><a class="sgbb-btn sgbb-btn-default sgbb-label-link sgbb-home-link" href="#">
										<span class="sgbb-you-here-preview" <?php echo (@$sgbbDataArray['addYouHere']) ? '' : ' style="display:none;"';?>>You are here:</span>
										<i class="dashicons dashicons-admin-home sgbb-home-icon sgbb-home-icon-preview"<?php echo (@$sgbbDataArray['addHomeText'] == '' && @$sgbbDataArray['addHomeAndText'] == '' && $sgbbBrCrumbId != 0) ? '' : 'display:none;';?>></i>
										<span class="sgbb-home-text-preview"<?php echo (@$sgbbDataArray['addHomeText'] && @$sgbbDataArray['addHomeAndText'] != 2 && $sgbbBrCrumbId != 0) ? '' : 'style="display:none;"';?>>Home</span>
									</a></li>
								<li><a class="sgbb-btn sgbb-btn-default sgbb-label-link" href="#"><span>Label 1</span></a></li>
								<li><a class="sgbb-btn sgbb-btn-default sgbb-label-link" href="#"><span>Label 2</span></a></li>
								<li><a class="sgbb-btn sgbb-btn-default sgbb-label-link sgbb-you-here" href="#"><span>Label 3</span></a></li>
							</ul>
						</div>
						<div class="sgbb-themes-preview-css" style="display: none;">
							<?php echo $themesCss[9];?>
						</div>
					</div>
					<div class="sgbb-themes-preview sgbb-theme-type-10"<?php echo (@$sgbbBrCrumbId && @$sgbbDataArray['theme'] == SGBB_THEME_10) ? '' : ' style="display: none;"';?>>
						<div class="sgbb-btn-group sgbb-main-wrapper">
							<ul class="sgbb-ul-list-wrapper">
								<li><a class="sgbb-btn sgbb-btn-default sgbb-label-link sgbb-home-link" href="#">
										<span class="sgbb-you-here-preview" <?php echo (@$sgbbDataArray['addYouHere']) ? '' : ' style="display:none;"';?>>You are here:</span>
										<i class="dashicons dashicons-admin-home sgbb-home-icon sgbb-home-icon-preview"<?php echo (@$sgbbDataArray['addHomeText'] == '' && @$sgbbDataArray['addHomeAndText'] == '' && $sgbbBrCrumbId != 0) ? '' : 'display:none;';?>></i>
										<span class="sgbb-home-text-preview"<?php echo (@$sgbbDataArray['addHomeText'] && @$sgbbDataArray['addHomeAndText'] != 2 && $sgbbBrCrumbId != 0) ? '' : 'style="display:none;"';?>>Home</span>
									</a></li>
								<li><a class="sgbb-btn sgbb-btn-default sgbb-label-link" href="#"><span>Label 1</span></a></li>
								<li><a class="sgbb-btn sgbb-btn-default sgbb-label-link" href="#"><span>Label 2</span></a></li>
								<li><a class="sgbb-btn sgbb-btn-default sgbb-label-link sgbb-you-here" href="#"><span>Label 3</span></a></li>
							</ul>
						</div>
						<div class="sgbb-themes-preview-css" style="display: none;">
							<?php echo $themesCss[10];?>
						</div>
					</div>
					<?php if (!SGBB_PRO_VERSION) :?>
						<p class="howto sgrb-how-to" style="text-align: left;">
							<?php echo _e('( * ) - available in PRO.', 'sgbb');?>
						</p>
					<?php endif;?>
					<div class="sgbb-backgound-live-preview-wrapper"></div>
					<div class="sgbb-backgound-hover-live-preview-wrapper"></div>
					<div class="sgbb-text-live-preview-wrapper"></div>
					<div class="sgbb-text-hover-live-preview-wrapper"></div>
				</div>
			</div>
		</div>


	<div class="row setup-content" id="step-1">
		<div class="col-xs-12">
			<div class="col-md-12">
				<div class="row" style="border-bottom:1px solid #ccc;padding-bottom:15px;margin-bottom:15px;">
					<div class="col-md-12">
						<h1> Select theme </h1>
					</div>
				</div>
				<div class="row">
					<div class="col-md-12">
						<div class="sgbb-themes-wrapper">
							<?php if (!empty($sgbbThemes)):?>
								<div class="row">
									<?php foreach ($sgbbThemes as $theme) :?>
										<div class="col-md-2">
											<input id="sgbb-theme-<?=$theme->getId()?>" class="sgbb-themes-radio" type="radio" name="theme" value="<?=$theme->getId()?>"<?php echo (@$sgbbDataArray['theme'] == $theme->getId()) ? ' checked' : '';?><?php echo (!$sgbbBrCrumbId && $theme->getId() == SGBB_THEME_1) ? ' checked' : '';?> style="margin: 0">
											<label for="sgbb-theme-<?=$theme->getId()?>" class="sgbb-themes-label">
												<?php if (!SGBB_PRO_VERSION && $theme->getId() > 5) :?>
													<span class="sgbb-uppercase sgrb-how-to"><?=$theme->getTitle(); ?>*</span>
												<?php else :?>
													<span class="sgbb-uppercase"><?=$theme->getTitle(); ?></span>
												<?php endif ;?>
											</label>
										</div>

									<?php endforeach; ?>

								</div>
							<?php endif;?>
						</div>
					</div>
				</div>
				<div class="row">
					<div class="col-md-12">
						<?php if (SGBB_PRO_VERSION == 1) :?>
							<?php require_once('colorOptionsPro.php');?>
						<?php else :?>
							<div style='position: relative;'>
								<div class="sgbb-version"><input type="button" class="sgbb-upgrade-button" value="Upgrade to PRO version" onclick="window.open('<?php echo SGBB_PRO_URL;?>')"></div>
								<div class="sgbb-color-options-wrapper">
									<div class="sg-box-title">
										<?php echo _e('Color options', 'sgbb');?>
										<a href="javascript:void(0)" class="sgbb-reset-options sgbb-reset-js button-small button"> <?php echo _e('Reset', 'sgbb');?></a>
									</div>
									<div class="sg-box-content">
										<div class="row">
											<div class="col-md-6">
												<div class="sgbb-total-color-options">
													<div class="sgbb-total-options-rows-rate-type">
														<p><b><?php echo _e('Tab background', 'sgbb');?>: </b></p>
														<span><input name="" type="text" class="color-picker" /></span>
													</div>
													<div class="sgbb-total-options-rows-rate-type">
														<p><b><?php echo _e('Tab background on mouse hover', 'sgbb');?>: </b></p>
														<span><input name="" type="text" class="color-picker" /></span>
													</div>
												</div>
											</div>
											<div class="col-md-6">
												<div class="sgbb-total-color-options">
													<div class="sgbb-total-options-rows-rate-type">
														<p><b><?php echo _e('Tab text', 'sgbb');?>: </b></p>
														<span><input name="" type="text" class="color-picker" /></span>
													</div>
													<div class="sgbb-total-options-rows-rate-type">
														<p><b><?php echo _e('Tab text on mouse hover', 'sgbb');?>: </b></p>
														<span><input name="" type="text" class="color-picker" /></span>
													</div>
												</div>
											</div>
										</div>
									</div>
								</div>
							</div>
						<?php endif;?>
					</div>
					</div>
				</div>
			</div>
		</div>

	<div class="row setup-content" id="step-2">
		<div class="col-xs-12">
			<div class="col-md-12">
				<div class="row">
					<div class="col-md-12">
						<div class="sgbb-require-options-fields">
							<div class="row">
								<div class="col-md-5 text-right">
									<label for="sgbb-required-title-checkbox"><?php echo _e('You are here title', 'sgbb');?></label>
								</div>
								<div class="col-md-1">
									<input id="sgbb-required-title-checkbox" class="sgbb-you-here-checkbox sgbb-hide-show-js" value="true" type="checkbox" name="addYouHereChecked"<?php echo (@$sgbbDataArray['addYouHereChecked']) ? ' checked' : '';?>>
								</div>
								<div class="col-md-5">
									<input type="text" name="addYouHere" placeholder="You are here" class="sgbb-you-here-text" value="<?php echo (@$sgbbDataArray['addYouHere'] && $sgbbBrCrumbId) ? $sgbbDataArray['addYouHere'] : 'You are here:';?>"<?php echo (!$sgbbBrCrumbId) ? ' disabled' : '';?> <?php echo ($sgbbBrCrumbId && @$sgbbDataArray['addYouHere']) ? '' : ' disabled';?>>
								</div>
							</div>
							<div class="row">
								<div class="col-md-5 text-right">
									<label for="sgbb-home-page-show"><?php echo _e('Show on home page', 'sgbb');?></label>
								</div>
								<div class="col-md-6">
									<input id="sgbb-home-page-show" type="checkbox" value="true" name="showOnHomePage"<?php echo (@$sgbbDataArray['showOnHomePage']) ? ' checked' : '';?>>
								</div>
							</div>
							<div class="row">
								<div class="col-md-12">
									<h4 style="border-bottom:1px solid #ccc"><?php echo _e('Home tab', 'sgbb');?></h4>
								</div>
							</div>
							<div class="row">
								<div class="col-md-5 text-right">
									<label for="sgbb-home-tab-default"><?php echo _e('Default home icon ', 'sgbb');?></label>
								</div>
								<div class="col-md-1">
									<input id="sgbb-home-tab-default" class="sgbb-home-hide-show-js" type="radio" name="addHome" value="homeIcon"<?php echo (@$sgbbDataArray['addHomeText'] == '' && @$sgbbDataArray['addHomeAndText'] == '' && $sgbbBrCrumbId != 0) ? ' checked' : '';?><?php echo (!$sgbbBrCrumbId) ? ' checked' : '';?>>
								</div>
								<div class="col-md-5">
									<code><i class="dashicons dashicons-admin-home sgbb-home-icon"></i></code>
								</div>
							</div>
							<div class="row">
								<div class="col-md-5 text-right">
									<label for="sgbb-home-tab-text"><?php echo _e('Text ', 'sgbb');?></label>
								</div>
								<div class="col-md-1">
									<input id="sgbb-home-tab-text" class="sgbb-home-hide-show-js" type="radio" name="addHome" value="homeText"<?php echo (@$sgbbDataArray['addHomeText'] && @$sgbbDataArray['addHomeAndText'] != 2 && $sgbbBrCrumbId != 0) ? ' checked' : '';?>>
								</div>
								<div class="col-md-5">
									<input class="sgbb-home-text-input" type="text" name="addHomeText" placeholder="Home" value="<?php echo (@$sgbbDataArray['addHomeText']) ? @$sgbbDataArray['addHomeText'] : 'Home';?>" class="sgbb-options-input-selectbox"<?php echo (!@$sgbbDataArray['addHomeText']) ? ' disabled' : '';?>>
								</div>
							</div>
							<div class="row">
								<div class="col-md-5 text-right">
									<label for="sgbb-home-tab-text-icon"><?php echo _e('Text and icon ', 'sgbb');?></label>
								</div>
								<div class="col-md-1">
									<input id="sgbb-home-tab-text-icon" class="sgbb-home-hide-show-js" type="radio" name="addHome" value="both"<?php echo (@$sgbbDataArray['addHomeText'] && @$sgbbDataArray['addHomeAndText'] == 2 && $sgbbBrCrumbId != 0) ? ' checked' : '';?>>
								</div>
							</div>

								<div class="row">
									<div class="col-md-12">
										<h4 style="border-bottom:1px solid #ccc;"><?php echo _e('Breadcrumb box alignment :', 'sgbb');?></h4>
									</div>
								</div>
								<div class="row">
									<div class="col-md-5 text-right">
										<label for="sgbb-align-left">
											<?php echo _e('Left', 'sgbb');?>
										</label>
									</div>
									<div class="col-md-6">
										<input id="sgbb-align-left" class="sgbb-breadcrumbs-alignment" type="radio" name="addAlignement" value="left"<?php echo (@$sgbbDataArray['addAlignement'] && @$sgbbDataArray['addAlignement'] == 'left' || (!$sgbbBrCrumbId)) ? ' checked' : '';?>>
									</div>
								</div>
								<div class="row">
									<div class="col-md-5 text-right">
										<label for="sgbb-align-center">
											<?php echo _e('Center', 'sgbb');?>
										</label>
									</div>
									<div class="col-md-6">
										<input id="sgbb-align-center" class="sgbb-breadcrumbs-alignment" type="radio" name="addAlignement" value="center"<?php echo (@$sgbbDataArray['addAlignement'] && @$sgbbDataArray['addAlignement'] == 'center') ? ' checked' : '';?>>
									</div>
								</div>
								<div class="row">
									<div class="col-md-5 text-right">
										<label for="sgbb-align-right">
											<?php echo _e('Right', 'sgbb');?>
										</label>
									</div>
									<div class="col-md-6">
										<input id="sgbb-align-right" class="sgbb-breadcrumbs-alignment" type="radio" name="addAlignement" value="right"<?php echo (@$sgbbDataArray['addAlignement'] && @$sgbbDataArray['addAlignement'] == 'right') ? ' checked' : '';?>>
									</div>
								</div>

								<div class="row">
									<div class="col-md-12">
										<h4 style="border-bottom:1px solid #ccc;"><?php echo _e('Margin:', 'sgbb');?></h4>
									</div>
								</div>

								<div class="row">
									<div class="col-md-5 text-right">
										<?php echo _e('Top:', 'sgbb');?>
									</div>
									<div class="col-md-1">
										<input class="sgbb-margin-input" type="text" name="addMarginTop" value="<?php echo (@$sgbbDataArray['addMarginTop']) ? $sgbbDataArray['addMarginTop'] : '' ;?>">
									</div>
									<div class="col-md-5">
										<select name="addMarginTopType">
											<option value="1" <?php echo (@$sgbbDataArray['addMarginTopType'] == 1) ? ' selected' : '' ;?>>px</option>
											<option value="2" <?php echo (@$sgbbDataArray['addMarginTopType'] == 2) ? ' selected' : '' ;?>>%</option>
										</select>
									</div>
								</div>

								<div class="row">
									<div class="col-md-5 text-right">
										<?php echo _e('Right:', 'sgbb');?>
									</div>
									<div class="col-md-1">
										<input class="sgbb-margin-input" type="text" name="addMarginRight" value="<?php echo (@$sgbbDataArray['addMarginRight']) ? $sgbbDataArray['addMarginRight'] : '' ;?>">
									</div>
									<div class="col-md-5">
										<select name="addMarginRightType">
											<option value="1" <?php echo (@$sgbbDataArray['addMarginRightType'] == 1) ? ' selected' : '' ;?>>px</option>
											<option value="2" <?php echo (@$sgbbDataArray['addMarginRightType'] == 2) ? ' selected' : '' ;?>>%</option>
										</select>
									</div>
								</div>
								<div class="row">
									<div class="col-md-5 text-right">
										<?php echo _e('Bottom:', 'sgbb');?>
									</div>
									<div class="col-md-1">
										<input class="sgbb-margin-input" type="text" name="addMarginBottom" value="<?php echo (@$sgbbDataArray['addMarginBottom']) ? $sgbbDataArray['addMarginBottom'] : '' ;?>">
									</div>
									<div class="col-md-5">
										<select name="addMarginBottomType">
											<option value="1" <?php echo (@$sgbbDataArray['addMarginBottomType'] == 1) ? ' selected' : '' ;?>>px</option>
											<option value="2" <?php echo (@$sgbbDataArray['addMarginBottomType'] == 2) ? ' selected' : '' ;?>>%</option>
										</select>
									</div>
								</div>
								<div class="row">
									<div class="col-md-5 text-right">
										<?php echo _e('Left:', 'sgbb');?>
									</div>
									<div class="col-md-1">
										<input class="sgbb-margin-input" type="text" name="addMarginLeft" value="<?php echo (@$sgbbDataArray['addMarginLeft']) ? $sgbbDataArray['addMarginLeft'] : '' ;?>">
									</div>
									<div class="col-md-5">
										<select name="addMarginLeftType">
											<option value="1" <?php echo (@$sgbbDataArray['addMarginLeftType'] == 1) ? ' selected' : '' ;?>>px</option>
											<option value="2" <?php echo (@$sgbbDataArray['addMarginLeftType'] == 2) ? ' selected' : '' ;?>>%</option>
										</select>
									</div>
								</div>

							</div>
					</div>
				</div>
			</div>
		</div>
	</div>
	<div class="row setup-content" id="step-3" style="overflow: hidden;">
		<div class="col-md-12">
			<div class="row">
				<div class="col-md-2 sgbb-position-relative text-right">
					<div class="sgbb-position-absolute">
						<i class="sgbb-position-header-zoom" style="display: none;"><img src='<?php echo $sgbb->app_url.'assets/page/img/zoom-in-layouts.gif';?>' width="50px" height="50px" style="padding-left: 45px;padding-top: 50px;"></i>
					</div>
					<i id="sgbb-position-content" class="sgbb-position-image-js"><img src='<?php echo $sgbb->app_url.'assets/page/img/content.png';?>' width="130px" height="142px"></i>
				</div>
				<div class="col-md-2">
					<div class="row sgbb-overflow-hidden">
						<div class="col-md-12">
							<label>
								<input type="checkbox" name="addPositionBefore" value="<?php echo SGBB_POSITION_BEFORE;?>"<?php echo (@$sgbbDataArray['addPositionBefore'] && $sgbbBrCrumbId) ? ' checked' : '';?>>
								<span><?=_e('Before', 'sgbb')?></span>
							</label>
						</div>
					</div>
					<div class="row sgbb-overflow-hidden">
						<div class="col-md-12">
							<label>
								<input type="checkbox" name="addPositionAfter" value="<?php echo SGBB_POSITION_AFTER;?>"<?php echo (@$sgbbDataArray['addPositionAfter'] && $sgbbBrCrumbId) ? ' checked' : '';?>>
								<span><?=_e('After', 'sgbb')?></span>
							</label>
						</div>
					</div>
				</div>
				<div class="col-md-2 sgbb-position-relative text-right">
					<div class="sgbb-position-absolute">
						<i class="sgbb-position-header-zoom" style="display: none;"><img src='<?php echo $sgbb->app_url.'assets/page/img/zoom-in-layouts.gif';?>' width="50px" height="50px" style="padding-left: 45px;padding-top: 50px;"></i>
					</div>
					<i id="sgbb-position-content" class="sgbb-position-image-js"><img src='<?php echo $sgbb->app_url.'assets/page/img/footer.png';?>' width="130px" height="142px"></i>
				</div>
				<div class="col-md-2">
					<div class="row sgbb-overflow-hidden">
						<div class="col-md-12">
							<label>
								<input type="checkbox" name="addPositionPrBottom" value="<?php echo SGBB_POSITION_BOTTOM_1;?>"<?php echo (@$sgbbDataArray['addPositionPrBottom'] && $sgbbBrCrumbId) ? ' checked' : '';?>>
								<span><?=_e('Primary footer', 'sgbb')?></span>
							</label>
						</div>
					</div>
					<div class="row sgbb-overflow-hidden">
						<div class="col-md-12">
							<label>
								<input type="checkbox" name="addPositionSeBottom" value="<?php echo SGBB_POSITION_BOTTOM_2;?>"<?php echo (@$sgbbDataArray['addPositionSeBottom'] && $sgbbBrCrumbId) ? ' checked' : '';?>>
								<span><?=_e('Secondary footer', 'sgbb')?></span>
							</label>
						</div>
					</div>
				</div>
				<div class="col-md-2 sgbb-position-relative text-right">
					<div class="sgbb-position-absolute">
						<i class="sgbb-position-header-zoom" style="display: none;"><img src='<?php echo $sgbb->app_url.'assets/page/img/zoom-in-layouts.gif';?>' width="50px" height="50px" style="padding-left: 45px;padding-top: 50px;"></i>
					</div>
					<i id="sgbb-position-header" class="sgbb-position-image-js"><img src='<?php echo $sgbb->app_url.'assets/page/img/header.png';?>' width="130px" height="142px"></i>
				</div>
				<div class="col-md-2">
					<div class="row sgbb-overflow-hidden">
						<div class="col-md-12">
							<label>
								<input type="checkbox" name="addPositionPrTop" value="<?php echo SGBB_POSITION_TOP_1;?>"<?php echo (@$sgbbDataArray['addPositionPrTop'] && $sgbbBrCrumbId) ? ' checked' : '';?>>
								<span><?=_e('Primary header', 'sgbb')?></span>
							</label>
						</div>
					</div>
					<div class="row sgbb-overflow-hidden">
						<div class="col-md-12">
							<label>
								<input type="checkbox" name="addPositionSeTop" value="<?php echo SGBB_POSITION_TOP_2;?>"<?php echo (@$sgbbDataArray['addPositionSeTop'] && $sgbbBrCrumbId) ? ' checked' : '';?>>
								<span><?=_e('Secondary header', 'sgbb')?></span>
							</label>
						</div>
					</div>
				</div>
			</div>
		</div>
		<div class="row">
			<div class="col-md-12" style="margin: 10px 30px;">
				<p class="howto"><?=_e('Note: The offered positions may differ depending on your theme', 'sgbb')?></p>
				<p class="howto sgrb-how-to"><?=_e('Important: The Breadcrumb bar automatically appears on your pages after you save it. There is no need to go and insert on specific pages manually', 'sgbb')?></p>
			</div>
		</div>
	</div>
	</div>
	</div>

	</form>
</div>

<div id="sgbb-template" title="Breadcrumb position preview">
	<i>
		<img id="sgbb-layout-preview" src="" width="450px" height="490px">
	</i>
</div>
