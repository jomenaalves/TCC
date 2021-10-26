<?php 
   
    namespace Source\App;
    use Firebase\JWT\JWT;


    class ShopController {


        public function __construct()
        {
            
            !session_start() && session_start();

            $this->view = new \League\Plates\Engine(__DIR__ . "/../../views/user/");
    
            $this->conn = new \PDO("mysql:host=localhost;dbname=elegancebd", "root", "");
            $this->conn->setAttribute(\PDO::ATTR_ERRMODE, \PDO::ERRMODE_EXCEPTION);

        }

        private function getMoneyUser() {

            $jwtUserLogged = JWT::decode($_SESSION['jwtTokenUser'], SECRET_KEY, ['HS256']);

            $query = "SELECT moneyUser FROM users WHERE id = $jwtUserLogged->id";
            $stmt = $this->conn->prepare($query);
            $stmt->execute();

            return $stmt->fetch(\PDO::FETCH_ASSOC)['moneyUser'];

        }

        public function index($data) {

            if(!isset($_SESSION['jwtTokenUser'])) {
                header("Location: " . BASE_URL . "/auth/login");
                exit;
            }
            
            $jwtUserLogged = JWT::decode($_SESSION['jwtTokenUser'], SECRET_KEY, ['HS256']);

            echo $this->view->render('shopNow', [
                'title' => 'Elegance - Comprar produto',
                'infoProduct' => $this->getProductToShopNow($data['id_product']),
                'address' => $this->getAddressUserLogged(),
                'email' => $jwtUserLogged->email,
                'name' => $jwtUserLogged->username,
                'wallet' => $this->getMoneyUser(),
            ]);

        }



        private function getProductToShopNow(Int $id)
        {

            $queryToGetProduct = "SELECT * FROM products WHERE id_product = :id";

            $stmt = $this->conn->prepare($queryToGetProduct);
            $stmt->execute([
                ':id' => $id
            ]);

            return $stmt->fetch(\PDO::FETCH_ASSOC);

        }

        private function getAddressUserLogged() {

            $jwtUserLogged = JWT::decode($_SESSION['jwtTokenUser'], SECRET_KEY, ['HS256']);

            $query = "SELECT * FROM address_user INNER JOIN users ON address_user.id_user = users.id WHERE id_user = :id LIMIT 2 ";
            $stmt = $this->conn->prepare($query);
            $stmt->bindValue(':id', $jwtUserLogged->id);
            $stmt->execute();

            return $stmt->fetchAll(\PDO::FETCH_ASSOC);
        }


        public function success($data) {

            if(!isset($_SESSION['jwtTokenUser'])) {
                header("Location: " . BASE_URL . "/auth/login");
                exit;
            }

            $jwtUserLogged = JWT::decode($_SESSION['jwtTokenUser'], SECRET_KEY, ['HS256']);

            if(isset($_SESSION['productToBuy']) && isset($_GET['paymentId']) && isset($_GET['token']) && isset($_GET['PayerID'])) {
              

                try{
                    $query = "INSERT INTO productsbuyed(idProductBuy,idUserBuy,paymentId,token,PayerID,pricePaid) VALUES (:idProduct,:idUser,:payId,:token,:payerId,:pricePaid)";
                    $stmt = $this->conn->prepare($query);
    
                    $stmt->execute([
                        ':idProduct' => $_SESSION['productToBuy']['id'],
                        ':idUser' => $jwtUserLogged->id,
                        ':payId' =>  filter_var($_GET['paymentId'], FILTER_SANITIZE_STRING),
                        ':token' =>  filter_var($_GET['token'], FILTER_SANITIZE_STRING),
                        ':payerId' => filter_var($_GET['PayerID'], FILTER_SANITIZE_STRING),
                        ':pricePaid' => $_SESSION['productToBuy']['price']
                    ]);
    
                    $queryToUpdatePurchase = "UPDATE products SET purchased_items = purchased_items + 1, estq = estq -1 WHERE id_product = :id";
                    $stmt = $this->conn->prepare($queryToUpdatePurchase);
                    $stmt->execute([
                        ':id' => $_SESSION['productToBuy']['id']
                    ]);
                }catch(\Exception $e) {
                    var_dump($e);
                    exit;
                }

                echo $this->view->render('success', [
                    'title' => 'Elegance - Compra feita com sucesso!',
                    'nameProduct' => $_SESSION['productToBuy']['name'],
                    'price' => $_SESSION['productToBuy']['price'],
                ]);
    
                unset($_SESSION['productToBuy']);
                return;
            }

            header("Location: " . BASE_URL . "/user/perfil");
            exit;

        }

        # Method responsible for render page to shopping all products in cart
        public function shoppingCart(): void
        {
            if(!isset($_SESSION['jwtTokenUser'])) {
                header("Location: " . BASE_URL . "/auth/login");
                exit;
            }
            
            if(!isset($_SESSION['productsToBuyInCart'])){
                header("Location:" . BASE_URL . "/carrinho-de-compras");
                exit;
            }

            $jwtUserLogged = JWT::decode($_SESSION['jwtTokenUser'], SECRET_KEY, ['HS256']);

            $allItens = json_decode($_SESSION['productsToBuyInCart'], true);
            $totalItens = 0;

            foreach($allItens as $item){
                $totalItens += intval($item['qtd']);
            }

            $price = 0.00;

            foreach($allItens as $item){
                $price += ($item['total']);
            }

            $itens = count($allItens);

            echo $this->view->render('shopCart', [
                'title' => 'Elegance - Comprar itens do carrinho!',
                'allProducts' => json_decode($_SESSION['productsToBuyInCart'], true),
                'qtd' => count($allItens),
                'totalItens' => $totalItens,
                'price' => $price,
                'address' => $this->getAddressUserLogged(),
                'email' => $jwtUserLogged->email,
                'name' => $jwtUserLogged->username,
                'wallet' => $this->getMoneyUser(),
                'nameProduct' => "Compra de <b>$itens</b> item pelo carrinho de compra"    
            ]);

           
        }


        public function returnSuccesCart(){
            
            if(!isset($_SESSION['jwtTokenUser'])) {
                header("Location: " . BASE_URL . "/auth/login");
                exit;
            }

            if(!isset($_GET['paymentId']) || !isset($_GET['token']) || !isset($_GET['PayerID'])){
                header("Location:" . BASE_URL . "/carrinho-de-compras");
                exit;
            }

            if(!isset($_SESSION['productsToBuyInCart'])){
                header("Location:" . BASE_URL . "/carrinho-de-compras");
                exit;
            }

            $jwtUserLogged = JWT::decode($_SESSION['jwtTokenUser'], SECRET_KEY, ['HS256']);

            $allItens = json_decode($_SESSION['productsToBuyInCart'], true);
            $price = 0.00;

            foreach($allItens as $item){
                $price += ($item['total']);
            }

            $itens = count($allItens);

            foreach($allItens as $item) {
                try{
                    $query = "INSERT INTO productsbuyed(idProductBuy,idUserBuy,paymentId,token,PayerID,pricePaid) VALUES (:idProduct,:idUser,:payId,:token,:payerId,:pricePaid)";
                    $stmt = $this->conn->prepare($query);
    
                    $stmt->execute([
                        ':idProduct' => $item['product'],
                        ':idUser' => $jwtUserLogged->id,
                        ':payId' =>  $_GET['paymentId'] . rand(1,99999999999),
                        ':token' =>  $_GET['token'] . rand(1,99999999999),
                        ':payerId' => $_GET['PayerID'] . rand(1,99999999999),
                        ':pricePaid' => $item['total']
                    ]);
    
                    $queryToUpdatePurchase = "UPDATE products SET purchased_items = purchased_items + 1, estq = estq -1 WHERE id_product = :id";
                    $stmt = $this->conn->prepare($queryToUpdatePurchase);
                    $stmt->execute([
                        ':id' => $item['product']
                    ]);
                }catch(\Exception $e) {
                    var_dump($e);
                    exit;
                }
            }

            $query2 = "DELETE  FROM shoppingcart WHERE id_user = :id";
            $stmt = $this->conn->prepare($query2);
            $stmt->execute([
                ':id' => $jwtUserLogged->id
            ]);

            echo $this->view->render('successCartBuy', [
                'title' => 'Elegance - Comprar itens do carrinho!',
                'allProducts' => json_decode($_SESSION['productsToBuyInCart'], true),
                'price' => $price,     
                'nameProduct' => "Compra de <b>$itens</b> item pelo carrinho de compra"           
            ]);
            
            unset($_SESSION['productsToBuyInCart']);

        }
    }