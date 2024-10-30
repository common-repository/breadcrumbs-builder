function SGBB(){
	'use strict';
	this.init();
	SGBB.sgbbTheme1 = 1;
	SGBB.sgbbTheme2 = 2;
	SGBB.sgbbTheme3 = 3;
	SGBB.sgbbTheme4 = 4;
	SGBB.sgbbTheme5 = 5;
}

SGBB.prototype.init = function(){
	var that = this;

	if (SGBB.prototype.getURLParameter('edit')) {
		jQuery('<div class="updated notice notice-success is-dismissible below-h2">' +
				'<p>Breadcrumb updated.</p>' +
				'<button type="button" class="notice-dismiss" onclick="jQuery(\'.notice\').remove();"></button></div>').appendTo('.sgbb-top-bar h1');
	}
	/*wizard*/
	var navListItems = jQuery('ul.setup-panel li a'),
        sgrbAllWells = jQuery('.setup-content');

    sgrbAllWells.hide();

    navListItems.click(function(e)
    {
        e.preventDefault();
        var $target = jQuery(jQuery(this).attr('href')),
            $item = jQuery(this).closest('li');

        if (!$item.hasClass('disabled')) {
            navListItems.closest('li').removeClass('active');
            $item.addClass('active');
            sgrbAllWells.hide();
            $target.show();
        }
    });

    jQuery('ul.setup-panel li.active a').trigger('click');

    // DEMO ONLY //
    jQuery('#activate-step-2').on('click', function(e) {
        jQuery('ul.setup-panel li:eq(1)').removeClass('disabled');
        jQuery('ul.setup-panel li a[href="#step-2"]').trigger('click');
        jQuery(this).remove();
    })
	/*wizard*/

	jQuery('.sgbb-switcher').mousedown(function(){
		var selectedBreadcrumbId = jQuery(this).data('breadcrumb');
		if (jQuery(this).parent().hasClass('sgbb-switch-off-wrapper')) {
			jQuery(this).parent().addClass('sgbb-switch-on-wrapper');
			jQuery(this).parent().removeClass('sgbb-switch-off-wrapper');
			jQuery(this).parent().removeAttr('style');
			jQuery(this).parent().attr('style', 'float:left;');
			jQuery(this).parent().parent().removeAttr('style');
			jQuery(this).parent().parent().attr('style', 'background-color: #cccccc;');
			SGBB.ajaxTurnOff(selectedBreadcrumbId);
		}
		else if (jQuery(this).parent().hasClass('sgbb-switch-on-wrapper')) {
			jQuery(this).parent().addClass('sgbb-switch-off-wrapper');
			jQuery(this).parent().removeClass('sgbb-switch-on-wrapper');
			jQuery(this).parent().removeAttr('style');
			jQuery(this).parent().attr('style', 'float:right;');
			jQuery(this).parent().parent().removeAttr('style');
			jQuery(this).parent().parent().attr('style', 'background-color: #428BCA;');
			SGBB.ajaxTurnOn(selectedBreadcrumbId);
		}
	});

	if (jQuery('#sgbb-required-title-checkbox').is(':checked')) {
		jQuery('.sgbb-you-here-preview').show();
		jQuery('.sgbb-you-here-text').on('change keydown keyup',function(){
			var youAreHereText = jQuery(this).val();
			jQuery('.sgbb-you-here-preview').text(youAreHereText);
		});
	}
	else {
		jQuery('.sgbb-you-here-preview').hide();
	}

	if (jQuery('input[name=sgbb-id]').val()) {
		jQuery('.color-picker').each(function(){
			var color = jQuery(this).val();
			var pickerClass = jQuery(this).attr('class');
			if (color) {
				SGBB.colorOptionsLivePreview(color, pickerClass);
			}
		});
	}

	jQuery('.sgbb-home-hide-show-js').each(function(){
		if (jQuery(this).is(':checked')) {
			var homeTextIcon = jQuery(this).val();
			if (homeTextIcon == 'homeIcon') {
				jQuery('.sgbb-home-icon-preview').show();
				jQuery('.sgbb-home-text-preview').hide();
			}
			if (homeTextIcon == 'homeText') {
				jQuery('.sgbb-home-icon-preview').hide();
				jQuery('.sgbb-home-text-preview').show();
				jQuery('.sgbb-home-text-input').on('change keydown keyup',function(){
					var text = jQuery(this).val();
					jQuery('.sgbb-home-text-preview').text(text);
				});

			}
			if (homeTextIcon == 'both') {
				jQuery('.sgbb-home-icon-preview').show();
				jQuery('.sgbb-home-text-preview').show();
				jQuery('.sgbb-home-text-input').on('change keydown keyup',function(){
					var text = jQuery(this).val();
					jQuery('.sgbb-home-text-preview').text(text);
				});
			}
		}
	});

	jQuery('.sgbb-breadcrumbs-alignment').each(function(){
		if (jQuery(this).is(':checked')) {
			var alignment = jQuery(this).val();
			var hiddenStyle = 'display: none;';
			jQuery('.sgbb-themes-preview').each(function(){
				if (jQuery(this).is(':visible')) {
					if (alignment == 'left') {
						jQuery(this).attr('style', 'text-align: left;');
					}
					if (alignment == 'center') {
						jQuery(this).attr('style', 'text-align: center;');
					}
					if (alignment == 'right') {
						jQuery(this).attr('style', 'text-align: right;');
					}
				}
				else {
					if (alignment == 'left') {
						jQuery(this).attr('style', hiddenStyle+'text-align: left;');
					}
					if (alignment == 'center') {
						jQuery(this).attr('style', hiddenStyle+'text-align: center;');
					}
					if (alignment == 'right') {
						jQuery(this).attr('style', hiddenStyle+'text-align: right;');
					}
				}
			});
		}
	});

	jQuery('.sgbb-reset-js').click(function(){
		SGBB.resetOptions();
	});

	SGBB.livePreview();

	var youAreHereChecked = jQuery('.sgbb-you-here-checkbox');
	if (youAreHereChecked.is(':checked')) {
		jQuery('.sgbb-you-here-text').removeAttr('disabled');
	}
	else {
		jQuery('.sgbb-you-here-text').attr('disabled', 'disabled');
	}

	jQuery('.sgbb-hide-show-js').on('change', function(){
		var youAreHereChecked = jQuery('.sgbb-you-here-text');
		if (jQuery(this).is(':checked')) {
			youAreHereChecked.removeAttr('disabled');
		}
		else {
			youAreHereChecked.attr('disabled', 'disabled');
		}
	});

	jQuery('.sgbb-home-hide-show-js').on('change', function(){
		if (jQuery(this).val() == 'homeIcon') {
			jQuery('.sgbb-home-text-input').attr('disabled', 'disabled');
		}
		else {
			jQuery('.sgbb-home-text-input').removeAttr('disabled');
		}
	});

	jQuery('.sgbb-themes-radio').click(function(){
		var selectedType = jQuery(this).val();
		jQuery('.sgbb-themes-preview').hide();
		jQuery('.sgbb-theme-type-'+selectedType).show();
	});

	jQuery(function(){
		if(jQuery(".color-picker").length) {
			jQuery(".color-picker").wpColorPicker({
				change: function(event, ui){
					var pickerClass = jQuery(this).attr('class');
					var theColor = ui.color.toString();
					SGBB.colorOptionsLivePreview(theColor, pickerClass);
				}
			});
		}
	});

	jQuery('.sgbb-js-update').click(function(){
		that.save();
	});

	jQuery('.sgbb-position-image-js').each(function(){
		jQuery(this).mouseover(function(){
			jQuery(this).attr('style', 'opacity:0.5;');
			jQuery(this).parent().find('.sgbb-position-header-zoom').show();

			jQuery(this).click(function(){
			var image = jQuery(this).find('img').attr('src');
			jQuery('#sgbb-template').dialog({
				width:480,
				height: 550,
				modal: true,
				resizable: false
			});
			jQuery('#sgbb-layout-preview').attr('src', image);
		});

		}).mouseout(function(){
			jQuery(this).removeAttr('style').show();
			jQuery(this).parent().find('.sgbb-position-header-zoom').hide();
		});
	});


};

