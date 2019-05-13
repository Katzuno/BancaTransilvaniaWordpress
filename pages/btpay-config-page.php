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
 $table = $wpdb->prefix . BT_PLUGIN_TABLE_NAME . "_" . "config";
 $valid = true;
 $SQL = "SELECT user, pass, success_redirect_url, fail_redirect_url FROM " . $table . " LIMIT 1";
 $row = $wpdb->get_row($SQL);

 $user = $row->user;
 $pass = $row->pass;
 $success_url = $row->success_redirect_url;
 $fail_url = $row->fail_redirect_url;
?>
<h2>BT-PAY Configuration</h2>

<div class="col-md-8">
  <div class="panel panel-primary">
	<div class="panel-heading">
	  <h3 class="panel-title">BT-PAY Auth</h3>
	</div>
	<div class="panel-body">
		<form method = "POST" action="">
		  <div class="form-group">
			<label for="frmName" class="col-sm-4 control-label">Username</label>
			<div class="col-sm-8">
				<input type="text" class="form-control" name="user" value="<?php echo $user; ?>">
			</div>
		  </div>

		  <div class="form-group">
			<label for="frmPhone" class="col-sm-4 control-label">Password</label>
			<div class="col-sm-8">
				<input type="text" class="form-control" name="pass" value="<?php echo $pass; ?>">
			</div>
		  </div>

			<div class="form-group">
				<label for="frmName" class="col-sm-4 control-label">Success URL</label>
				<div class="col-sm-8">
					<input type="text" class="form-control" name="success_url" value="<?php echo $success_url; ?>">
				</div>
		  </div>

			<div class="form-group">
				<label for="frmName" class="col-sm-4 control-label">Fail URL</label>
				<div class="col-sm-8">
					<input type="text" class="form-control" name="fail_url" value="<?php echo $fail_url; ?>">
				</div>
		  </div>

		  <div class="col-sm-8 col-sm-offset-4">
			  <button type="submit" name="update_config" value="update_config" class="btn btn-success">Update config</button>
		  </div>

		</form>
	</div>
  </div>
</div>
<?php ?>
    