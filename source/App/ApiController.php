<?php

namespace Source\App;

use CoffeeCode\Uploader\Image;
use DateTime;
use Firebase\JWT\JWT;
use FlyingLuscas\Correios\Client;
use FlyingLuscas\Correios\Service;
use JetBrains\PhpStorm\NoReturn;

class ApiController
{
    private $conn;

    public function __construct() {

        !session_start() && session_start();

        $this->conn = new \PDO("mysql:host=localhost;dbname=elegancebd", "root", "");
        $this->conn->setAttribute(\PDO::ATTR_ERRMODE, \PDO::ERRMODE_EXCEPTION);
    }


    public function verifyEmail(array $data) {
  
        $email = filter_var($data['email'], FILTER_SANITIZE_EMAIL);

        $query = "SELECT id FROM admins WHERE email = :e ";
        $stmt = $this->conn->prepare($query);
        $stmt->bindValue(':e', $email);
        $stmt->execute();

        $row = $stmt->rowCount();

        if ($row == 1) {
            echo json_encode(['isAdmin' => true]);
            return;
        }

        echo json_encode(['isAdmin' => false]);
        return;
    }

    public function VerifyPassAndLogin(array $data) {


        $authentication = [
            'email' => filter_var($data['email'], FILTER_SANITIZE_EMAIL),
            'password' => filter_var($data['passwd'], FILTER_SANITIZE_STRING),
            'secret' => filter_var($data['secret'], FILTER_SANITIZE_STRING)
        ];

        $query = "SELECT id,nome,isMaster FROM admins WHERE email = :e AND passwd = :p AND secretWord = :s";
        $stmt = $this->conn->prepare($query);
        $stmt->bindValue(':e', $authentication['email']);
        $stmt->bindValue(':p', $authentication['password']);
        $stmt->bindValue(':s', $authentication['secret']);
        $stmt->execute();

        if ($stmt->rowCount() == 0) {
            echo json_encode(['isLogged' => false, 'error' => 'email, senha ou palavra secreta não correspondem']);
            return;
        }

        $_SESSION['jwtToken'] = JWT::encode($stmt->fetchAll(\PDO::FETCH_ASSOC), SECRET_KEY);
        echo json_encode(['isLogged' => true, 'error' => 0]);
        return;
    }

    public function cadProductApi() 
    {
        if (!isset($_SESSION['jwtToken'])) {
            echo json_encode(['error' => 'Authentication failed']);
            exit;
        }

        foreach ($_POST as $key => $value) {
            if ($value == " " || $value == "") {
                echo json_encode(['error' => 'Preencha todos os campos']);
                return;
            }
        }

        if (!$_FILES) {
            echo json_encode(['error' => 'Imagem não pode ser nula']);
            return;
        }

        //verificar se nome é possivel
        $query1 = "SELECT * FROM products WHERE nome = :n";
        $stmt = $this->conn->prepare($query1);
        $stmt->execute([':n' => filter_var($_POST['nome'], FILTER_SANITIZE_STRING)]);

        if($stmt->rowCount() > 0) {
            echo json_encode(['error' => 'Nome do produto já cadastrado!', 'NameIsPossible' => false]);
            return;
        }

        try {
            $image = new Image("storage", "images", 600);
            $upload = $image->upload($_FILES['image'], $_POST['nome']);
        } catch (\Exception $e) {
            echo json_encode(['error' => $e]);
            return;
        }

        if ($upload) {

            $query2 = "INSERT INTO products(nome,sex,category,tam,UniqueOrLot,nPieces,estq,InitialPrice,InitialDiscount,photoProduct,descProduct)
                VALUES (:n, :s, :c, :t, :u, :np, :es, :ip, :id, :im, :ds)";

            $stmt = $this->conn->prepare($query2);
            $stmt->execute([
                ':n' => filter_var($_POST['nome'], FILTER_SANITIZE_STRING),
                ':s' =>  filter_var($_POST['sex'], FILTER_SANITIZE_STRING),
                ':c' =>  filter_var($_POST['category'], FILTER_SANITIZE_STRING),
                ':t' =>  filter_var($_POST['tam'], FILTER_SANITIZE_STRING),
                ':u' =>  filter_var($_POST['group'], FILTER_SANITIZE_STRING),
                ':np' =>  filter_var($_POST['piece'], FILTER_SANITIZE_STRING),
                ':es' =>  filter_var($_POST['estq'], FILTER_SANITIZE_STRING),
                ':ip' =>  filter_var($_POST['InitialPrice'], FILTER_SANITIZE_STRING),
                ':id' =>  filter_var($_POST['InitialDiscount'], FILTER_SANITIZE_STRING),
                ':im' =>  $upload,
                ':ds' =>  filter_var($_POST['desc'], FILTER_SANITIZE_STRING),
            ]);

            $q3 = "SELECT id_product FROM products WHERE nome = :n";
            $stmt = $this->conn->prepare($q3);
            $stmt->execute([':n' => filter_var($_POST['nome'], FILTER_SANITIZE_STRING)]);

            $id = $stmt->fetch(\PDO::FETCH_ASSOC)['id_product'];
        
            $_SESSION['lastProductAdd'] = $id;

            echo json_encode(['success' => true]);
            return; 
        }

    }

