<?php

namespace Source\App;

use Firebase\JWT\JWT;
use CoffeeCode\Uploader\Image;

class AdminController
{

    public function __construct()
    {
        !session_start() && session_start();

        $this->view = new \League\Plates\Engine(__DIR__ . "/../../views/admin");

        $this->conn = new \PDO("mysql:host=localhost;dbname=elegancebd", "root", "");
        $this->conn->setAttribute(\PDO::ATTR_ERRMODE, \PDO::ERRMODE_EXCEPTION);
    }

    public function index($data) 
    {
        if(!isset($_SESSION['jwtToken'])) {
            header("Location: ". BASE_URL. "/");
            exit;
        }

        $_SESSION['infoNamePage'] = "/";
        $infoAdminLogged = JWT::decode($_SESSION['jwtToken'], SECRET_KEY, ['HS256']);
        
        echo $this->view->render('adminDashboard', [
            "title" => "Administração - Dashboard",
            "admin" => $infoAdminLogged
        ]);

        
    }
    public function cadProduct() {

        if(!isset($_SESSION['jwtToken'])) {
            header("Location: ". BASE_URL. "/");
            exit;
        }

        $_SESSION['infoNamePage'] = "cadProduct";

        $infoAdminLogged = JWT::decode($_SESSION['jwtToken'], SECRET_KEY, ['HS256']);
        $categories = [...$this->getCategories()];

        echo $this->view->render('cadProducts', [
            "title" => "Administração - Dashboard",
            "admin" => $infoAdminLogged,
            "categories" => $categories,
        ]);

    }

    public function cadCategory() {
        
        if(!isset($_SESSION['jwtToken'])) {
            header("Location: ". BASE_URL. "/");
            exit;
        }

        $_SESSION['infoNamePage'] = "cadCategory";
        $categories = [...$this->getCategories()];
        $count = 0;
        foreach ($categories as  $value) {
            $count++;
        }
        echo $this->view->render('cadCategory', [
            "title" => "Administração - Dashboard",
            "categories" => $categories,
            "qtdCategories" => $count
        ]);
    }
    public function delProduct() {
        
        if(!isset($_SESSION['jwtToken'])) {
            header("Location: ". BASE_URL. "/");
            exit;
        }
        
        $totalItems = $this->getAllProducts();
        $totalPage = intval(ceil($totalItems / 12)); 

        if(isset($_GET['page'])){

            if($_GET['page'] > $totalPage){
                header("Location: ". BASE_URL. "/admin/exclusao-de-produtos?page=$totalPage");
                exit;
            }
            $page = $_GET['page'];
            $totalItems = $this->getAllProducts();
            
            $page = $page -1;

            if($_GET['page'] == 0){
                $page = 0;
            }

            if($_GET['page'] > $totalPage){
                $page = $totalPage;
            }
            
            $offset = intval(($page * 12));
        }else{
            $offset = 0;
        }


        $_SESSION['infoNamePage'] = "delProduct";

        $infoAdminLogged = JWT::decode($_SESSION['jwtToken'], SECRET_KEY, ['HS256']);

        $query = "SELECT * FROM products ORDER BY id_product DESC LIMIT 12 OFFSET $offset ";
        $stmt = $this->conn->prepare($query);
        $stmt->execute();

        $allProducts = $stmt->fetchAll(\PDO::FETCH_ASSOC);

     
        echo $this->view->render('delProducts', [
            "title" => "Administração - Dashboard",
            "admin" => $infoAdminLogged,
            "products" => $allProducts,
            "maxLenght" => ceil($totalPage)
        ]);

    }

    public function getAllProducts() {
        
        if (!isset($_SESSION['jwtToken'])) {
            echo json_encode(['error' => 'Authentication failed']);
            exit;
        }

        $query = "SELECT * FROM products";
        $stmt = $this->conn->prepare($query);
        $stmt->execute();

        return $stmt->rowCount();

    }

    public function upProduct() {

        if(!isset($_SESSION['jwtToken'])) {
            header("Location: ". BASE_URL. "/");
            exit;
        }

        $_SESSION['infoNamePage'] = "upProduct";

        $infoAdminLogged = JWT::decode($_SESSION['jwtToken'], SECRET_KEY, ['HS256']);
        
        echo $this->view->render('upProducts', [
            "title" => "Administração - Dashboard",
            "admin" => $infoAdminLogged
        ]);
    }

    public function getCategories():Array
    {
        $query = "SELECT * FROM categories";
        $stmt = $this->conn->prepare($query);
        $stmt->execute();

        if($stmt->rowCount() == 0) return [];

        return $stmt->fetchAll(\PDO::FETCH_ASSOC);

    }


    public function auth()
    {
        if(!isset($_SESSION['jwtToken'])){

            echo $this->view->render('authAdmin', [
                "title" => "Administração - Autentificação de administrador"
            ]);
            return;
        }

        header("Location: ". BASE_URL. "/admin");
        exit;
        
    }   

    public function configs() {
        if(!isset($_SESSION['jwtToken'])) {
            header("Location: ". BASE_URL. "/");
            exit;
        }

        $_SESSION['infoNamePage'] = "configs";

        $infoAdminLogged = JWT::decode($_SESSION['jwtToken'], SECRET_KEY, ['HS256']);
        
        echo $this->view->render('configStore', [
            "title" => "Administração - Dashboard",
            "admin" => $infoAdminLogged
        ]);
    }

    public function comments(){
        if(!isset($_SESSION['jwtToken'])) {
            header("Location: ". BASE_URL. "/");
            exit;
        }

        
        $_SESSION['infoNamePage'] = "comentarios";
        
        $infoAdminLogged = JWT::decode($_SESSION['jwtToken'], SECRET_KEY, ['HS256']);
        

        echo $this->view->render('comments', [
            "title" => "Administração - Comentarios",
            "admin" => $infoAdminLogged,
            "comments" => $this->getAllComments()
        ]);
    }


    private function getAllComments() {

        $query = "SELECT * FROM comments 
            INNER JOIN  products ON (comments.id_product = products.id_product)
            INNER JOIN users ON (comments.id_user = users.id) ORDER BY comments.id_column
         ";
        $stmt = $this->conn->prepare($query);
        $stmt->execute();

        return $stmt->fetchAll(\PDO::FETCH_ASSOC);

    }
     
}
