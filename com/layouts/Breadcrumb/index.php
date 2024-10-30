<div class="wrap">
	<h2>
		<?php _e('Breadcrumbs', 'sgbb'); ?>
		<a href="<?php echo @esc_attr($createNewUrl);?>" class="page-title-action add-new-h2"><?php echo _e('Add new', 'sgbb'); ?></a>

		<?php if (!SGBB_PRO_VERSION) : ?>
	    	<input class="sgbb-upgrade-input" type="button" value="Upgrade to PRO version" onclick="window.open('<?php echo SGBB_PRO_URL;?>')">
	    <?php endif;?>
    </h2>
	<?php echo @esc_attr($review); ?>
</div>