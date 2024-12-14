<?php
ini_set('display_errors', 1);
error_reporting(E_ALL);

$ussd_string = isset($_GET['text']) ? $_GET['text'] : '';

session_start();

$response = '';

if (empty($ussd_string)) {
    $response = "CON Welcome to My Local USSD Service\n1. Check Balance\n2. Transfer Money\n3. Buy Airtime\n0. Exit";
    $_SESSION['state'] = "menu";
} else {
    switch ($_SESSION['state']) {
        case 'menu':
            if ($ussd_string == '1') {
                $response = "CON Your balance is KSH 100. Press 0 to return to the main menu.";
                $_SESSION['state'] = "balance";
            } elseif ($ussd_string == '2') {
                $response = "CON Enter recipient's phone number:";
                $_SESSION['state'] = "transfer_phone";
            } elseif ($ussd_string == '3') {
                $response = "CON Enter the amount for airtime:";
                $_SESSION['state'] = "buy_airtime";
            } elseif ($ussd_string == '0') {
                $response = "END Thank you for using our service.";
                session_destroy();
                session_unset();
            } else {
                $response = "CON Invalid option, please select a valid option.\n1. Check Balance\n2. Transfer Money\n3. Buy Airtime";
            }
            break;
        case 'transfer_phone':
            $response = "CON Enter amount to transfer:";
            $_SESSION['state'] = "transfer_amount";
            break;
        case 'transfer_amount':
            $response = "END Transfer Successful. Returning to main menu.";
            session_destroy();
            break;
        case 'buy_airtime':
            $response = "END Airtime Purchase Successful. Returning to main menu.";
            session_destroy();
            break;
        default:
            $response = "CON Something went wrong. Please try again.";
            session_destroy();
            break;
    }
}

header('Content-type: text/plain');
echo $response;
?>
