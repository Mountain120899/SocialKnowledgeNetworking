<?php

namespace Src\TableGateways;

class QuestionLikeGateway
{

    private $db = null;

    public function __construct($db)
    {
        $this->db = $db;
    }

    public function find($id)
    {
        $statement = "
            select	question_id,
		            count(1)	as like_number
            from	reactquestion
            where	question_id = ?
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


}
