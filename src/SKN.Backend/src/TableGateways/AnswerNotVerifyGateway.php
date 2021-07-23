<?php

namespace Src\TableGateways;

class AnswerNotVerifyGateway
{

    private $db = null;

    public function __construct($db)
    {
        $this->db = $db;
    }
    
    
    public function find($id)
    {       
        $statement = "
        select	q.*
        from	answer q
        where q.status = 0
        LIMIT 5 OFFSET :offset
        ";
        try {
            $offset = intval(($id-1)*5,10);
            $statement = $this->db->prepare($statement);
            $statement->bindParam(':offset', $offset,\PDO::PARAM_INT);
            $statement->execute();
            $result = $statement->fetchAll(\PDO::FETCH_ASSOC);
            return $result;
        } catch (\PDOException $e) {
            exit($e->getMessage());
        }
    }
}
