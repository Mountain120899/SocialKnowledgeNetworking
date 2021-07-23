<?php

    namespace Src\TableGateways;

    class MaxIdQuestionGateway{
        private $db = null;

        public function __construct($db){
            $this->db = $db;
        }

        public function findMax(){
            $statement = "  SELECT	Max(id) + 1 as MaxId
                            FROM	Question;
                    ";

            try {
                $statement = $this->db->query($statement);
                $result = $statement->fetchAll(\PDO::FETCH_ASSOC);
                return $result;
            } catch (\PDOException $e) {
                exit($e->getMessage());
            }
        }
    }
?>