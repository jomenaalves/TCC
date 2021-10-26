<?php

    namespace Source\App;
    use Source\App\Support\Email;

    class EmailController
    {
        private $conn;

        public function __construct()
        {
            !session_start() && session_start();

            $this->conn = new \PDO("mysql:host=localhost;dbname=elegancebd", "root", "");
            $this->conn->setAttribute(\PDO::ATTR_ERRMODE, \PDO::ERRMODE_EXCEPTION);
        }

        public function index($data) 
        {
            $_SESSION['temporaryRand'] = rand(11111,99999);

            if($this->verifyIfIsNotRegistered('jomenalves@gmail.com') !== 0) {
                echo json_encode(['error' => 'Já possui esse email cadastrado!']);
                return;
            }
            // envia email


            $sendEmail = $this->sendEmail($data['email']);
      

            echo json_encode($sendEmail);
            return;
        }

        public function verifyIfIsNotRegistered($email) 
        {
            $query = "SELECT id FROM users WHERE email = :e";
            $stmt = $this->conn->prepare($query);
            $stmt->execute([':e' => $email]);

            return $stmt->rowCount();
        }

        public function sendEmail($email)
        {
            
            $mail = new Email();
            $body = "<center>
                        <h1>Olá, esse é o seu codigo de verificação!</h1>
                        <h1>" . $_SESSION['temporaryRand']. "</h1>
                    </center>";
            $title = 'Email website Elegance - Codigo de verificação';
            $from = 'Elegance - Website';

            try {

                $response = $mail->add($title, $body, $from, $email)
                    ->send('Elegance.', 'elegance.website@hostgator.com');

                return json_encode(true);

            } catch (\Exception $e) {
                return json_encode(false);
            }
        }


        public function verifyCode($data){
            if(intval($data['code']) === intval($_SESSION['temporaryRand'])) {

                $_SESSION['token'] = $_SESSION['temporaryRand'];
                echo json_encode(['ok' => true]);
                return;
            } 

            echo json_encode(['ok' => false]);
            return;
        }

    }