SGBB.prototype.save = function(){
	var isEdit = true;
	var sgbbError = false;
	var sgbbProVersion = jQuery('.sgbb-pro-version').val();
	var form = jQuery('.sgbb-js-form');

	if(jQuery('.sgbb-title-input').val().replace(/\s/g, "").length <= 0){
		sgbbError = 'Title field is required';
	}
	if (sgbbProVersion == 0) {
		jQuery('input[name=theme]').each(function(){
			if (jQuery(this).is(':checked')) {
				if (jQuery(this).val() > 5) {
					sgbbError = 'Current theme is available in PRO version';
				}
			}
		});
	}
	if (sgbbError) {
		alert(sgbbError);
		return;
	}

	var saveAction = 'Breadcrumb_ajaxSave';
	var ajaxHandler = new sgbbRequestHandler(saveAction, form.serialize());
	ajaxHandler.dataIsObject = false;
	ajaxHandler.dataType = 'html';
	var sgbbSaveUrl = jQuery('.sgbbSaveUrl').val();
	jQuery('.sgbb-loading-spinner').show();
	ajaxHandler.callback = function(response){
		/* If success */
		if(response) {
			jQuery('input[name=sgbb-id]').val(response);
			location.href=sgbbSaveUrl+"&id="+response+'&edit='+isEdit;
		}
		else {
			alert('The breadcrumb could not be save.');
		}
		jQuery('.sgbb-loading-spinner').hide();

	};
	ajaxHandler.run();
};

