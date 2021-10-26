<?php 

namespace Source\App;

use Firebase\JWT\JWT;
use Source\App\Support\PaypalPayment;

class Payment{

    private $idProduct;

    public function __construct()
    {      
        
        !session_start() && session_start();

        $this->view = new \League\Plates\Engine(__DIR__ . "/../../views/user");

        $this->conn = new \PDO("mysql:host=localhost;dbname=elegancebd","root","");
        $this->conn->setAttribute(\PDO::ATTR_ERRMODE, \PDO::ERRMODE_EXCEPTION);
        
    }

    public function paypalPayment($data) {

        // GET INFORMATIONS FROM PRODUCTS
        $queryToGetProduct = "SELECT * FROM elegancebd.products WHERE id_product = :id";
        $stmt = $this->conn->prepare($queryToGetProduct);
        $stmt->bindValue(':id', $data['id']);
        $stmt->execute();

        $product = $stmt->fetch(\PDO::FETCH_ASSOC);

        // CALC PRICE FROM PRODUCT
        $percent = (floatval($product['InitialPrice']) / 100) * $product['InitialDiscount'];

        $totalFinal = floatval($product['InitialPrice']) - $percent;
        $finalPrice = number_format(floatval($totalFinal), 2);

        // CREATING INFORMATION ARRAY FOR PAYPAL
        $arrayToPaypalInformations = [
            'name' => $product['nome'],
            'price' => floatval($finalPrice),
            'description' => $product['nome'],
            'quantity' => 1
        ];

        //CREATING SESSION FOR ADD CASE SUCESS = TRUE;
        $_SESSION['productToBuy'] = [
           'name' => $product['nome'],
           'id' => $data['id'],
           'price' => floatval($finalPrice),
        ];

        // MAKE PAYMENT
        $gateway = new PaypalPayment;


        $gateway
            ->setKeys(PAYPAL_CLIENT_ID_SANDBOX, PAYPAL_SECRET_SANDBOX)
            ->setCurrency(PAYPAL_CURRENCY)
            ->setReturnUrl(PAYPAL_RETURN_URL)
            ->setCancelUrl(PAYPAL_CANCEL_URL)
            ->setGold($finalPrice)
            ->isSandboxie(true)
            ->setItems($arrayToPaypalInformations)
            ->execute();


    }

    public function cancelPurchase() {

        // add cash back to user
        $queryToGetValueFromProduct = "SELECT pricePaid,idProductBuy FROM productsbuyed WHERE paymentId = :idPayment";
        $stmt = $this->conn->prepare($queryToGetValueFromProduct);
        $stmt->execute([
            ':idPayment' => $_POST['idPayment']
        ]);

        $items =  $stmt->fetch(\PDO::FETCH_ASSOC);
        $pricePaid = $items['pricePaid'];
        $product = $items['idProductBuy'];    

        //update cash from user
        $queryToAddMoneyToUser = "UPDATE users SET moneyUser = moneyUser + $pricePaid";
        $stmt = $this->conn->prepare($queryToAddMoneyToUser);
        if($stmt->execute()) {

            // creating translaction

            $jwtUserLogged = JWT::decode($_SESSION['jwtTokenUser'], SECRET_KEY, ['HS256']);

            //get name from product deleted
            $queryToGetName = "SELECT nome FROM products WHERE id_product = $product";
            $stmt = $this->conn->prepare($queryToGetName);
            $stmt->execute();

            $nameProduct = $stmt->fetch(\PDO::FETCH_ASSOC)['nome'];
            
            $queryToTranslaction = "INSERT INTO translationswallet 
                SET id_user = :idUser, isAdd = :isAdd, price = :price, statusTranslaction = :statusT";

            $stmt = $this->conn->prepare($queryToTranslaction);
            $sucessMakeTranslaction = $stmt->execute([
                ':idUser' => $jwtUserLogged->id,
                ':isAdd' => 1,
                ':price' => $pricePaid,
                ':statusT' => "Cancelamento do produto: $nameProduct"
            ]);

            if($sucessMakeTranslaction){

                $query = "DELETE FROM productsbuyed WHERE paymentId = :idPayment";

                $stmt = $this->conn->prepare($query);
                $confirm = $stmt->execute([
                    ':idPayment' => $_POST['idPayment']
                ]);

                if($confirm) {
                    echo json_encode(true);
                    return;
                }

                echo json_encode(false);
                return;
            }
            
            echo json_encode(false);
            return;
        }

        echo json_encode(false);
        return;

    }

