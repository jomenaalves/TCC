<?php 
    namespace Source\App;

    class SearchController
    {
        private $conn;

        public function __construct()
        {
            
            !session_start() && session_start();

            $this->view = new \League\Plates\Engine(__DIR__ . "/../../views/user");
    
            $this->conn = new \PDO("mysql:host=localhost;dbname=elegancebd","root","");
            $this->conn->setAttribute(\PDO::ATTR_ERRMODE, \PDO::ERRMODE_EXCEPTION);
        }

        public function index($data) :void
        {
            if(isset($_GET['q'])) {
                $specialChar = filter_var($_GET['q'], FILTER_SANITIZE_FULL_SPECIAL_CHARS);
                $search = filter_var($specialChar, FILTER_SANITIZE_ADD_SLASHES);
    
    
                $query = "SELECT * FROM products WHERE nome LIKE ? LIMIT 15";
                $params = ["%$search%"];
                $stmt = $this->conn->prepare($query);
                $stmt->execute($params);
    
                $allProducts = $stmt->fetchAll(\PDO::FETCH_ASSOC);
            }
           

            echo $this->view->render('search',[
                'title' => 'Elegance | Pesquisa de produtos',
                'q' => isset($search) ? $search : null,
                'allProducts' => isset($allProducts) ? $allProducts : 'noQuery'
            ]);
        }

    }