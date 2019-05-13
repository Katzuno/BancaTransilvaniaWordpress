<?php
/**
 * ==============
 * BTPay-Admin.php
 * 
 * Display configure tab in dashboard
 */
 add_action('admin_menu', 'btpay_admin_menu');

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
        wp_die("CE PLM");
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