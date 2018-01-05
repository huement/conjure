(function( $ ) {

    $(function() {
    	/*
    	**	Add Color Picker to all inputs that have 'color-field' class
    	*/
        $('.color-field').wpColorPicker({defaultColor: false});

    	/*
    	**	Init UI element state
    	*/
    	coreSelectSwitch(false);

        /*
		**	Core function handle when template change
		*/
		function coreSelectSwitch(isSwitch) {
			d = new Date();
			var selected_template = $('#template_select').val();
			$("#template-demo").attr("src", $("#plugin_url").text()+"templates/"+selected_template+".jpg?"+d.getTime());

			// Switcher to decide which option to enable
			if (selected_template == "pro") {
				// HIDE Bg color
				$("#template_bg_color").attr('disabled','disabled');
				$("#template_bg_color").closest("tr").css("display", "none");

				// SHOW Bg img
				$(".upload-bg-image-group").css("display", "table-row");

				// SHOW Logo
				$("#logo_enabled").closest("tr").css("display", "table-row");
				$("#template_logo_url").closest("tr").css("display", "table-row");

				// HIDE Youtube ID
				$("#template_youtube_id").closest("tr").css("display", "none");

				// Disable the rest of items
				$("input[name=template_font_color]").attr('disabled','disabled');
				$("input[name=template_title]").attr('disabled','disabled');
				$("input[name=template_title_size]").attr('disabled','disabled');
				$("input[name=template_sub_title]").attr('disabled','disabled');
				$("input[name=template_sub_title_size]").attr('disabled','disabled');

				// Set default value
				$("#template-desc").text("Static background image with your company logo");
				if (isSwitch) {
					$("#template_bg_img_url").val($("#plugin_url").text()+"assets/images/template-bg-1.jpg");
					$("#template_font_color").val("#ffffff");
				}
				$("input[name=submit_preview], input[name=submit_save]").attr('disabled','disabled');
			} else if (selected_template == "video") {
				// HIDE Bg color
				$("#template_bg_color").attr('disabled','disabled');
				$("#template_bg_color").closest("tr").css("display", "none");

				// HIDE Bg img
				$(".upload-bg-image-group").css("display", "none");

				// SHOW Logo
				$("#logo_enabled").closest("tr").css("display", "table-row");
				$("#template_logo_url").closest("tr").css("display", "table-row");

				// SHOW Youtube ID
				$("#template_youtube_id").closest("tr").css("display", "table-row");

				// Disable the rest of items
				$("input[name=template_font_color]").attr('disabled','disabled');
				$("input[name=template_title]").attr('disabled','disabled');
				$("input[name=template_title_size]").attr('disabled','disabled');
				$("input[name=template_sub_title]").attr('disabled','disabled');
				$("input[name=template_sub_title_size]").attr('disabled','disabled');

				// Set default value
				$("#template-desc").text("Full page Youtube video background with your company logo");
				if (isSwitch) {
					$("#template_font_color").val("#ffffff");
				}
				$("input[name=submit_preview], input[name=submit_save]").attr('disabled','disabled');
			} else if (selected_template == "mystery"
				|| selected_template == "snow"
				|| selected_template == "bubble") {
				// HIDE Bg color
				$("#template_bg_color").attr('disabled','disabled');
				$("#template_bg_color").closest("tr").css("display", "none");

				// SHOW Bg img
				$(".upload-bg-image-group").css("display", "table-row");

				// SHOW Logo
				$("#logo_enabled").closest("tr").css("display", "table-row");
				$("#template_logo_url").closest("tr").css("display", "table-row");

				// HIDE Youtube ID
				$("#template_youtube_id").closest("tr").css("display", "none");

				// Disable the rest of items
				$("input[name=template_font_color]").attr('disabled','disabled');
				$("input[name=template_title]").attr('disabled','disabled');
				$("input[name=template_title_size]").attr('disabled','disabled');
				$("input[name=template_sub_title]").attr('disabled','disabled');
				$("input[name=template_sub_title_size]").attr('disabled','disabled');

				// Set default value
				if (selected_template == "mystery") {
					$("#template-desc").text("Interactive moving star with your company logo");
					if (isSwitch) {
						$("#template_bg_img_url").val($("#plugin_url").text()+"assets/images/template-bg-2.jpg");
						$("#template_font_color").val("#ffffff");
					}
				} else if (selected_template == "snow") {
					$("#template-desc").text("Interactive moving snow effect with your company logo");
					if (isSwitch) {
						$("#template_bg_img_url").val($("#plugin_url").text()+"assets/images/template-bg-3.jpg");
						$("#template_font_color").val("#ffffff");
					}
				} else if (selected_template == "bubble") {
					$("#template-desc").text("Interactive moving bubble effect with your company logo");
					if (isSwitch) {
						$("#template_bg_img_url").val($("#plugin_url").text()+"assets/images/template-bg-4.jpg");
						$("#template_font_color").val("#ffffff");
					}
				}
				$("input[name=submit_preview], input[name=submit_save]").attr('disabled','disabled');
			} else {
				// SHOW Bg color
				$("#template_bg_color").removeAttr('disabled');
				$("#template_bg_color").closest("tr").css("display", "table-row");

				// HIDE Bg img
				$(".upload-bg-image-group").css("display", "none");

				// HIDE Logo
				$("#logo_enabled").closest("tr").css("display", "none");
				$("#template_logo_url").closest("tr").css("display", "none");

				// HIDE Youtube ID
				$("#template_youtube_id").closest("tr").css("display", "none");

				// Disable the rest of items
				$("input[name=template_font_color]").removeAttr('disabled');
				$("input[name=template_title]").removeAttr('disabled');
				$("input[name=template_title_size]").removeAttr('disabled');
				$("input[name=template_sub_title]").removeAttr('disabled');
				$("input[name=template_sub_title_size]").removeAttr('disabled');

				// Set default value
				$("#template-desc").text("Basic theme with background color");
				if (isSwitch) {
					$("#template_bg_color").val("#15b5f7");
					$("#template_font_color").val("#ffffff");
				}
				$("input[name=submit_preview], input[name=submit_save]").removeAttr('disabled');
			}
		}

        /*
		**	Handle when template change
		*/
		jQuery( '#template_select' ).on( 'change', function() {
			coreSelectSwitch(true);
		});
    });
})( jQuery );