    public function addPhotos() {

        $id = $_SESSION['lastProductAdd'];
     
        try {
            $image = new Image("storage", "images", 600);
            $upload = $image->upload($_FILES['image'], $_SESSION['lastProductAdd']);
        } catch (\Exception $e) {
            echo json_encode(['error' => $e]);
            return;
        }

        $query = "INSERT INTO allphotosproducts(id_product,photo) VALUES (:id,:ph)"; 
        $stmt = $this->conn->prepare($query);

        if($stmt->execute([':id' => $id,':ph' => $upload])){
            echo json_encode(['success' => true]);
            return;
            
        echo json_encode(['chegou aki' => true,'id' => $_SESSION['lastProductAdd']]);
        return;
        }

        echo json_encode(['error' => 'Falha ao cadastrar no banco de dados!']);
        return;

    }
    public function cadCategory() {

        if (!isset($_SESSION['jwtToken'])) {
            echo json_encode(['error' => 'Authentication failed']);
            exit;
        }

    
        try {
            $image = new Image("storage", "images", 600);
            $upload = $image->upload($_FILES['image'], $_POST['name']);
        } catch (\Exception $e) {
            echo json_encode(['error' => $e]);
            return;
        }

        //verificar se nome é possivel
        $q = "SELECT id FROM categories WHERE nome = :n";
        $stmt = $this->conn->prepare($q);
        $stmt->execute([':n' => filter_var($_POST['name'], FILTER_SANITIZE_STRING)]);

        if($stmt->rowCount() > 0) {
            echo json_encode(['error' => 'Nome da categoria já cadastrado!', 'NameIsPossible' => false]);   
            return;
        }

        $query = "INSERT INTO categories(nome,photoCategory) VALUES (:n, :p)";
        $stmt = $this->conn->prepare($query);
        $register = $stmt->execute([
            ':n' => filter_var($_POST['name'], FILTER_SANITIZE_STRING),
            ':p' => $upload
        ]);

        if($register){
            echo json_encode(['status' => 200, 'ok' => true, 'NameIsPossible' => true]);
            return;
        }

        echo json_encode(['error' => 'Falha ao cadastrar categoria no banco de dados!']);
        return;
    }

    public function getCategories()
    {
        $query = "SELECT * FROM categories";
        $stmt = $this->conn->prepare($query);
        $stmt->execute();

        if($stmt->rowCount() == 0){
            echo json_encode(['ok' => false]);
            return;
        }
        echo json_encode(['categories' => $stmt->fetchAll(\PDO::FETCH_ASSOC), 'ok' => true]);
        return;
    }

    public function delCategory() {

        if (!isset($_SESSION['jwtToken'])) {
            echo json_encode(['error' => 'Authentication failed']);
            exit;
        }

        $query = "DELETE FROM categories WHERE id = :id";
        $stmt = $this->conn->prepare($query);
        $stmt->bindValue(':id', filter_var($_POST['id'], FILTER_SANITIZE_NUMBER_INT));

        if($stmt->execute()) {
            echo json_encode(['status' => 200, 'ok' => true]);
            return;
        }

        echo json_encode(['error' => 'Failed to delete from database', 'ok' => false]);
        return;

    }

    

    public function getAllProductsToApi() {
        
        if (!isset($_SESSION['jwtToken'])) {
            echo json_encode(['error' => 'Authentication failed']);
            exit;
        }

        $query = "SELECT * FROM products";
        $stmt = $this->conn->prepare($query);
        $stmt->execute();

        return $stmt->rowCount();

    }
    public function deleteProduct($data) {
        
        if (!isset($_SESSION['jwtToken'])) {
            echo json_encode(['error' => 'Authentication failed']);
            exit;
        }

        $id = filter_var($data['id'], FILTER_SANITIZE_NUMBER_INT);

        $query = "DELETE FROM products WHERE id_product = :id";
        $stmt = $this->conn->prepare($query);

        if($stmt->execute([":id" => $id])) {
            echo json_encode(['success' => true]);
            return;
        }

        echo json_encode(['success' => false]);
        return;

    }

