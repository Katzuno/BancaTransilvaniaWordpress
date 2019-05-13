<?php
// ==========================
// BTPAY-shortcodes.php
//
// Shortcode usage - Display form
// -------------------------

add_shortcode('btpay_form', 'btpay_payment_form');
add_shortcode('btpay_error', 'btpay_show_err');

function btpay_payment_form($atts)
{
    include BT_PLUGIN_DIR . '/pages/btpay-shortcode-button.php';
}

function btpay_show_err($atts)
{
    $actionCode = $_GET['actionCode'];

    $errorCodesDesc = array(
        320 => "Card inactiv. Va rugam activati cardul.",
        801 => "Emitent indisponibil.",
        803 => "Card blocat. Va rugam contactati banca emitenta.",
        805 => "Tranzactie respinsa.",
        861 => "Data expirare card gresita.",
        871 => "CVV gresit.",
        906 => "Card expirat.",
        914 => "Cont invalid. Va rugam contactati banca emitenta.",
        915 => "Fonduri insuficiente.",	
        917 => "Limita tranzactionare depasita.",
        'Unknown' => "Unknown"
    );

    if (!$errorCodesDesc[$actionCode])
    {
        $errorCodesDesc[$actionCode] = "Unknown";
    }
    return "<b style = 'color: red;'>" . $errorCodesDesc[$actionCode] . "</b>";
}



?>