    private function getMoneyUser() {

        $jwtUserLogged = JWT::decode($_SESSION['jwtTokenUser'], SECRET_KEY, ['HS256']);

        $query = "SELECT moneyUser FROM users WHERE id = $jwtUserLogged->id";
        $stmt = $this->conn->prepare($query);
        $stmt->execute();

        return $stmt->fetch(\PDO::FETCH_ASSOC)['moneyUser'];

    }

    public function walletPayment($data) {

        $price = $_POST['pricePaid'];
        $queryToAddMoneyToUser = "UPDATE users SET moneyUser = moneyUser - $price";
        $stmt = $this->conn->prepare($queryToAddMoneyToUser);
        $confirm = $stmt->execute();

        if($confirm) {
            
            // creating translaction

            $jwtUserLogged = JWT::decode($_SESSION['jwtTokenUser'], SECRET_KEY, ['HS256']);

            //get name from product deleted
            $queryToGetName = "SELECT nome FROM products WHERE id_product = :idProduct";
            $stmt = $this->conn->prepare($queryToGetName);
            $stmt->execute([
                'idProduct' => $data['id'],
            ]);

            $nameProduct = $stmt->fetch(\PDO::FETCH_ASSOC)['nome'];
            
            $queryToTranslaction = "INSERT INTO translationswallet 
                SET id_user = :idUser, isAdd = :isAdd, price = :price, statusTranslaction = :statusT";

            $stmt = $this->conn->prepare($queryToTranslaction);
            $sucessMakeTranslaction = $stmt->execute([
                ':idUser' => $jwtUserLogged->id,
                ':isAdd' => 0,
                ':price' => $_POST['pricePaid'],
                ':statusT' => "Compra do produto: $nameProduct"
            ]);

            if($sucessMakeTranslaction) {

                try{
                    $query = "INSERT INTO productsbuyed(idProductBuy,idUserBuy,paymentId,token,PayerID,pricePaid) VALUES (:idProduct,:idUser,:payId,:token,:payerId,:pricePaid)";
                    $stmt = $this->conn->prepare($query);
    
                    $stmt->execute([
                        ':idProduct' => $data['id'],
                        ':idUser' => $jwtUserLogged->id,
                        ':payId' =>  $_POST['paymentId'],
                        ':token' =>  $_POST['token'],
                        ':payerId' => $_POST['payerId'],
                        ':pricePaid' => $_POST['pricePaid']
                    ]);
        
                    // update purchase items
    
                    $queryToUpdatePurchase = "UPDATE products SET purchased_items = purchased_items + 1, estq = estq -1 WHERE id_product = :id";
                    $stmt = $this->conn->prepare($queryToUpdatePurchase);
                    $stmt->execute([
                        ':id' => $data['id']
                    ]);
                }catch(\Exception $e){
                    echo json_encode($e);
                }

                echo json_encode(true);
                return;

            }

            echo json_encode(false);
            return;
        }

        echo json_encode(false);
        return;

    }

