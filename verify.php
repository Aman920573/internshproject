<?php

require('config.php');

$conn = mysqli_connect($host,$username,$userpass,$dbname);
 

session_start();

require('razorpay-php/Razorpay.php');
use Razorpay\Api\Api;
use Razorpay\Api\Errors\SignatureVerificationError;

$success = true;

$error = "Payment Failed";

if (empty($_POST['razorpay_payment_id']) === false)
{
    $api = new Api($keyId, $keySecret);

    try
    {
        // Please note that the razorpay order ID must
        // come from a trusted source (session here, but
        // could be database or something else)
        $attributes = array(
            'razorpay_order_id' => $_SESSION['razorpay_order_id'],
            'razorpay_payment_id' => $_POST['razorpay_payment_id'],
            'razorpay_signature' => $_POST['razorpay_signature']
        );

        $api->utility->verifyPaymentSignature($attributes);
    }
    catch(SignatureVerificationError $e)
    {
        $success = false;
        $error = 'Razorpay Error : ' . $e->getMessage();
    }
}

if ($success === true)
{
    $razorpay_order_id = $_SESSION['razorpay_order_id'];
    $email = $_SESSION['email'];
    $name = $_SESSION['name'];
    $phone = $_SESSION['phone'];
    $amt = $_SESSION['amount'];

    $sql = "INSERT INTO `project` ( `name`, `phone_no`, `email`, `amount`, `payment_status`) VALUES ( '$name', '$phone', '$email', '$amt', '$razorpay_order_id');";
    if(mysqli_query($conn,$sql)){
        echo "database inserted data";
    } 


    $html = "<h>Your payment was successful</h>
             <p>Payment ID: {$_POST['razorpay_payment_id']}</p>";
}
else
{
    $html = "<h>Your payment failed</h>
             <p>{$error}</p>";
}

echo $html;
