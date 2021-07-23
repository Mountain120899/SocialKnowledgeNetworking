<?php

namespace Src\TableGateways;

class AnswerGateway
{

    private $db = null;

    public function __construct($db)
    {
        $this->db = $db;
    }

    public function find($id)
    {       
        $statement = "
        select	*
        from	answer
        where	id	   = ?
        and     status = 1
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

    public function insert(array $input)
    {
        $statement = "
            INSERT INTO answer 
                (full_content, status, image_link, question_id, username, created_at)
            VALUES
                (:full_content, :status, :image_link, :question_id, :username, :created_at);
        ";

        try {
            $statement = $this->db->prepare($statement);
            $statement->execute(array(
                'full_content'  => $input['full_content'],
                'status'        => $input['status'],
                'image_link'    => $input['image_link'],
                'question_id'   => $input['question_id'],
                'username'      => $input['username'],
                'created_at'    => $input['created_at'],
            ));
            return $statement->rowCount();
        } catch (\PDOException $e) {
            exit($e->getMessage());
        }
    }
}