SGBB.ajaxDelete = function(id){
	if (confirm('Are you sure?')) {
		var deleteAction = 'Breadcrumb_ajaxDelete';
		var ajaxHandler = new sgbbRequestHandler(deleteAction, {id: id});
		ajaxHandler.dataType = 'html';
		ajaxHandler.callback = function(response){
			/* If success */
			location.reload();
		};
		ajaxHandler.run();
	}
};

SGBB.ajaxTurnOn = function(id){
	var switchAction = 'Breadcrumb_ajaxTurnOn';
	var ajaxHandler = new sgbbRequestHandler(switchAction, {id: id});
	ajaxHandler.dataType = 'html';
	ajaxHandler.callback = function(response){
		/* If success */
		/*location.reload();*/
	};
	ajaxHandler.run();
};

SGBB.ajaxTurnOff = function(id){
	var switchAction = 'Breadcrumb_ajaxTurnOff';
	var ajaxHandler = new sgbbRequestHandler(switchAction, {id: id});
	ajaxHandler.dataType = 'html';
	ajaxHandler.callback = function(response){
		/* If success */
		/*location.reload();*/
	};
	ajaxHandler.run();
};

/**
 * getURLParameter() checked if it is create
 * or edit
 * @param params is boolean
 */
SGBB.prototype.getURLParameter = function (params) {
	var sPageURL = window.location.search.substring(1);
	var sURLVariables = sPageURL.split('&');
	for (var i = 0; i < sURLVariables.length; i++) {
		var sParameterName = sURLVariables[i].split('=');
		if (sParameterName[0] == params) {
			return sParameterName[1];
		}
	}
};