    public function walletPaymentCart() {

        if(!isset($_SESSION['jwtTokenUser'])) {
            header("Location: " . BASE_URL . "/auth/login");
            exit;
        }

        if(!isset($_SESSION['productsToBuyInCart'])) {
            echo json_encode(false);
            exit;
        }

        
        $allItens = json_decode($_SESSION['productsToBuyInCart'], true);

        $price = $_POST['pricePaid'];
        $queryToAddMoneyToUser = "UPDATE users SET moneyUser = moneyUser - $price";
        $stmt = $this->conn->prepare($queryToAddMoneyToUser);
        $confirm = $stmt->execute();

        $jwtUserLogged = JWT::decode($_SESSION['jwtTokenUser'], SECRET_KEY, ['HS256']);

        foreach($allItens as $item) {

            if($confirm) {
            
                // creating translaction
    
                //get name from product deleted
                $queryToGetName = "SELECT nome FROM products WHERE id_product = :idProduct";
                $stmt = $this->conn->prepare($queryToGetName);
                $stmt->execute([
                    'idProduct' => $item['product'],
                ]);
    
                $nameProduct = $stmt->fetch(\PDO::FETCH_ASSOC)['nome'];
                
                $queryToTranslaction = "INSERT INTO translationswallet 
                    SET id_user = :idUser, isAdd = :isAdd, price = :price, statusTranslaction = :statusT";
    
                $stmt = $this->conn->prepare($queryToTranslaction);
                $sucessMakeTranslaction = $stmt->execute([
                    ':idUser' => $jwtUserLogged->id,
                    ':isAdd' => 0,
                    ':price' => $_POST['pricePaid'],
                    ':statusT' => "Compra do produto: $nameProduct"
                ]);
    
                if($sucessMakeTranslaction) {
    
                    try{
                        $query = "INSERT INTO productsbuyed(idProductBuy,idUserBuy,paymentId,token,PayerID,pricePaid) VALUES (:idProduct,:idUser,:payId,:token,:payerId,:pricePaid)";
                        $stmt = $this->conn->prepare($query);
        
                        $stmt->execute([
                            ':idProduct' => $item['product'],
                            ':idUser' => $jwtUserLogged->id,
                            ':payId' =>  $_POST['paymentId'],
                            ':token' =>  $_POST['token'],
                            ':payerId' => $_POST['payerId'],
                            ':pricePaid' => $_POST['pricePaid']
                        ]);
            
                        // update purchase items
        
                        $queryToUpdatePurchase = "UPDATE products SET purchased_items = purchased_items + 1, estq = estq -1 WHERE id_product = :id";
                        $stmt = $this->conn->prepare($queryToUpdatePurchase);
                        $stmt->execute([
                            ':id' => $item['product']
                        ]);
                    }catch(\Exception $e){
                        echo json_encode($e);
                    }
    
                }
            }
        }

        $query2 = "DELETE  FROM shoppingcart WHERE id_user = :id";
        $stmt = $this->conn->prepare($query2);
        $stmt->execute([
            ':id' => $jwtUserLogged->id
        ]);

        unset($_SESSION['productsToBuyInCart']);
        
        echo json_encode(true);
        return;

    }


    public function cartPaymentPaypal(){

        if(!isset($_SESSION['jwtTokenUser'])) {
            header("Location: " . BASE_URL . "/auth/login");
            exit;
        }

        if(!isset($_SESSION['productsToBuyInCart'])) {
            header("Location: " . BASE_URL . "/carrinho-de-compras");
            exit;
        }

        $jwtUserLogged = JWT::decode($_SESSION['jwtTokenUser'], SECRET_KEY, ['HS256']);
        
        $allItens = json_decode($_SESSION['productsToBuyInCart'], true);

        $price = 0.00;
        foreach($allItens as $item){
            $price += ($item['total']);
        }

        $allItensAraay = [];
        foreach($allItens as $item){
            array_push($allItensAraay, $item['product']);
        }

        $qtd = count($allItensAraay);

        //CREATING SESSION FOR ADD CASE SUCESS = TRUE;
        $_SESSION['productToBuy'] = [
            'name' => "Compra de $qtd item",
            'id' => $allItensAraay,
            'price' => $price,
        ];

        // MAKE PAYMENT
        $gateway = new PaypalPayment;

        $gateway
            ->setKeys(PAYPAL_CLIENT_ID_SANDBOX, PAYPAL_SECRET_SANDBOX)
            ->setCurrency(PAYPAL_CURRENCY)
            ->setReturnUrl(PAYPAL_RETURN_URL_CART)
            ->setCancelUrl(PAYPAL_CANCEL_URL)
            ->setGold($price)
            ->isSandboxie(true)
            ->execute();

    }
}