    public function getAllProducts($data) {
        
        if (!isset($_SESSION['jwtToken'])) {
            echo json_encode(['error' => 'Authentication failed']);
            exit;
        }

        $page =  $data['start'];
        $totalItems = $this->getAllProductsToApi();
        $totalPage = intval(ceil($totalItems / 12)); 
        
        $page = intval($page) -1;

        if( $data['start'] < 0){
            $page = 1;
        }

        if( $data['start'] > $totalPage){
            $page = $totalPage;
        }
        
        $offset = intval(($page * 12)); // 10

        $query = "SELECT * FROM products ORDER BY id_product LIMIT 12 OFFSET $offset ";
        $stmt = $this->conn->prepare($query);
        $stmt->execute();

        if($stmt->rowCount() > 0) {

            echo json_encode(['products' => $stmt->fetchAll(\PDO::FETCH_ASSOC)]);
            return;

        }

        echo json_encode(['products' => []]);
        return;

    }


    public function numberOfProducts() {
          
        if (!isset($_SESSION['jwtToken'])) {
            echo json_encode(['error' => 'Authentication failed']);
            exit;
        }
     
          
        $query = "SELECT * FROM products";
        $stmt = $this->conn->prepare($query);
        $stmt->execute();

        echo json_encode($stmt->rowCount());
        return;

    }


    public function checkIfUserIsLogged() {
      
        if(isset($_SESSION['jwtTokenUser'])){
      
            $jwt = JWT::decode($_SESSION['jwtTokenUser'], SECRET_KEY, ['HS256']);  

            //verify if Email exists
            $query = "SELECT id FROM users WHERE email = :e";
            $stmt = $this->conn->prepare($query);
            $stmt->bindValue(":e", $jwt->email);
            $stmt->execute();

            $row = $stmt->rowCount();

            if($row == 0) {
                echo json_encode(['isLogged' => false]);
                return;
            }
            echo json_encode(['isLogged' => true]);
            return;
        }
       
        echo json_encode(['isLogged' => false]);
        return;
    }

    public function addToCard() {
          
        if (!isset($_SESSION['jwtTokenUser'])) {
            echo json_encode(['error' => 'Authentication failed']);
            exit;
        }

        $idProduct = filter_var($_POST['idProduct'], FILTER_SANITIZE_NUMBER_INT);

        $jwtUserLogged = JWT::decode($_SESSION['jwtTokenUser'], SECRET_KEY, ['HS256']);
 
        $queryToVerifyIfProductHasBeenRegister = "SELECT id FROM shoppingcart WHERE id_product = :id";
        $stmt = $this->conn->prepare($queryToVerifyIfProductHasBeenRegister);
        $stmt->bindValue(':id', $idProduct);
        $stmt->execute();

        $numRows = $stmt->rowCount();

       
        if($numRows == 0) {


            $queryToInsertProductToShoppingCart =
                 "INSERT INTO shoppingcart(id_product,id_user) VALUES (:idProduct, :idUser)";
            $stmt = $this->conn->prepare($queryToInsertProductToShoppingCart);
            $stmt->bindValue(':idProduct', $idProduct);
            $stmt->bindValue('idUser', $jwtUserLogged->id);
            $exec = $stmt->execute();

            if($exec) {
                echo json_encode(['success' => true]);
                return;
            }

            echo json_encode(['success' => false, 'error' => 'Falha ao adicionar ao banco']);
            return;
        
        }

        echo json_encode(['success' => false]);
    }

    public function removeFromCart(){
            
        if (!isset($_SESSION['jwtTokenUser'])) {
            echo json_encode(['error' => 'Authentication failed']);
            exit;
        }
        
        $idProduct = filter_var($_POST['idProduct'], FILTER_SANITIZE_NUMBER_INT);

        $jwtUserLogged = JWT::decode($_SESSION['jwtTokenUser'], SECRET_KEY, ['HS256']);

        $queryToRemoveProduct = "DELETE FROM shoppingcart WHERE id_product = :idP AND id_user = :idU";
        $stmt = $this->conn->prepare($queryToRemoveProduct);
        $stmt->bindValue(':idP', $idProduct);
        $stmt->bindValue(':idU', $jwtUserLogged->id);
        $exec = $stmt->execute();

        if($exec) {
            echo json_encode(['success' => true]);
            return;
        }

        echo json_encode(['success' => false]);
        return;
    }

