<?php
/**
 * Plugin Name: BT Pay Integration
 * Plugin URI: http://erikhenning.ro/btpay
 * Description: Integrates BT Pay with wordpress - One-Phase
 * Author: Erik Henning
 * Version: 1.0
 * Author URI: http://erikhenning.ro
 */

define('BT_PLUGIN_DIR', plugin_dir_path(__FILE__));
define('BT_PLUGIN_VERSION', '1.0.0');
define('BT_PLUGIN_TABLE_NAME', 'btpay');
define('BT_PLUGIN_EMAIL_TABLE', 'btpay_mail_service');
require_once 'include/btpay-setup.php';

register_activation_hook( __FILE__, 'btpay_install' );

require_once 'include/btpay-shortcodes.php';
require_once 'include/btpay-admin.php';

?>