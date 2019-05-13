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
				<div class="col-sm-8">
					<input type="text" class="form-control" name="logo_path" value="<?php echo $logo_path; ?>">
				</div>
		  </div>

		  <div class="col-sm-8 col-sm-offset-4">
			  <button type="submit" name="update_config" value="update_mail" class="btn btn-success">Update mail config</button>
		  </div>

		</form>
	</div>
  </div>
</div>
<?php ?>
    