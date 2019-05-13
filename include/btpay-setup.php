<?php

function btpay_install () {
    global $wpdb;
    $table_config = $wpdb->prefix . BT_PLUGIN_TABLE_NAME . "_" . "config";
    $table_subscribtions = $wpdb->prefix . BT_PLUGIN_TABLE_NAME . "_" . "subscribtions";
    $table_transactions = $wpdb->prefix . BT_PLUGIN_TABLE_NAME . "_" . "transactions";
    $table_clients = $wpdb->prefix . BT_PLUGIN_TABLE_NAME . "_" . "clients";
    $table_mail = $wpdb->prefix . BT_PLUGIN_EMAIL_TABLE;

   $charset_collate = $wpdb->get_charset_collate();

   
   $sql = "CREATE TABLE $table_config (
     id tinyint(1) NOT NULL AUTO_INCREMENT,
     user varchar(12) DEFAULT 'Not set' NOT NULL,
     pass varchar(12) DEFAULT 'Not set' NOT NULL,
     success_redirect_url varchar(64) DEFAULT '" . get_site_url() . "' NOT NULL,
     fail_redirect_url varchar(64) DEFAULT '" . get_site_url() . "' NOT NULL,
     last_update datetime DEFAULT CURRENT_TIMESTAMP NOT NULL,
     PRIMARY KEY  (id)
   ) $charset_collate;";

    $sql2 = "CREATE TABLE $table_subscribtions (
        sub_id tinyint(1) NOT NULL AUTO_INCREMENT,
        descr varchar(128) DEFAULT 'Not set' NOT NULL,
        PRIMARY KEY  (sub_id)
    ) $charset_collate;";
/*
    $sql = "CREATE TABLE $table_transactions (
        id smallint(2) NOT NULL AUTO_INCREMENT,
        orderNumber varchar(12) DEFAULT 'Not set' NOT NULL,
        sub_id varchar(12) DEFAULT 'Not set' NOT NULL,
        amount_paid smallint(2) DEFAULT 946 NOT NULL
        PRIMARY KEY  (id)
    ) $charset_collate;";
    */
   
   require_once( ABSPATH . 'wp-admin/includes/upgrade.php' );
   if (dbDelta( $sql ) )
   {
    btpay_insert_first_config_row();
   }
   else
   {
      //wp_die('Table BTPAY CONFIG could not be created.');
   }
   //wp_die("TEST");
   
   $sql = "CREATE TABLE $table_mail (
    id tinyint(1) NOT NULL AUTO_INCREMENT,
    from_mail varchar(64) DEFAULT 'Not set' NOT NULL,
    notify_mail varchar(64) DEFAULT 'Not set' NOT NULL,
    subject_prefix varchar(64) DEFAULT '" . get_bloginfo('name') . "' NOT NULL,
    company_logo varchar(128) DEFAULT 'Not set' NOT NULL,
    last_update datetime DEFAULT CURRENT_TIMESTAMP NOT NULL,
    PRIMARY KEY  (id)
  ) $charset_collate;";
  
  if (dbDelta( $sql ) )
  {
       btpay_insert_first_mail_row();
  }
  else
  {
     wp_die('Table emailing could not be created.');
  }
 // wp_die("TEST");
}
function btpay_insert_first_config_row()
{
    global $wpdb;
    $table_name = $wpdb->prefix . BT_PLUGIN_TABLE_NAME . "_" . "config";
    $wpdb->insert( 
        $table_name, 
        array( 
            'user' => 'Not set', 
            'pass' => 'Not set',
            'success_redirect_url' => get_site_url(),
            'fail_redirect_url' => get_site_url()
        ), 
        array( 
            '%s', 
            '%s',
            '%s',
            '%s'
        ) 
        );
}


function btpay_insert_first_mail_row()
{
    global $wpdb;
    $table_name = $wpdb->prefix . BT_PLUGIN_EMAIL_TABLE;
    $wpdb->insert( 
        $table_name, 
        array( 
            'from_mail' => 'Not set', 
            'notify_mail' => 'Not set',
            'subject_prefix' => get_bloginfo('name'),
            'company_logo' => get_bloginfo('Not set')
        ), 
        array( 
            '%s', 
            '%s',
            '%s',
            '%s'
        ) 
        );
}

?>