<?php
/**
 * ===================
 * btpay-config-page.php
 * 
 * Display the config page
 * --------------------
 * 
 */

 global $wpdb;
 $table = $wpdb->prefix . BT_PLUGIN_EMAIL_TABLE;
 $valid = true;
 $SQL = "SELECT from_mail, notify_mail, subject_prefix, company_logo FROM " . $table . " LIMIT 1";
 $row = $wpdb->get_row($SQL);

 $from_mail = $row->from_mail;
 $notify_mail = $row->notify_mail;
 $subject_prefix = $row->subject_prefix;
 $company_logo = $row->company_logo;
?>
<h2>BT-PAY Configuration</h2>

<div class="col-md-8">
  <div class="panel panel-primary">
	<div class="panel-heading">
	  <h3 class="panel-title">BT-PAY Mail and Notifications config</h3>
	</div>
	<div class="panel-body">
		<form method = "POST" action="">
		  <div class="form-group">
			<label for="frmName" class="col-sm-4 control-label">From Mail</label>
			<div class="col-sm-8">
				<input type="text" class="form-control" name="from_mail" value="<?php echo $from_mail; ?>">
			</div>
		  </div>

		  <div class="form-group">
			<label for="frmPhone" class="col-sm-4 control-label">Notify mail</label>
			<div class="col-sm-8">
				<input type="text" class="form-control" name="notify_mail" value="<?php echo $notify_mail; ?>">
			</div>
		  </div>

			<div class="form-group">
				<label for="frmName" class="col-sm-4 control-label">Subject prefix</label>
				<div class="col-sm-8">
					<input type="text" class="form-control" name="subject_prefix" value="<?php echo $subject_prefix; ?>">
				</div>
		  </div>

			<div class="form-group">
				<label for="frmName" class="col-sm-4 control-label">Company logo</label>
				<?php
				// Save attachment ID
				if ( isset( $_POST['update_mail'] ) && isset( $_POST['logo_path'] ) ) :
					update_option( 'media_selector_attachment_id', absint( $_POST['logo_path'] ) );
				endif;

				wp_enqueue_media();
				?>
				<div class='image-preview-wrapper'>

				<img id='image-preview' src='<?php echo wp_get_attachment_url( $company_logo ); ?>' width='100' height='100' style='max-height: 100px; width: 100px;'>
			</div>
				<input id="upload_image_button" type="button" class="button" value="<?php _e( 'Upload image' ); ?>" />
				<input type='hidden' name='logo_path' id='logo_path' value='<?php echo $company_logo?>'>

		  </div>

		  <div class="col-sm-8 col-sm-offset-4">
			  <button type="submit" name="update_mail" value="update_mail" class="btn btn-success">Update mail config</button>
		  </div>

		</form>
	</div>
  </div>
</div>
<?php ?>
    