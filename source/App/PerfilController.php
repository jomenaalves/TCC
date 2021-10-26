<?php 
   
   namespace Source\App;

use Firebase\JWT\JWT;

class PerfilController
    {
        private $conn;

        public function __construct()
        {
            
            !session_start() && session_start();

            $this->view = new \League\Plates\Engine(__DIR__ . "/../../views/user/");
    
            $this->conn = new \PDO("mysql:host=localhost;dbname=elegancebd", "root", "");
            $this->conn->setAttribute(\PDO::ATTR_ERRMODE, \PDO::ERRMODE_EXCEPTION);
        }

        public function index()
        {
            
            if(!isset($_SESSION['jwtTokenUser'])) {
                header("Location: " . BASE_URL . "/");
                exit;
            }

            echo $this->view->render('perfil', [
                "title" => "Elegance - Carrinho de compras",
                "address" => $this->getAddress()
            ]);
        }

       
        public function getAddress() {


            $jwtUserLogged = JWT::decode($_SESSION['jwtTokenUser'], SECRET_KEY, ['HS256']);

            $query = "SELECT * FROM address_user WHERE id_user = :id";
            $stmt = $this->conn->prepare($query);

            $stmt->execute([
                ':id' => $jwtUserLogged->id
            ]);

            return $stmt->fetchAll(\PDO::FETCH_ASSOC);

        }

        private function getProductPurchased() {

            $jwtUserLogged = JWT::decode($_SESSION['jwtTokenUser'], SECRET_KEY, ['HS256']);

            $query = "SELECT * FROM productsbuyed INNER JOIN products
            ON productsbuyed.idProductBuy = products.id_product WHERE idUserBuy = :id ORDER BY productsbuyed.id DESC";

            $stmt = $this->conn->prepare($query);
            $stmt->execute([
                ':id' => $jwtUserLogged->id
            ]);

            return $stmt->fetchAll(\PDO::FETCH_ASSOC);
            

        }

        private function getMoneyUser() {

            $jwtUserLogged = JWT::decode($_SESSION['jwtTokenUser'], SECRET_KEY, ['HS256']);

            $query = "SELECT moneyUser FROM users WHERE id = $jwtUserLogged->id";
            $stmt = $this->conn->prepare($query);
            $stmt->execute();

            return $stmt->fetch(\PDO::FETCH_ASSOC)['moneyUser'];

        }

        private function getTranslactions() {

            $jwtUserLogged = JWT::decode($_SESSION['jwtTokenUser'], SECRET_KEY, ['HS256']);

            $query = "SELECT * FROM translationswallet WHERE id_user = $jwtUserLogged->id";
            $stmt = $this->conn->prepare($query);
            $stmt->execute();

            return $stmt->fetchAll(\PDO::FETCH_ASSOC);

        }

        public function requests() {
               
            if(!isset($_SESSION['jwtTokenUser'])) {
                header("Location: " . BASE_URL . "/");
                exit;
            }

            
            echo $this->view->render('requests', [
                "title" => "Elegance - Suas compras",
                'productsPcs' => $this->getProductPurchased()
            ]);
        }

        public function wallet() {

            if(!isset($_SESSION['jwtTokenUser'])) {
                header("Location: " . BASE_URL . "/");
                exit;
            }
            
            echo $this->view->render('wallet', [
                "title" => "Elegance - Sua carteira",
                'productsPcs' => $this->getProductPurchased(),
                'money' => $this->getMoneyUser(),
                'translactions' => $this->getTranslactions()
            ]);

        }

        /**
         * Metódo responsavel por mostrar a pagina de avaliaçoes
         * @param Array
         */
        public function avaliable($data) {

            echo $this->view->render('avaliable', [
                "title" => "Elegance - Sua avaliações",
                "avaliables" => $this->getAllProductsPurchased()
            ]);

        }


        /**
         * Método responsavel por pegar os produtos comprados e que já foram entregue
         * @return Array
         */
        private function getAllProductsPurchased() {

            // decoding of jwt 
            $jwtUserLogged = JWT::decode($_SESSION['jwtTokenUser'], SECRET_KEY, ['HS256']);

            // get all products bought by user
            $query = "SELECT * FROM productsbuyed INNER JOIN products 
                     ON productsbuyed.idProductBuy = products.id_product 
                     WHERE productsbuyed.idUserBuy = :idUser AND productsbuyed.statusProduct = 2";
            $stmt = $this->conn->prepare($query);
            $stmt->bindValue(':idUser', $jwtUserLogged->id);
            $stmt->execute();

            $allProductsPurchased = $stmt->fetchAll(\PDO::FETCH_ASSOC);

            return $allProductsPurchased;

        }


        /**
         * Método responsavel por fazer a avaliação do produto
         * @return Bool
         */
        private function makeRating() {

            if($this->getAllProductsPurchased() !== []) {
                


            }

        }
    }