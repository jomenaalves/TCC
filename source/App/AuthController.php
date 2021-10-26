<?php 
    namespace Source\App;

use Exception;
use Firebase\JWT\JWT;

class AuthController
    {
        private $conn;

        public function __construct()
        {
            
            !session_start() && session_start();

            $this->view = new \League\Plates\Engine(__DIR__ . "/../../views/user/auth");
    
            $this->conn = new \PDO("mysql:host=localhost;dbname=elegancebd", "root", "");
            $this->conn->setAttribute(\PDO::ATTR_ERRMODE, \PDO::ERRMODE_EXCEPTION);
        }

        public function index()
        {
            echo $this->view->render('login', [
                "title" => "Elegance - Autentificação de usuario",
            ]);
        }

        public function register() {


            if(base64_decode( $_REQUEST['token'] ) == $_SESSION['token']) {
                //cadastrar no banco
                $query = "INSERT INTO users (email,pass, username) VALUES (:e, :p, :u)";
                $stmt = $this->conn->prepare($query);
                $stmt->bindValue(':e', filter_var($_REQUEST['email'], FILTER_SANITIZE_EMAIL));
                $stmt->bindValue(':p', password_hash($_REQUEST['passwd'], PASSWORD_DEFAULT));
                $stmt->bindValue(':u', filter_var($_REQUEST['username'], FILTER_SANITIZE_STRING));

                if($stmt->execute()) {

                    $query2 = "SELECT id,email FROM users WHERE email = :e";
                    $stmt2 = $this->conn->prepare($query2);
                    $stmt2->bindValue(':e',$_REQUEST['email']);
                    $stmt2->execute();


                    $_SESSION['jwtTokenUser'] = JWT::encode($stmt2->fetch(\PDO::FETCH_ASSOC), SECRET_KEY);
                    echo json_encode(['ok' => true]);
                    return;
                }

                echo json_encode(['ok' => false, 'error' => 'Falha ao cadastrar usuario']);
                return;
            }

            echo json_encode(['ok' => false, 'error' => 'Token Inválido!']);
            return;
        }

        public function checkEmail($data) {

            $query = "SELECT id FROM users WHERE email = :e";

            $stmt = $this->conn->prepare($query);
            $stmt->bindValue(':e', filter_var( $data['email'] ));
            $stmt->execute();

            $rows = $stmt->rowCount();

            if( $rows == 0 ) {
                
                echo json_encode(['ok' => true]);
                return;
            }

            echo json_encode(['ok' => false]);
            return;
        }   

        public function login() {
            echo $this->view->render('loginUser', [
                "title" => "Elegance - Autentificação de usuario",
            ]);
        }

        public function makeLoginUser() {

            $password = $_POST['password'];
            $email = filter_var($_POST['email'], FILTER_SANITIZE_EMAIL);

            $query = "SELECT * FROM users WHERE email = :e";
            $stmt = $this->conn->prepare($query);
            $stmt->bindValue(':e', $email);
            $stmt->execute();

            $rows = $stmt->rowCount();
         
            if($rows == 0) {
                echo json_encode(['error' => 'Email e/ou senha informados não são válidos', 'success' => false]);
                return;
            }
            
            $content = $stmt->fetch(\PDO::FETCH_ASSOC);
            $passwordHash = $content['pass']; 
   
            $passwordIsValid = password_verify($password, $passwordHash);
       
            
            if($passwordIsValid) {
                $_SESSION['jwtTokenUser'] = JWT::encode($content, SECRET_KEY);
                echo json_encode(['error' => "", 'success' => true]);
                return;
            }

            echo json_encode(['error' => 'Email e/ou senha informados não são válidos', 'success' => false]);
            return;
        }
    }