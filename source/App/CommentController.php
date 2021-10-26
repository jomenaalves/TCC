<?php 
   
    namespace Source\App;

    class CommentController
    {
        public function __construct()
        {
            
            !session_start() && session_start();    
            $this->conn = new \PDO("mysql:host=localhost;dbname=elegancebd", "root", "");
            $this->conn->setAttribute(\PDO::ATTR_ERRMODE, \PDO::ERRMODE_EXCEPTION);
        }

        # Controller for the route "/api/removeQuestion"
        public function delete(Array $data):void
        {
            $id = filter_var($data['id'], FILTER_SANITIZE_NUMBER_INT);

            $query = "DELETE FROM comments WHERE id_column = :id";
            $stmt = $this->conn->prepare($query);
            $stmt->bindValue(':id', $id);
            if($stmt->execute()) {
                echo json_encode(['success' => true]);
                return;
            }

            echo json_encode(['success' => false]);
            return;
        }

        # Controller for the route "/api/makeAnswer"
        public function makeAnswer(Array $data):void
        {   
            $id = filter_var($_POST['id'], FILTER_SANITIZE_NUMBER_INT);
            $answer = filter_var($_POST['answer'], FILTER_SANITIZE_STRING);


            $query = "UPDATE comments SET answer = :answer WHERE id_column = :id"; 
            $stmt = $this->conn->prepare($query);
            $stmt->bindValue(':id', $id);
            $stmt->bindValue(':answer', $answer);
            if($stmt->execute()) {
                echo json_encode(['success' => true, 'id' => $id, 'answer' => $answer, 'stmt' => $stmt->execute()]);
                return;
            }

            echo json_encode(['success' => false]);
            return;
        }

        # Controller from the route "/api/updateAnswer"
        public function updateAnswer(Array $data):void
        {

            $id = filter_var($_POST['id'], FILTER_SANITIZE_NUMBER_INT);
            $answer = filter_var($_POST['answer'], FILTER_SANITIZE_STRING);

            if($answer !== "" || $answer !== " "){

                $query = "UPDATE comments SET answer = :answer WHERE id_column = :id"; 
                $stmt = $this->conn->prepare($query);
                $stmt->bindValue(':id', $id);
                $stmt->bindValue(':answer', $answer);
                if($stmt->execute()) {
                    echo json_encode(['success' => true, 'id' => $id, 'answer' => $answer, 'stmt' => $stmt->execute()]);
                    return;
                }else{
                    echo json_encode(['success' => false]);
                    return;    
                }
    
                return;
            }

            echo json_encode(['success' => false]);
            return;

        }

       
    }