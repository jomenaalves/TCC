<?php

    namespace Source\App;


class FiltersController
{

    private $conn;

    public function __construct()
    {

        !session_start() && session_start();

        $this->view = new \League\Plates\Engine(__DIR__ . "/../../views/user");
        $this->conn = new \PDO("mysql:host=localhost;dbname=elegancebd", "root", "");
        $this->conn->setAttribute(\PDO::ATTR_ERRMODE, \PDO::ERRMODE_EXCEPTION);
    }

    public function index($data): void
    {   

        $sex = filter_var(isset($_GET['sex']) ? $_GET['sex'] : 'all', FILTER_SANITIZE_STRING);

        switch ($sex) {
            case "feminino":
                $sexConvertedToBd = "Fem";
                break;
            case "masculino":
                $sexConvertedToBd = "Masc";
                break;
            case "unissex":
                $sexConvertedToBd = "Unissex";
                break;
            case "meninos":
                $sexConvertedToBd = "Boys";
                break;
            case "meninas":
                $sexConvertedToBd = "Girls";
                break;
            case "bebes":
                $sexConvertedToBd = "Baby";
            break;
            default: 
                $sexConvertedToBd = "Masc";
        }

        $firstQuery = "SELECT * FROM products WHERE sex = :sex";
        $stmt = $this->conn->prepare($firstQuery);
        $stmt->bindValue(':sex', $sexConvertedToBd);
        $stmt->execute();

        $filteredProducts = $stmt->fetchAll(\PDO::FETCH_ASSOC);

        echo $this->view->render('filters', [
            'title' => 'Elegance | Encrontre o produto que você deseja',
            'categories' => $this->getAllCategories(),
            'firstFilter' => $filteredProducts
        ]);
    }

    public function getAllCategories() {
        $query = "SELECT nome,id FROM categories";
        $stmt = $this->conn->prepare($query);
        $stmt->execute();


        return $stmt->fetchAll(\PDO::FETCH_ASSOC);
    }

}