    public function upConfig() {

        if (!isset($_SESSION['jwtToken'])) {
            echo json_encode(['error' => 'Authentication failed']);
            exit;
        }
     
        $allKeys = [];
        foreach ($_POST as $key => $value) {
            array_push($allKeys, $key);
        }
        
        $query = "UPDATE config SET cepOrigem = :cep, kg = :kg, embalagem = :emb, serviceCorr = :serv";
        $stmt = $this->conn->prepare($query);
        $stmt->execute([
            ':cep' => $_POST['cepOrigem'],
            ':kg' => $_POST['kg'],
            ':emb' => $_POST['embalagem'],
            ':serv' => $_POST['serviceCorr']
        ]);


        echo json_encode(['stmt' => $stmt->rowCount()]);
    }

    public function frete() {

        if (!isset($_SESSION['jwtTokenUser'])) {
            echo json_encode(['error' => 'Authentication failed']);
            exit;
        }
        
        $cep = filter_var($_POST['cep'], FILTER_SANITIZE_NUMBER_INT);

        $getAllConfigToCorreios = "SELECT * FROM config";
        $stmt = $this->conn->prepare($getAllConfigToCorreios);
        $stmt->execute();

        $config = $stmt->fetch(\PDO::FETCH_ASSOC);

        $correios = new Client();

        $rows = $stmt->rowCount();

        if($rows == 6) $rows = 6;
        
        $service = Service::SEDEX;
        switch ($config['serviceCorr']) {
            case 'SEDEX' :
                $service = Service::SEDEX;
            break;
            case 'PAC' :
                $service = Service::PAC;
            break;
            default : 
                $service = Service::SEDEX;
            break;
        }
        
        try{
           $city = @$correios?->zipcode()?->find($cep);

        }catch(\Exception $e) {
            echo json_encode(['error' => true]);
            return;
        }

        if(!isset($city['error'])){
            if(isset($city['zipcode'])) {

                $frete = @$correios->freight()
                ->origin($config['cepOrigem'])
                ->destination($city['zipcode'])
                ->services($service)
                ->item(16,16,16, $config['kg'] * $rows, 1)
                ->calculate();
                
                echo json_encode(['frete' => $frete, 'cep' => $city]);
                return;
            }
          

            echo json_encode(['error' => true]);
            return;
        }

        echo json_encode(['error' => true]);
        return;

    }

    public function totalItensInCart() {

        if (!isset($_SESSION['jwtTokenUser'])) {
            echo json_encode(['error' => 'Authentication failed']);
            exit;
        }

        $jwtUserLogged = JWT::decode($_SESSION['jwtTokenUser'], SECRET_KEY, ['HS256']);

        $query = "SELECT id FROM shoppingcart WHERE id_user = :id";
        $stmt = $this->conn->prepare($query);
        $stmt->bindValue(':id', $jwtUserLogged->id);
        
        
        if($stmt->execute()) {
            echo json_encode(['rows' => $stmt->rowCount()]);
            return;
        }

        
        echo json_encode(['rows' => 0]);
    }


    public function addAddress() {

        if (!isset($_SESSION['jwtTokenUser'])) {
            echo json_encode(['error' => 'Authentication failed']);
            exit;
        }

        $jwtUserLogged = JWT::decode($_SESSION['jwtTokenUser'], SECRET_KEY, ['HS256']);


        
        $query = "SELECT * FROM address_user WHERE address_user = :address_user AND id_user = :id";
        $stmt = $this->conn->prepare($query);
        $stmt->bindValue(':address_user', $_POST['end']);
        $stmt->bindValue(':id', $jwtUserLogged->id);
        $stmt->execute();

        if($stmt->fetchAll() == []) {
       

            $q = "INSERT INTO address_user(id_user,address_user,type_address,number_address,reference,district,city,uf,principal)
            VALUES(:id,:address_user, :type_address, :number_address, :reference, :district, :city, :uf, :principal)";

            $stmt2 = $this->conn->prepare($q);

            $stmt2->bindValue(":id", $jwtUserLogged->id);
            $stmt2->bindValue(":address_user", $_POST['end']);
            $stmt2->bindValue(":type_address", $_POST['type']);
            $stmt2->bindValue(":number_address", intval($_POST['number']));
            $stmt2->bindValue(":reference", $_POST['info']);
            $stmt2->bindValue(":district", $_POST['bair']);
            $stmt2->bindValue(":city", $_POST['city']);
            $stmt2->bindValue(":uf", $_POST['uf']);
            $stmt2->bindValue(":principal", 0);


            if($stmt2->execute()) {
                echo json_encode(['add' => true, 'error' => ""]);
                return;
            }

            echo json_encode(['add' => false, 'error' => 'Falha ao adicionar na base de dados!']);
            return;
        }

        echo json_encode(['add' => false, 'error' => ""]);
        return;
    }