SGBB.colorOptionsLivePreview = function(color, pickerClass){
	var backgroundStyleWrapper = '';
	var backgroundHoverStyleWrapper = '';
	var textStyleWrapper = '';
	var textHoverStyleWrapper = '';
	if (pickerClass.match('sgbb-background-preview')) {
		backgroundStyleWrapper = '<style>'+
								'.sgbb-theme-type-1 .sgbb-main-wrapper ul li a,'+
								'.sgbb-theme-type-1 .sgbb-main-wrapper li a:hover::before,'+
								'.sgbb-theme-type-2 .sgbb-main-wrapper ul li a,'+
								'.sgbb-theme-type-3 .sgbb-main-wrapper ul li a,'+
								'.sgbb-theme-type-4 .sgbb-main-wrapper ul li a,'+
								'.sgbb-theme-type-5 .sgbb-main-wrapper ul li a,'+
								'.sgbb-theme-type-6 .sgbb-main-wrapper ul li a,'+
								'.sgbb-theme-type-7 ul li:not(:last-child) a,'+
								'.sgbb-theme-type-8 .sgbb-main-wrapper ul li a,'+
								'.sgbb-theme-type-9 .sgbb-main-wrapper ul li a,'+
								'.sgbb-theme-type-10 .sgbb-main-wrapper ul li a {'+
									'background-color: '+color+';'+
								'}'+
								'.sgbb-theme-type-6 .sgbb-ul-list-wrapper li a:after,'+
								'.sgbb-theme-type-7 ul li:not(:last-child) a:after {'+
									'border-left: 24px solid '+color+';'+
								'}'+
								'.sgbb-theme-type-1 .sgbb-main-wrapper ul li a:after,'+
								'.sgbb-theme-type-2 .sgbb-main-wrapper ul li a:after,'+
								'.sgbb-theme-type-3 .sgbb-main-wrapper ul li a:after,'+
								'.sgbb-theme-type-4 .sgbb-main-wrapper ul li a:after,'+
								'.sgbb-theme-type-5 .sgbb-main-wrapper ul li a:after,'+
								'.sgbb-theme-type-8 .sgbb-main-wrapper ul li a:after,'+
								'.sgbb-theme-type-9 .sgbb-main-wrapper ul li a:after {'+
									'background-color: '+color+';'+
									'border-color: '+color+';'+
								'}'+
								'.sgbb-main-wrapper .sgbb-ul-list-wrapper li:last-child a:before {'+
									'background-color: '+color+';'+
									'border-color: '+color+';'+
								'}'+
								'.sgbb-theme-type-10 .sgbb-main-wrapper .sgbb-ul-list-wrapper li:not(:last-child) a:after {'+
									'background-color: '+color+';'+
								'}'+
								'.sgbb-main-wrapper .sgbb-separator {'+
									'background-color: '+color+';'+
								'}'+
								'</style>';
	}
	if (pickerClass.match('sgbb-background-hover-preview')) {
		backgroundHoverStyleWrapper = '<style>'+
								'.sgbb-main-wrapper li:not(:last-child) a:hover {'+
									'background-color: '+color+';'+
									'border-color: '+color+';'+
								'}'+
								'.sgbb-main-wrapper .sgbb-ul-list-wrapper li:not(:last-child) a:hover,'+
								'.sgbb-theme-type-1 .sgbb-main-wrapper li a:hover::after,'+
								'.sgbb-theme-type-2 .sgbb-main-wrapper .sgbb-ul-list-wrapper li:not(:last-child) a:hover:after,'+
								'.sgbb-theme-type-10 .sgbb-main-wrapper .sgbb-ul-list-wrapper li:not(:last-child) a:hover:after {'+
									'background-color: '+color+';'+
								'}'+
								'.sgbb-main-wrapper li:last-child a:hover:before {'+
									'background-color: '+color+';'+
									'border-color: '+color+';'+
								'}'+
								'.sgbb-theme-type-6 .sgbb-ul-list-wrapper li a:hover:after,'+
								'.sgbb-theme-type-7 ul li a:hover:after {'+
									'border-left: 24px solid '+color+';'+
								'}'+
								'.sgbb-main-wrapper .sgbb-you-here {'+
									'background-color: '+color+' !important;'+
								'}'+
								'</style>';
	}
	if (pickerClass.match('sgbb-text-preview')) {
		textStyleWrapper = '<style>.sgbb-main-wrapper li:not(:last-child) a {'+
									'color: '+color+' !important;'+
								'}'+
								'.sgbb-themes-preview .sgbb-main-wrapper li a:after {'+
									'color: '+color+';'+
								'}'+
								'.sgbb-main-wrapper li:last-child a:before {'+
									'color: '+color+';'+
								'}'+
								'</style>';
	}
	if (pickerClass.match('sgbb-text-hover-preview')) {
		textHoverStyleWrapper = '<style>.sgbb-main-wrapper li:not(:last-child) a:hover {'+
									'color: '+color+' !important;'+
								'}'+
								'.sgbb-themes-preview .sgbb-main-wrapper li a:hover:after {'+
									'color: '+color+' !important;'+
								'}'+
								'.sgbb-main-wrapper li:last-child a:hover:before {'+
									'color: '+color+' !important;'+
								'}'+
								'.sgbb-main-wrapper .sgbb-you-here {'+
									'color: '+color+' !important;'+
								'}'+
								'</style>';
	}

	if (backgroundStyleWrapper) {
		jQuery(backgroundStyleWrapper).appendTo('.sgbb-backgound-live-preview-wrapper');
	}
	if (backgroundHoverStyleWrapper) {
		jQuery(backgroundHoverStyleWrapper).appendTo('.sgbb-backgound-hover-live-preview-wrapper');
	}
	if (textStyleWrapper) {
		jQuery(textStyleWrapper).appendTo('.sgbb-text-live-preview-wrapper');
	}
	if (textHoverStyleWrapper) {
		jQuery(textHoverStyleWrapper).appendTo('.sgbb-text-hover-live-preview-wrapper');
	}
};

