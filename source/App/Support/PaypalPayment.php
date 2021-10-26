<?php

namespace Source\App\Support;

use Omnipay\Omnipay;

class PaypalPayment
{

    private $paypal_client_id;
    private $paypal_secret;

    private $testMode;

    private $currency;  // Ex: BRL,  USD

    private $returnUrl; // Ex: http://localhost/cancel-payment.php
    private $cancelUrl; // Ex: http://localhost/sucess-payment.php

    private $gold; // Ex: 20.00

    private $items = [];

    private $gateway;

    public function setKeys(String $paypal_client_id, String $paypal_secret)
    {
        $this->paypal_client_id = $paypal_client_id;
        $this->paypal_secret = $paypal_secret;

        return $this;
    }

    public function setCurrency(String $currency)
    {

        $this->currency = $currency;

        return $this;
    }

    public function isSandboxie($isSandBox){
        if($isSandBox == 'true') {
            $this->testMode = 'true';
        }else{
            $this->testMode = 'false';
        }

        
        return $this;
    }

    public function setReturnUrl(String $returnUrl)
    {

        $this->returnUrl = $returnUrl;

        return $this;
    }

    public function setCancelUrl(String $cancelUrl)
    {

        $this->cancelUrl = $cancelUrl;

        return $this;
    }

    public function setGold(String $gold)
    {
        $this->gold = $gold;


        return $this;
    }

    public function setItems(array $items)
    {
        $this->items = [
            'name' => $items['name'],
            'price' => $items['price'],
            'description' => $items['description'],
            'quantity' => $items['quantity']
        ];

        return $this;
    }

    public function execute()
    {
        if ($this->everythingIsDefined()) {

            $purchase = [];
            $url = "";

            if($this->testMode == 'true'){
                $url = "https://api-m.sandbox.paypal.com/v1/oauth2/token";
            }else{
                $url = "https://api.paypal.com/v1/oauth2/token";
            }

            $ch = \curl_init();

            \curl_setopt($ch, CURLOPT_URL, $url);
            \curl_setopt($ch, CURLOPT_POST, 1);
            \curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
            \curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);
            \curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
            \curl_setopt($ch, CURLOPT_USERPWD, $this->paypal_client_id . ":" . $this->paypal_secret);
            \curl_setopt($ch, CURLOPT_POSTFIELDS, "grant_type=client_credentials");

            $headers = array();

            $headers[] = "Accept: application/json";
            $headers[] = "Accept-Language: en_US";
            $headers[] = "Content-Type: application/x-www-form-urlencoded";

            \curl_setopt($ch, CURLOPT_HEADER, $headers);

            $result = curl_exec($ch);

            if (curl_errno($ch)) {
                echo 'Error:' . curl_error($ch);
            }

            curl_close($ch);
           
            

            @$tokem = explode('",', explode('"access_token":"', $result)[1])[0];

            if ($this->setItems == "" || $this->setItems == []) {
                $purchase = [
                    'amount' => $this->gold,
                    'currency' => $this->currency,
                    'returnUrl' => $this->returnUrl,
                    'cancelUrl' => $this->cancelUrl
                ];
            } else {
                $purchase = [
                    'amount' => $this->gold,
                    'items' => array(
                        $this->items
                    ),
                    'currency' => $this->currency,
                    'returnUrl' => $this->returnUrl,
                    'cancelUrl' => $this->cancelUrl
                ];
            }


            $this->gateway = Omnipay::create('PayPal_Rest');
            $this->gateway->setClientId($this->paypal_client_id);
            $this->gateway->setSecret($this->paypal_secret);
            $this->gateway->setTestMode(\filter_var($this->testMode, FILTER_VALIDATE_BOOLEAN));
            $this->gateway->setToken($tokem);

            var_dump($this->testMode);

            try {
                $response = $this->gateway->purchase($purchase)->send();

                if ($response->isRedirect()) {
                    $response->redirect(); // this will automatically forward the customer
                } else {
                    // not success 
                    var_dump("<br> " .$response->getMessage());
                }
            } catch (\Exception $e) {
                echo $e->getMessage();
            }

        } else {

            throw new \Exception('Some parameter has not been defined. Mandatory parameters are: ' . MANDATORY_PARAMETERS);
        }
    }

    public function getAllData() {
        echo "PAYPAL_SECRET :" . $this->paypal_secret . "<br />";
        
        echo "CLIENT_ID :" . $this->paypal_client_id . "<br />";

        echo "TESTMODE :" . $this->testMode . "<br />";

        echo "CURRENCY :" . $this->currency . "<br />";

        echo "RETURN_URL :" . $this->returnUrl . "<br />";        

        echo "CANCEL_URL :" . $this->cancelUrl . "<br />"; 
        
        echo "GOLD :" . $this->gold . "<br />";       

    }

    public function everythingIsDefined(): bool
    {

        if (
            $this->paypal_client_id == "" || $this->paypal_secret == "" ||
            $this->testMode == "" || $this->currency == "" ||
            $this->returnUrl == "" || $this->cancelUrl == "" || $this->gold == ""
        ) {
            return false;
        } else {

            return true;
        }
    }
}