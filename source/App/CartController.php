<?php 
   
   namespace Source\App;

    use Firebase\JWT\JWT;
    use FlyingLuscas\Correios\Client;

class CartController
    {
        private $conn;

        public function __construct()
        {
            
            !session_start() && session_start();

            $this->view = new \League\Plates\Engine(__DIR__ . "/../../views/user");
    
            $this->conn = new \PDO("mysql:host=localhost;dbname=elegancebd", "root", "");
            $this->conn->setAttribute(\PDO::ATTR_ERRMODE, \PDO::ERRMODE_EXCEPTION);
        }

        public function index()
        {
            
            echo $this->view->render('cart', [
                "title" => "Elegance - Carrinho de compras",
                "productsInCart" => $this->getAllCartProduct(),
                "totalCart" =>  $this->calculateSubTotal()
            ]);
        }

        public function getAllCartProduct() {

            if(!isset($_SESSION['jwtTokenUser'])) {
                header("Location: " . BASE_URL . "/auth/login");
                exit;
            }

            $jwtUserLogged = JWT::decode($_SESSION['jwtTokenUser'], SECRET_KEY, ['HS256']);
            $query = "SELECT * FROM shoppingcart INNER JOIN products ON shoppingcart.id_product = products.id_product WHERE id_user = :id";
            $stmt = $this->conn->prepare($query);
            $stmt->bindValue(":id", $jwtUserLogged->id);
            $stmt->execute();

            return $stmt->fetchAll(\PDO::FETCH_ASSOC);
        }

        public function calculateSubTotal() {
            $allItens = $this->getAllCartProduct();
            $count = [];
            $soma = 0;
            foreach ($allItens as $key => $value) {
               if($value['InitialDiscount'] > 0) {
                    $percent = (floatval($value['InitialPrice']) / 100) * $value['InitialDiscount'];
                                        
                    $totalFinal = floatval($value['InitialPrice']) - $percent;
                    $FinalPrice = number_format(floatval($totalFinal),2);

                    array_push($count, $FinalPrice);
                    
               }else{
                    array_push($count, $value['InitialPrice']);
               }
            }
            for($i = 0; $i < count($count); $i++) {
                $soma = $soma + floatval($count[$i]);
            }
            return number_format(floatval($soma),2);
        }
    }