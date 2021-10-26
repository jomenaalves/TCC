<?php 
    define("BASE_URL", "http://localhost/Elegance");


    define('MAIL', [
        'user' => "jomenaalves@gmail.com",
        'passwd' => "loja7000"
    ]);

    define('SECRET_KEY', 'lKO@nEfsE&29zP2JW1xIp^J$hkZhWe8YJuGwuUCmQj3YN2D0#9');
    
    define("PAYPAL_SECRET_LIVE", "");
    define("PAYPAL_CLIENT_ID_LIVE", "");
    
    define("PAYPAL_SECRET_SANDBOX", "ELCm6esCcUJt5NiSSLwPprfiJSiqF5HY5RGwAPGarGxct7kk_s9keoC0INoeFG0h8hLDSZOhuD6nlgzv");
    define("PAYPAL_CLIENT_ID_SANDBOX", "AcMm5J5S1cSeuVftDwt97wKFDXPLbGOxVwCqd4-fhhQbvvoorqNyAzwqp9ZwBxT5cnUxfpJWweRUhrI3");
    


    define('PAYPAL_RETURN_URL', BASE_URL . "/success");
    define('PAYPAL_RETURN_URL_CART', BASE_URL . "/successCart");
    define('PAYPAL_CANCEL_URL', BASE_URL . "/");
    define('PAYPAL_CURRENCY', 'BRL'); // set your currency here

    
    define("MANDATORY_PARAMETERS", "PAYPAL_CLIENT_ID, PAYPAL_SECRET, TESTMODE, CURRENCY, RETURN_URL, CANCEL_URL, GOLD");