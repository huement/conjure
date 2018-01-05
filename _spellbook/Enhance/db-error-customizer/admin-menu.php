<?php if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly ?>
<div class="wrap">
	<?php if ($error!="") { ?>
	<div class="error"><p><?php echo $error; ?></p></div>
	<?php } ?>
	<?php if ($info!="") { ?>
	<div class="updated"><p><?php echo $info; ?></p></div>
	<?php } ?>
	<?php if ($warning!="") { ?>
	<div class="update-nag"><p><?php echo $warning; ?></p></div>
	<?php } ?>
	<h2><?php _e("DB Error Customizer"); ?></h2>
	<div class="card">
		<form method="post">
			<table class="form-table">
				<tr valign="top">
					<td><input type="submit" name="submit_test" value="<?php _e('Check Compatibility'); ?>" class="button button-primary"></td>
					<td>Check if customized DB error page can setup. Recommended to run this before setting any configuration</td>
				</tr>
			</table>
			<?php wp_nonce_field( 'submit_test_'.get_current_user_id() ); ?>
		</form>
	</div>
	<div class="card">
		<form method="post">
		    <table class="form-table">
		    	<tr valign="top">
		    	<th scope="row"><?php _e("Template") ?></th>
		    	<td>
		    		<?php // Selected template handling
		    		$menu_template_select = ( isset($template_select) ? $template_select : get_option('template_select', 'basic'));
		    		?>
					<select id="template_select" name="template_select">
						<?php foreach($templates as $template) { ?>
						<?php $template_val = basename($template, ".txt"); ?>
						<option value="<?php echo $template_val ?>" <?php if ($template_val == $menu_template_select) {echo "selected";} ?>>
							<?php echo ucwords($template_val); ?>
						</option>
						<?php } ?>
					</select>
		    	</td>
		    	</tr>

		    	<tr valign="top" id="template-free-template" style="display: none;">
		    	<th scope="row"></th>
		    	<td>
		    		<p style="color: #0000ff;"></p>
		    	</td>
		    	</tr>

		    	<tr valign="top">
		    	<th scope="row"></th>
		    	<td>
		    		<img id="template-demo" width="320px" src="<?php echo plugins_url( 'templates/basic.jpg', __FILE__ ); ?>"><br>
		    		<i id="template-desc"></i>
		    	</td>
		    	</tr>

		        <tr valign="top">
		        <th scope="row"><?php _e("Background Color"); ?></th>
		        <td><input class="color-field" type="text" id="template_bg_color" name="template_bg_color" value="<?php echo esc_attr(( isset($template_bg_color) ? $template_bg_color : get_option('template_bg_color', '#15b5f7'))); ?>" /></td>
		        </tr>

		        <tr valign="top">
		        <th scope="row"><?php _e("Background Image"); ?></th>
		        <td>
		        	<input id="upload_bg_img_button" type="button" class="button" value="<?php _e( 'Upload / Select' ); ?>" />
		        	<input type='hidden' name='template_bg_img_attachment_id' id='template_bg_img_attachment_id' value='<?php echo esc_attr( isset($template_bg_img_attachment_id) ? $template_bg_img_attachment_id : get_option('template_bg_img_attachment_id')); ?>'>
		        	<input type="text" name="template_bg_img_url" id="template_bg_img_url" value="<?php echo esc_attr( isset($template_bg_img_url) ? $template_bg_img_url : get_option('template_bg_img_url', plugins_url( 'assets/images/template-bg-1.jpg', __FILE__ ))); ?>" readonly/>
		        </td>
		        </tr>

		        <tr valign="top">
		        <th scope="row"><?php _e("Logo"); ?></th>
		        <td>
		        	<input id="upload_logo_button" type="button" class="button" value="<?php _e( 'Upload / Select' ); ?>" />
		        	<input type='hidden' name='template_logo_attachment_id' id='template_logo_attachment_id' value='<?php echo esc_attr( isset($template_logo_attachment_id) ? $template_logo_attachment_id : get_option('template_logo_attachment_id')); ?>'>
		        	<input type="text" name="template_logo_url" id="template_logo_url" value="<?php echo esc_attr( isset($template_logo_url) ? $template_logo_url : get_option('template_logo_url', plugins_url( 'assets/images/template-logo-1.png', __FILE__ ))); ?>" readonly/>
		        </td>
		        </tr>

		        <tr valign="top">
		        <th scope="row"><?php _e("Youtube ID"); ?></th>
		        <td>
		        	<input type="text" id="template_youtube_id" name="template_youtube_id" value="<?php echo esc_attr(( isset($template_youtube_id) ? $template_youtube_id : get_option('template_youtube_id', 'YQKnasbfRMA'))); ?>" /><br>
		        	<i><?php _e("Only video ID required"); ?> (www.youtube.com/watch?v=<b>xxxxxx</b> <?php _e("or"); ?> https://youtu.be/<b>xxxxxx</b>)</i>
		        </td>
		        </tr>

		        <tr valign="top">
		        <th scope="row"><?php _e("Font Color"); ?></th>
		        <td><input class="color-field" type="text" id="template_font_color" name="template_font_color" value="<?php echo esc_attr(( isset($template_font_color) ? $template_font_color : get_option('template_font_color', '#ffffff'))); ?>" /></td>
		        </tr>
		         
		        <tr valign="top">
		        <th scope="row"><?php _e("Main Title"); ?></th>
		        <td><input type="text" name="template_title" value="<?php echo esc_attr(( isset($template_title) ? $template_title : get_option('template_title', 'Sorry...'))); ?>" /></td>
		        </tr>
		        
		        <tr valign="top">
		        <th scope="row"><?php _e("Sub Title"); ?></th>
		        <td><input type="text" name="template_sub_title" value="<?php echo esc_attr(( isset($template_sub_title) ? $template_sub_title : get_option('template_sub_title', 'We encounter some technical issues now. Please come back later'))); ?>" /></td>
		        </tr>

		        <tr valign="top">
		        	<td colspan="2"><hr></td>
		        </tr>

		        <tr valign="top">
		        <th scope="row"><?php _e("Email Alert"); ?></th>
		        <td><input type="checkbox" name="email_enabled" id="email_enabled" <?php echo esc_attr(( isset($email_enabled) ? 'checked' : get_option('email_enabled', ''))); ?> /><i><?php _e("Send email alert to admin when database down"); ?></i></td>
		        </tr>

		    	<tr valign="top" id="template-free-email" style="display: none;">
		    	<th scope="row"></th>
		    	<td>
		    		<p style="color: #0000ff;"></p>
		    	</td>
		    	</tr>

		    	<tr valign="top">
		    	<th scope="row"><?php _e("Maximum How Often?"); ?></th>
		    	<td>
		    		<?php // Selected template handling
		    		$email_freq = ( isset($email_freq) ? $email_freq : get_option('email_freq', '1 Hour'));
		    		?>
					<select id="email_freq" name="email_freq">
						<?php foreach($email_all_freqs as $curr_freq) { ?>
						<option value="<?php echo $curr_freq ?>" <?php if ($curr_freq == $email_freq) {echo "selected";} ?>>
							<?php echo $curr_freq; ?>
						</option>
						<?php } ?>
					</select>
					<i><?php _e("per email (Maximum)") ?></i>
		    	</td>
		    	</tr>

		        <tr valign="top">
		        <th scope="row"><?php _e("Send Email To"); ?></th>
		        <?php 
		        	$admin_email = get_option('admin_email', '');
		        ?>
		        <td><input type="email" name="email_target" id="email_target" value="<?php echo esc_attr(( isset($email_target) ? $email_target : get_option('email_target', $admin_email))); ?>" /></td>
		        </tr>

		        <tr valign="top">
		        <th scope="row"><?php _e("Email Subject"); ?></th>
		        <td><input type="text" name="email_subject" id="email_subject" value="<?php echo esc_attr(( isset($email_subject) ? $email_subject : get_option('email_subject', 'Website Database Down'))); ?>" /></td>
		        </tr>

		        <tr valign="top">
		        <th scope="row"><?php _e("Email Content"); ?></th>
		        <td><input type="text" name="email_msg" id="email_msg" value="<?php echo esc_attr(( isset($email_msg) ? $email_msg : get_option('email_msg', 'The website database is down. Please fix it now'))); ?>" /></td>
		        </tr>
		    </table>
		    
		    <br>
		    <input type="submit" name="submit_preview" value="<?php _e('Preview'); ?>" class="button button-primary">
		    <input type="submit" name="submit_save" value="<?php _e('Setup / Update DB Error Page'); ?>" class="button button-primary">
		    <input type="hidden" id="plugin_url" name="plugin_url" value="<?php echo plugins_url('/', __FILE__); ?>">
		    <?php wp_nonce_field( 'submit_preview_save_'.get_current_user_id() ); ?>
		</form>
	</div>
</div>
