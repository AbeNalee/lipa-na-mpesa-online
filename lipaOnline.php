<!DOCTYPE html>
<html lang="en">
<head>
    <title>Lipa na Mpesa Online</title>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!--===============================================================================================-->
    <link rel="icon" type="image/png" href="images/icons/favicon.ico"/>
    <!--===============================================================================================-->
    <link rel="stylesheet" type="text/css" href="vendor/bootstrap/css/bootstrap.min.css">
    <!--===============================================================================================-->
    <link rel="stylesheet" type="text/css" href="fonts/font-awesome-4.7.0/css/font-awesome.min.css">
    <!--===============================================================================================-->
    <link rel="stylesheet" type="text/css" href="vendor/animate/animate.css">
    <!--===============================================================================================-->
    <link rel="stylesheet" type="text/css" href="vendor/css-hamburgers/hamburgers.min.css">
    <!--===============================================================================================-->
    <link rel="stylesheet" type="text/css" href="vendor/select2/select2.min.css">
    <!--===============================================================================================-->
    <link rel="stylesheet" type="text/css" href="css/util.css">
    <link rel="stylesheet" type="text/css" href="css/main.css">
    <!--===============================================================================================-->
</head>
<body>

<div class="bg-contact2" style="background-image: url('images/bg-01.jpg');">
    <div class="container-contact2">
        <div class="wrap-contact2">
            <?php
            // Initialize the variables
            $consumer_key = 'DcFYldKougZCBkJVkq4YfiTSYfiUWWYi';
            $consumer_secret = 'lMpyl1gGsismAgkx';
            $BusinessShortCode = '174379';
            $LipaNaMpesaPasskey = 'bfb279f9aa9bdbcf158e97dd71a467cd2e0c893059b10f78e6b72ada1ed2c919';
            $TransactionType = 'CustomerPayBillOnline';
            $tokenUrl = 'https://sandbox.safaricom.co.ke/oauth/v1/generate?grant_type=client_credentials';
            $phone = $_POST['phone'];
            $lipaOnlineUrl = 'https://sandbox.safaricom.co.ke/mpesa/stkpush/v1/processrequest';
            $amount = $_POST['amount'];
            $CallBackURL = 'https://2f50f430.ngrok.io/callback.php?key=Your$trongPssWard';
            $timestamp = date("Ymdhis");
            $password = base64_encode($BusinessShortCode . $LipaNaMpesaPasskey . $timestamp);

            // Generate the auth token
            $curl = curl_init();
            curl_setopt($curl, CURLOPT_URL, $tokenUrl);
            $credentials = base64_encode($consumer_key . ':' . $consumer_secret);
            curl_setopt($curl, CURLOPT_HTTPHEADER, array('Authorization: Basic ' . $credentials));
            curl_setopt($curl, CURLOPT_HEADER, false);
            curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
            curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);
            $curl_response = curl_exec($curl);

            $token = json_decode($curl_response)->access_token;

            // Initiate the STK Push
            $curl2 = curl_init();
            curl_setopt($curl2, CURLOPT_URL, $lipaOnlineUrl);
            curl_setopt($curl2, CURLOPT_HTTPHEADER, array('Content-Type:application/json', 'Authorization:Bearer ' . $token));


            $curl2_post_data = [
                'BusinessShortCode' => $BusinessShortCode,
                'Password' => $password,
                'Timestamp' => $timestamp,
                'TransactionType' => $TransactionType,
                'Amount' => $amount,
                'PartyA' => $phone,
                'PartyB' => $BusinessShortCode,
                'PhoneNumber' => $phone,
                'CallBackURL' => $CallBackURL,
                'AccountReference' => 'Test',
                'TransactionDesc' => 'Test',
            ];

            $data2_string = json_encode($curl2_post_data);

            curl_setopt($curl2, CURLOPT_RETURNTRANSFER, true);
            curl_setopt($curl2, CURLOPT_POST, true);
            curl_setopt($curl2, CURLOPT_POSTFIELDS, $data2_string);
            curl_setopt($curl2, CURLOPT_HEADER, false);
            curl_setopt($curl2, CURLOPT_SSL_VERIFYPEER, 0);
            curl_setopt($curl2, CURLOPT_SSL_VERIFYHOST, 0);
            $curl2_response = json_decode(curl_exec($curl2));

            echo json_encode($curl2_response, JSON_PRETTY_PRINT);
            ?>
            <form class="contact2-form validate-form" action="queryStatus.php" method="post">
                <input type="hidden" name="checkoutRequestID" value="<?php echo $curl2_response->CheckoutRequestID ?>">
                <div class="container-contact2-form-btn">
                    <div class="wrap-contact2-form-btn">
                        <div class="contact2-form-bgbtn"></div>
                        <button class="contact2-form-btn">
                            Confirm Payment is Complete
                        </button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>




<!--===============================================================================================-->
<script src="vendor/jquery/jquery-3.2.1.min.js"></script>
<!--===============================================================================================-->
<script src="vendor/bootstrap/js/popper.js"></script>
<script src="vendor/bootstrap/js/bootstrap.min.js"></script>
<!--===============================================================================================-->
<script src="vendor/select2/select2.min.js"></script>
<!--===============================================================================================-->
<script src="js/main.js"></script>

<!-- Global site tag (gtag.js) - Google Analytics -->
<script async src="https://www.googletagmanager.com/gtag/js?id=UA-23581568-13"></script>
<script>
    window.dataLayer = window.dataLayer || [];
    function gtag(){dataLayer.push(arguments);}
    gtag('js', new Date());

    gtag('config', 'UA-23581568-13');
</script>

</body>
</html>
