<?php 
    namespace Source\App;
    use Firebase\JWT\JWT;

    class HomeController
    {
        private $conn;

        public function __construct()
        {
            
            !session_start() && session_start();

            $this->view = new \League\Plates\Engine(__DIR__ . "/../../views/user");
    
            $this->conn = new \PDO("mysql:host=localhost;dbname=elegancebd","root","");
            $this->conn->setAttribute(\PDO::ATTR_ERRMODE, \PDO::ERRMODE_EXCEPTION);
        }

        public function index() :void
        {
            //get allCategories
            $query = "SELECT * FROM categories";
            $stmt = $this->conn->prepare($query);
            $stmt->execute();

            //get 20 lastProducts
            $query2 = "SELECT id_product,nome,InitialDiscount,InitialPrice,photoProduct FROM products ORDER BY id_product DESC LIMIT 10 ";
            $stmt2 = $this->conn->prepare($query2);
            $stmt2->execute();
            $lastProducts = $stmt2->fetchAll(\PDO::FETCH_ASSOC);
            
            echo $this->view->render('home',[
                "title" => "Elegance - Os melhores produtos você encontra aki!",
                "categories" => $stmt->fetchAll(\PDO::FETCH_ASSOC),
                "lastProducts" => $lastProducts,
                'bestSellers' => $this->getBestSellers()
            ]);
        }

      
        
        public function getBestSellers() {

            $query = "SELECT * FROM products ORDER BY purchased_items DESC LIMIT 10";
            $stmt = $this->conn->prepare($query);

            $stmt->execute();

            $rows = $stmt->fetchAll(\PDO::FETCH_ASSOC);

            return $rows;

        }


    }