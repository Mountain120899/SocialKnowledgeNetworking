<?php

namespace Src\TableGateways;

class VerifyGateway
{

    private $db = null;

    public function __construct($db)
    {
        $this->db = $db;
    }
    

    public function VerifyQuestion($input)
    {
        $statement = "
        UPDATE question 
        SET status = :status 
        WHERE id = :id
        ";
        try {
            $statement = $this->db->prepare($statement);
            $statement->execute(array(
                'id' => $input['id'],
                'status' => $input['status']
            ));
            return $statement->rowCount();
        } catch (\PDOException $e) {
            return $e->getMessage();
        }
    }

    public function VerifyAnswer($input)
    {
        $statement = "
        UPDATE answer 
        SET status=:status 
        WHERE id=:id
        ";
        try {
            $statement = $this->db->prepare($statement);
            $statement->execute(array(
                'id' => $input['id'],
                'status' => $input['status']
            ));
            return $statement->rowCount();
        } catch (\PDOException $e) {
            exit($e->getMessage());
        }
    }

    public function find($id)
    {       
        $statement = "
        select	q.*
        from	question q
        where q.status = 1
        LIMIT 5 OFFSET :offset
        ";
        try {
            $offset = ($id-1)*5;
            $statement = $this->db->prepare($statement);
            $statement->bindParam(':offset', intval($offset, 10),\PDO::PARAM_INT);
            $statement->execute();
            $result = $statement->fetchAll(\PDO::FETCH_ASSOC);
            return $result;
        } catch (\PDOException $e) {
            exit($e->getMessage());
        }
    }
}
