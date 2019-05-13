<?php
/**
 * ===================
 * BTPAY-shortcode-button.php
 * 
 * Display the pay now button (should be attached to a form)
 * --------------------
 * 
 */

function btpay_shortcode_payment_handler()
{
    global $wpdb;
    $table_config = $wpdb->prefix . BT_PLUGIN_TABLE_NAME;
    $table_subscribtions = $wpdb->prefix . BT_PLUGIN_TABLE_NAME . "_" . "subscribtions";
    if (!empty($_POST))
    {
      if (isset($_POST['btpay_pay_now']))
      {
          ini_set("allow_url_fopen", 1);
          $SQL = "SELECT user, pass, currency FROM " . $table_config . " LIMIT 1";
          $row = $wpdb->get_row($SQL);

          $url = 'https://ecclients.btrl.ro/payment/rest/register.do';
          $port = 5443;
          //$url = 'http://bt.ithit.ro/rest/payment';
          $user = $row->user;
          $pass = $row->pass;
          $orderNumber = rand(1, 99999999);
          $currency = 946;//$row->currency
          $returnUrl = get_site_url();
          $amount = $_POST['amount'];
          $amount = $amount * 100;

          $subscription = $_POST['subscription_type'];
          $SQL = "SELECT descr FROM " . $table_subscribtions . " WHERE " . "sub_id = " . $subscription . " LIMIT 1";
          $row = $wpdb->get_row($SQL);

          $description = $row->descr;

          $data = array(
              'userName' => $user, 
              'password' => $pass, 
              'orderNumber' => $orderNumber, 
              'amount' => $amount,
              'currency' => $currency, 
              'returnUrl' => $returnUrl, 
              'description' => $description);
/*
          // use key 'http' even if you send the request to https://...
          $options = array(
              'http' => array(
                  'header'  => "Content-type: application/x-www-form-urlencoded\r\n",
                  'method'  => 'POST',
                  'content' => http_build_query($data)
              )
          );
          $context  = stream_context_create($options);
          $result = file_get_contents($url, false, $context);
          if ($result === FALSE) { 
          }
*/
          // build the urlencoded data
          $postvars = http_build_query($data);

          // open connection
          $ch = curl_init();

          // set the url, number of POST vars, POST data
          curl_setopt($ch, CURLOPT_URL, $url);
          curl_setopt($ch, CURLOPT_PORT, $port);
          curl_setopt($ch, CURLOPT_POST, count($data));
          curl_setopt($ch, CURLOPT_POSTFIELDS, $postvars);
          curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
          curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);
          curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);

          // execute post
          $result = curl_exec($ch);

          if (!$result)
          {
            $result = curl_error($ch);
          }
          // close connection
          curl_close($ch);

          //return "Result: " . $result;
          $result = json_decode($result, true);
          //return "Result: " . $result;
          if (!empty($result['formUrl']))
          {
            $redirect_to = $result["formUrl"];
            wp_redirect($redirect_to);
            exit;
          }
          else
          {
              return $result;
          }
        
      }
    }
}
//{"orderId":"7deb7011-6d0b-4da6-9d25-a591eb53c031",
//"formUrl":"https://ecclients.btrl.ro:5443/payment/merchants/IT_HIT/payment_en.html?mdOrder=7deb7011-6d0b-4da6-9d25-a591eb53c031"}
print_r(btpay_shortcode_payment_handler());
?>
<form method = "post" action = "">
    <!--
    <input type = "hidden" name = "userName" value = "IT_HIT_API"/>
    <input type = "hidden" name = "password" value = "it_hit_api1"/>
    <input type = "hidden" name = "orderNumber" value = "1545321"/>
    -->
    <!--
    <div class="form-group">https://ecclients.btrl.ro:5443/payment/rest/register.do
    <label class="sr-only">Numele si prenumele</label>
    <input type = "text" name = "full_name" placeholder = "Numele si prenumele" class = "wpcf7-form-control wpcf7-text wpcf7-validates-as-required form-control"/>
    </div>http://bt.ithit.ro/rest/payment
    -->
    <input type = "hidden" name = "subscription_type" value = "0"/>
    <div class="form-group">
        <label class="sr-only">Suma</label>
        <input type = "number" name = "amount" placeholder = "Suma" class = "wpcf7-form-control wpcf7-text wpcf7-validates-as-required form-control"/>
    </div>
<!--
    <input type = "hidden" name = "currency" value = "946"/>
    <input type = "hidden" name = "returnUrl" value = "https://www.ithit.ro"/>
    <input type = "hidden" name = "description" value = "SALES HIT CRM - Standard Package"/>
-->
<!--
    <div class="form-group">
    <label class="sr-only">Nume companie</label>
    <input type = "text" name = "company_name" placeholder = "Numele companie" class = "wpcf7-form-control wpcf7-text wpcf7-validates-as-required form-control"/>
    </div>

    <div class="form-group">
    <label class="sr-only">E-mail</label>
    <input type = "email" name = "email" placeholder = "Email" class = "wpcf7-form-control wpcf7-text wpcf7-validates-as-required form-control"/>
    </div>

    <div class="form-group">
    <label class="sr-only">Telefon</label>
    <input type = "phone" name = "phone" placeholder = "Telefon" class = "wpcf7-form-control wpcf7-text wpcf7-validates-as-required form-control"/>

    </div>
    -->
    <input type = "submit" name = "btpay_pay_now" value = "Plateste acum" class = "wpcf7-form-control wpcf7-submit btn btn-primary"/>
</form>
<?php 

?>
    