    public function removeAddress() {

        if (!isset($_SESSION['jwtTokenUser'])) {
            echo json_encode(['error' => 'Authentication failed']);
            exit;
        }

        $jwtUserLogged = JWT::decode($_SESSION['jwtTokenUser'], SECRET_KEY, ['HS256']);

        $queryToDeleteAddress = "DELETE FROM address_user WHERE id = :id AND id_user = :id_user";
        $stmt = $this->conn->prepare($queryToDeleteAddress);
        $returnOfQuery = $stmt->execute([':id' => $_POST['id_product'],':id_user' => $jwtUserLogged->id]);

        if(!$returnOfQuery) {
            echo json_encode(['success' => false]);
            return;
        }


        echo json_encode(['success' => true]);
        return;

    }

    /**
     * Metódo responsavel por atualizar quantidade de estrelas 
     * @param Array
     * @return Boll
     */
    public function updateStars( $data ){

        if (!isset($_SESSION['jwtTokenUser'])) {
            echo json_encode(['error' => 'Authentication failed']);
            exit;
        }

        $jwtUserLogged = JWT::decode($_SESSION['jwtTokenUser'], SECRET_KEY, ['HS256']);


        $qtdStars = $data['qtd'];
        $from = $data['from'];

        $query = "UPDATE productsbuyed SET already_rated = 1, totalStars = :total WHERE id = :id AND idUserBuy = :idUser";
        $stmt = $this->conn->prepare($query);
        $stmt->bindValue(':total', $qtdStars);
        $stmt->bindValue(':id', $from);
        $stmt->bindValue(':idUser', $jwtUserLogged->id);
        $exec = $stmt->execute();
        
        if($exec) {
            echo json_encode(true);
            return;
        }

        echo json_encode(false);
        return;

    }

    public function makeComment() {

        if (!isset($_SESSION['jwtTokenUser'])) {
            echo json_encode(['error' => 'Authentication failed']);
            exit;
        }

        $jwtUserLogged = JWT::decode($_SESSION['jwtTokenUser'], SECRET_KEY, ['HS256']);
        $comment = $_POST['comment'];
        $idProduct = $_POST['id'];

        $query = "INSERT INTO comments(id_product,comment,id_user) VALUES (:idP,:Cm, :idU)";

        $stmt = $this->conn->prepare($query);
        $return = $stmt->execute([
            ':idP' => $idProduct,
            ':Cm' => $comment,
            ':idU' => $jwtUserLogged->id
        ]);

        if($return){
            echo json_encode(true);
            return;
        }

        echo json_encode(false);
        return;
    }


    # Method responsible for removing the product from the cart
    public function postRemoveFromCart(Array $data): void
    {
        // Filtering incoming data
        $idProduct = filter_var($data['id'], FILTER_SANITIZE_NUMBER_INT);

        // jwt from user logged
        $jwtUserLogged = JWT::decode($_SESSION['jwtTokenUser'], SECRET_KEY, ['HS256']);

        // Making  query to remove this product
        $query = "DELETE FROM shoppingcart WHERE id = :id AND id_user = :idUser";
        $stmt = $this->conn->prepare($query);
        $isSuccessful = $stmt->execute([':id' => $idProduct, ':idUser' => $jwtUserLogged->id]);

        // return of request
        if($isSuccessful) {
            echo json_encode(['success' => true]);
            return;
        }
        
        echo json_encode(['success' => false]);
        return;
    }

    # Method responsible to create a section for itens in cart
    public function generateSectionFromShoppingCart():void
    {
        if (!isset($_SESSION['jwtTokenUser'])) {
            echo json_encode(['error' => 'Authentication failed']);
            exit;
        }

        $_SESSION['productsToBuyInCart'] = $_POST['products'];

        echo json_encode(['success' => true]);
        return;
    }
}
