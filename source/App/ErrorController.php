<?php 
   
   namespace Source\App;

class ErrorController
    {
        private $conn;

        public function __construct()
        {
            
            !session_start() && session_start();

            $this->view = new \League\Plates\Engine(__DIR__ . "/../../views/errors");
    
            $this->conn = new \PDO("mysql:host=localhost;dbname=elegancebd", "root", "");
            $this->conn->setAttribute(\PDO::ATTR_ERRMODE, \PDO::ERRMODE_EXCEPTION);
        }

        public function index()
        {
            
            echo $this->view->render('error404', [
                "title" => "Elegance - Carrinho de compras"
            ]);
        }

       
    }