<?php
 
namespace Source\App;

use Firebase\JWT\JWT;

class ProductController {
    
    private $totalAvaliations = 0;
    private $allNotes = [];

    public function __construct()
    {
        
        !session_start() && session_start();

        $this->view = new \League\Plates\Engine(__DIR__ . "/../../views/user");

        $this->conn = new \PDO("mysql:host=localhost;dbname=elegancebd","root","");
        $this->conn->setAttribute(\PDO::ATTR_ERRMODE, \PDO::ERRMODE_EXCEPTION);
    }

    public function index($data) :void
    {
        $query = "SELECT * FROM products WHERE id_product = :id";
        $stmt = $this->conn->prepare($query);
        $stmt->bindValue(':id', filter_var($data['id'], FILTER_SANITIZE_NUMBER_INT));
        $stmt->execute();

        $dataProduct = $stmt->fetch(\PDO::FETCH_ASSOC);
        
        //get category
        $query2 = "SELECT * FROM categories WHERE id = :id";
        $stmt2 = $this->conn->prepare($query2);
        $stmt2->bindValue(':id', $dataProduct['category']);
        $stmt2->execute();

        // get photos
        $query3 = "SELECT * FROM allphotosproducts WHERE id_product = :id";
        $stmt3 = $this->conn->prepare($query3);
        $stmt3->bindValue(':id', $dataProduct['id_product']);
        $stmt3->execute();

        $allPhotos = $stmt3->fetchAll();
        $category = $stmt2->fetch(\PDO::FETCH_ASSOC);
        echo $this->view->render('product',[
            "title" => "Elegance {$data['slug']}",
            "data" => $dataProduct,
            "slug" => $data['slug'],
            "category" => $category,
            "allPhotos" => $allPhotos,
            'isInTheCard' => $this->verifyIfProductIsAddToShopping($data['id']),
            "stars" => $this->getStarOfThisProductAndCalculateAverage($data['id']),
            'totalRating' => $this->totalAvaliations,
            'allNotes' => $this->allNotes,
            'lastComments' => $this->getComments($dataProduct['id_product'])

        ]);
        
        return;
        
    }

    public function verifyIfProductIsAddToShopping(Int $idProduct){

        // vefifyIfUserIsLogged

        if(isset($_SESSION['jwtTokenUser'])){
        
            $jwt = JWT::decode($_SESSION['jwtTokenUser'], SECRET_KEY, ['HS256']);  

            //verify if Email exists
            $query = "SELECT id FROM users WHERE email = :e";
            $stmt = $this->conn->prepare($query);
            $stmt->bindValue(":e", $jwt->email);
            $stmt->execute();

            $row = $stmt->rowCount();

            if($row == 0) {
                return false;
            }
           
            $query2 = "SELECT id FROM shoppingcart WHERE id_product = :idP AND id_user = :idU";
            $stmt2 = $this->conn->prepare($query2);
            $stmt2->bindValue(':idP', $idProduct);
            $stmt2->bindValue(':idU', $jwt->id);
            $stmt2->execute();

            $row = $stmt2->rowCount();
      
            if($row > 0) {
                return true;
            } 
           
            return false;
        }
        
       
        return false;
    
    }


    /**
     * Method responsible for obtaining the star rating and obtaining the average
     * @return String
     */
    public function getStarOfThisProductAndCalculateAverage(Int $id): String
    {
        // start consulting the database
        $query = "SELECT totalStars FROM productsbuyed WHERE statusProduct = 2 AND idProductBuy = :id";
        $stmt = $this->conn->prepare($query);
        $stmt->execute([':id' => $id]);

        $allAvaliations = $stmt->fetchAll(\PDO::FETCH_ASSOC);

        // Calculate average
        $notes = [];
        foreach($allAvaliations as $avaliation) 
            array_push($notes, $avaliation['totalStars']);

        $this->allNotes = $notes;
        $this->totalAvaliations = count($allAvaliations);
        $sumOfNotes = array_sum($notes);

        if($this->totalAvaliations == 0) return "0.0";
        $average = ($sumOfNotes) / $this->totalAvaliations;


        return number_format($average, 1);
    }

    public function getComments(Int $id){


        $query = "SELECT * FROM comments WHERE id_product = :id ORDER BY id_column DESC LIMIT 5";
        $stmt = $this->conn->prepare($query);
        $stmt->execute([':id' => $id]);

        $allComments = $stmt->fetchAll(\PDO::FETCH_ASSOC);

        return $allComments;

        

    }

}

