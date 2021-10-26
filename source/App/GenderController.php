<?php 
    namespace Source\App;

    class GenderController
    {
        private $conn;

        public function __construct()
        {
            
            !session_start() && session_start();

            $this->view = new \League\Plates\Engine(__DIR__ . "/../../views/user");
    
            // $this->conn = new \PDO("mysql:host=localhost;dbname=Ecommerce", BD_USERNAME, BD_PASS);
            // $this->conn->setAttribute(\PDO::ATTR_ERRMODE, \PDO::ERRMODE_EXCEPTION);
        }

        public function index($data) :void
        {
            if($data['gender'] == "espaco-mulher"){
                echo $this->view->render('gender',[
                    "title" => "Elegance - Produtos femininos na Elegance",
                    "category_name" => "Moda Feminina"
                ]);
                return;
            }
            // echo $this->view->render('home',[
            //     "title" => "Elegance - Os melhores produtos você encontra aki!"
            // ]);
        }
    }