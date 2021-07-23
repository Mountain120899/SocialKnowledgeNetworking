<?php

    namespace Src\TableGateways;

    class CategoryQuestionGateway{
        private $db = null;

        public function __construct($db){
            $this->db = $db;
        }

        public function findAll(){
            $statement = "SELECT 
                             id, category_id, question_id
                         FROM
                             categoryquestion;
                    ";

            try {
                $statement = $this->db->query($statement);
                $result = $statement->fetchAll(\PDO::FETCH_ASSOC);
                return $result;
            } catch (\PDOException $e) {
                exit($e->getMessage());
            }
        }

        public function find($id){
            $statement = "SELECT 
                             id, category_id, question_id
                         FROM
                             categoryquestion
                        WHERE id = ?;
                ";

            try {
                $statement = $this->db->prepare($statement);
                $statement->execute(array($id));
                $result = $statement->fetchAll(\PDO::FETCH_ASSOC);
                return $result;
            } catch (\PDOException $e) {
                exit($e->getMessage());
            }
        }

        public function findByRequest($field, $id){
            $statement = "SELECT
                            question_id
                        FROM
                            categoryquestion
                        WHERE
                            $field = ?;
                        ";
            try{
                $statement = $this->db->prepare($statement);
                $statement->execute(array($id));
                $result = $statement->fetchAll(\PDO::FETCH_ASSOC);
                return $result;
            } catch (\PDOException $e) {
                exit($e->getMessage());
            }
        }

        public function insert(Array $input){
            $statement = "INSERT INTO categoryquestion
                        (category_id, question_id)
                    VALUES
                        (:category_id, :question_id);
                    ";
            
            try{
                $statement = $this->db->prepare($statement);
                $statement->execute(array(
                    "category_id"=>$input['category_id'],
                    "question_id"=>$input['question_id']
                   
                ));
                return $statement->rowCount();
            }catch(\PDOException $e){
                exit($e->getMessage());
            }
        }

        public function update($id, Array $input){
            $statement = "UPDATE categoryquestion
                    SET
                        category_id = :category_id, 
                        question_id = :question_id
                    WHERE
                        id = :id;
                    ";

            try{
                $statement = $this->db->prepare($statement);
                $statement->execute(array(
                    'id' => (int) $id,
                    "category_id"=>$input['category_id'],
                    "question_id"=>$input['question_id']
                ));
                return $statement->rowCount();
            }catch(\PDOException $e){
                exit($e->getMessage());
            }
        }

        public function delete($id){
            $statement = "DELETE 
                    FROM categoryquestion
                    WHERE
                        id = :id;
                    ";
            
            try{
                $statement = $this->db->prepare($statement);
                $statement->execute(array("id"=>$id));
                return $statement->rowCount();
            }catch(\PDOException $e){
                exit($e->getMessage());
            }
        }
    }