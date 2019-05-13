<?php
/**
 * ==============
 * BTPay-Admin.php
 * 
 * Display configure tab in dashboard
 */
 add_action('admin_menu', 'btpay_admin_menu');

 add_action( 'admin_footer', 'media_selector_print_scripts' );

function media_selector_print_scripts() {

	$my_saved_attachment_post_id = get_option( 'media_selector_attachment_id', 0 );

	?><script type='text/javascript'>
		jQuery( document ).ready( function( $ ) {
			// Uploading files
			var file_frame;
			var wp_media_post_id = wp.media.model.settings.post.id; // Store the old id
			var set_to_post_id = <?php echo $my_saved_attachment_post_id; ?>; // Set this
			jQuery('#upload_image_button').on('click', function( event ){
				event.preventDefault();
				// If the media frame already exists, reopen it.
				if ( file_frame ) {
					// Set the post ID to what we want
					file_frame.uploader.uploader.param( 'post_id', set_to_post_id );
					// Open frame
					file_frame.open();
					return;
				} else {
					// Set the wp.media post id so the uploader grabs the ID we want when initialised
					wp.media.model.settings.post.id = set_to_post_id;
				}
				// Create the media frame.
				file_frame = wp.media.frames.file_frame = wp.media({
					title: 'Select a image to upload',
					button: {
						text: 'Use this image',
					},
					multiple: false	// Set to true to allow multiple files to be selected
				});
				// When an image is selected, run a callback.
				file_frame.on( 'select', function() {
					// We set multiple to false so only get one image from the uploader
					attachment = file_frame.state().get('selection').first().toJSON();
					// Do something with attachment.id and/or attachment.url here
					$( '#image-preview' ).attr( 'src', attachment.url ).css( 'width', 'auto' );
					$( '#logo_path' ).val( attachment.id );
					// Restore the main post ID
					wp.media.model.settings.post.id = wp_media_post_id;
				});
					// Finally, open the modal
					file_frame.open();
			});
			// Restore the main ID when the add media button is pressed
			jQuery( 'a.add_media' ).on( 'click', function() {
				wp.media.model.settings.post.id = wp_media_post_id;
			});
		});
	</script><?php
}

 function btpay_admin_menu()
 {
     add_menu_page(
         'BTPay - Configure',
         'BT-Pay',
         'manage_options',
         'btpay_config',
         'btpay_config_fn',
         'dashicons-products');

        add_submenu_page(
            'btpay_config',
            'Configure mail',
            'Configure mail and notification service',
            'manage_options',
            'btpay_config_mails',
            'btpay_config_mails_fn');
 }



  /**
  * BT PAY post action
  */

  function btpay_post_action()
  {
      global $wpdb;
      if (!empty($_POST))
      {
         if (isset($_POST['update_config']))
         {
            $id = $_POST['update_config'];
            btpay_handle_config_update();
            include BT_PLUGIN_DIR . '/pages/btpay-config-page.php';
         }
      }
      else
      {
        include BT_PLUGIN_DIR . '/pages/btpay-config-page.php';
      }
  }


  /**
   * BT PAY Update config
   */
  function btpay_handle_config_update()
  {
    global $wpdb;
    $table = $wpdb->prefix . BT_PLUGIN_TABLE_NAME . "_" . "config";
    $table_mail = $wpdb->prefix . BT_PLUGIN_EMAIL_TABLE;
    if (isset($_POST['update_config']))
    {
        if (isset($_POST['user']))
        {
            $user = $_POST['user'];
        }
        if (isset($_POST['pass']))
        {
            $pass = $_POST['pass'];
        }
        if (isset($_POST['success_url']))
        {
            $success_redirect_url = $_POST['success_url'];
        }
        if (isset($_POST['fail_url']))
        {
            $fail_redirect_url = $_POST['fail_url'];
        }
        if ($wpdb->update($table, 
            array('user' => $user,
                'pass' => $pass,
                'success_redirect_url' => $success_redirect_url,
                'fail_redirect_url' => $fail_redirect_url
            ),
            array('id'=>1), // where
            array('%s', '%s', '%s', '%s'), //data format
            array('%d') // where format
        ) )
        {
            echo "<script>alert('Success')</script>";
        }
        else
        {
            echo "<script>alert('Failed')</script>";
        }
    }
    else if (isset($_POST['update_mail']))
    {
       // wp_die("CE PLM");
        if (isset($_POST['from_mail']))
        {
            $from_mail = $_POST['from_mail'];
        }
        if (isset($_POST['notify_mail']))
        {
            $notify_mail = $_POST['notify_mail'];
        }
        if (isset($_POST['subject_prefix']))
        {
            $subject_prefix = $_POST['subject_prefix'];
        }
        if (isset($_POST['logo_path']))
        {
            $logo_path = $_POST['logo_path'];
        }
        if ($wpdb->update($table_mail, 
            array('from_mail' => $from_mail,
                'notify_mail' => $notify_mail,
                'subject_prefix' => $subject_prefix,
                'company_logo' => $logo_path
            ),
            array('id'=>1), // where
            array('%s', '%s', '%s', '%s'), //data format
            array('%d') // where format
        ) )
        {
            echo "<script>alert('Success')</script>";
        }
        else
        {
            echo "<script>alert('Failed')</script>";
        }
    }
        //echo "<script>alert('$id - $name - $phone - $email - $extra')</script>";
        
      
  }

/**
 * Displays config page
 */
 function btpay_config_fn()
{
    if (!current_user_can('manage_options'))
    {
        wp_die('You do not have sufficient permissions!');
    }

    btpay_post_action();
}



  /**
  * BT PAY post action
  */

  function btpay_mail_config_action()
  {
      global $wpdb;
      if (!empty($_POST))
      {
         if (isset($_POST['update_mail']))
         {
            $id = $_POST['update_mail'];
            btpay_handle_config_update();
            include BT_PLUGIN_DIR . '/pages/btpay-config-mail-page.php';
         }
      }
      else
      {
        include BT_PLUGIN_DIR . '/pages/btpay-config-mail-page.php';
      }
  }


/**
 * Displays mail config page
 */
function btpay_config_mails_fn()
{
    if (!current_user_can('manage_options'))
    {
        wp_die('You do not have sufficient permissions!');
    }

    btpay_mail_config_action();
}
?>