SGBB.resetOptions = function(){
	if (confirm('Are you sure?')) {
		jQuery('input[name=tabBackgroundColor]').val('');
		jQuery('input[name=tabHoverColor]').val('');
		jQuery('input[name=tabTextColor]').val('');
		jQuery('input[name=tabTextHoverColor]').val('');
		jQuery('.wp-color-result').css('background-color','');
		jQuery('.sgbb-backgound-live-preview-wrapper').empty();
		jQuery('.sgbb-backgound-hover-live-preview-wrapper').empty();
		jQuery('.sgbb-text-live-preview-wrapper').empty();
		jQuery('.sgbb-text-hover-live-preview-wrapper').empty();
	}
};

SGBB.livePreview = function(){
	jQuery('#sgbb-required-title-checkbox').change(function(){
		if (jQuery(this).is(':checked')) {
			jQuery('.sgbb-you-here-preview').show();
			jQuery('.sgbb-you-here-text').on('change keydown keyup',function(){
				var youAreHereText = jQuery(this).val();
				jQuery('.sgbb-you-here-preview').text(youAreHereText);
			});
		}
		else {
			jQuery('.sgbb-you-here-preview').hide();
		}
	});
	jQuery('.sgbb-home-hide-show-js').change(function(){
		var homeTextIcon = jQuery(this).val();
		if (homeTextIcon == 'homeIcon') {
			jQuery('.sgbb-home-icon-preview').show();
			jQuery('.sgbb-home-text-preview').hide();
		}
		if (homeTextIcon == 'homeText') {
			jQuery('.sgbb-home-icon-preview').hide();
			jQuery('.sgbb-home-text-preview').show();
			jQuery('.sgbb-home-text-input').on('change keydown keyup',function(){
				var text = jQuery(this).val();
				jQuery('.sgbb-home-text-preview').text(text);
			});

		}
		if (homeTextIcon == 'both') {
			jQuery('.sgbb-home-icon-preview').show();
			jQuery('.sgbb-home-text-preview').show();
			jQuery('.sgbb-home-text-input').on('change keydown keyup',function(){
				var text = jQuery(this).val();
				jQuery('.sgbb-home-text-preview').text(text);
			});
		}
	});
	jQuery('.sgbb-breadcrumbs-alignment').change(function(){
		var alignment = jQuery(this).val();
		var hiddenStyle = 'display: none;';
		jQuery('.sgbb-themes-preview').each(function(){
			if (jQuery(this).is(':visible')) {
				if (alignment == 'left') {
					jQuery(this).attr('style', 'text-align: left;');
				}
				if (alignment == 'center') {
					jQuery(this).attr('style', 'text-align: center;');
				}
				if (alignment == 'right') {
					jQuery(this).attr('style', 'text-align: right;');
				}
			}
			else {
				if (alignment == 'left') {
					jQuery(this).attr('style', hiddenStyle+'text-align: left;');
				}
				if (alignment == 'center') {
					jQuery(this).attr('style', hiddenStyle+'text-align: center;');
				}
				if (alignment == 'right') {
					jQuery(this).attr('style', hiddenStyle+'text-align: right;');
				}
			}
		});
	});
};
