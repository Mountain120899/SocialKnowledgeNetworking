<?php

namespace Src\TableGateways;

class ReactQuestionGateway
{

    private $db = null;

    public function __construct($db)
    {
        $this->db = $db;
    }

    public function find($question_id)
    {       
        $statement = "
        select	*
        from	reactquestion
        where	question_id = ?
        and     is_like     = 1
        ";

        try {
            $statement = $this->db->prepare($statement);
            $statement->execute(array($question_id));
            $result = $statement->fetchAll(\PDO::FETCH_ASSOC);
            return $result;
        } catch (\PDOException $e) {
            exit($e->getMessage());
        }
    }

    public function insert(array $input)
    {
        $statement = "
            INSERT INTO reactquestion 
                (username, question_id, is_like)
            VALUES
                (:username, :question_id, :is_like);
        ";

        try {
            $statement = $this->db->prepare($statement);
            $statement->execute(array(
                'username' => $input['username'],
                'question_id' => $input['question_id'],
                'is_like' => $input['is_like']
            ));
            return $statement->rowCount();
        } catch (\PDOException $e) {
            exit($e->getMessage());
        }
    }

    public function update($id, array $input)
    {
        $statement = "
            UPDATE reactquestion
            SET 
                is_like = :is_like
            WHERE id = :id;
        ";

        try {
            $statement = $this->db->prepare($statement);
            $statement->execute(array(
                'id' => (int) $id,
                'is_like' => $input['is_like']
            ));
            return $statement->rowCount();
        } catch (\PDOException $e) {
            exit($e->getMessage());
        }
    }

    public function delete($id)
    {
        $statement = "
            DELETE FROM reactquestion
            WHERE id = :id;
        ";

        try {
            $statement = $this->db->prepare($statement);
            $statement->execute(array('id' => $id));
            return $statement->rowCount();
        } catch (\PDOException $e) {
            exit($e->getMessage());
        }    
    }
}
