<?php

namespace Src\TableGateways;

class QuestionGateway
{

    private $db = null;

    public function __construct($db)
    {
        $this->db = $db;
    }

    public function find($id)
    {       
        $statement = "
        select	q.*,
                a.full_content,
                a.username			as answer_username,
                a.id                as answer_id,
                a.created_at        as answer_created_at
        from	question q
                left outer join answer a
			        on	a.question_id	= q.id
                    and a.status        = 1
                where	q.id	= ?
                and		a.id is not null
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
            INSERT INTO question 
                (title, content, status, username, created_at)
            VALUES
                (:title, :content, :status, :username, :created_at);
        ";

        try {
            $statement = $this->db->prepare($statement);
            $statement->execute(array(
                'title'         => $input['title'],
                'content'       => $input['content'],
                'status'        => $input['status'],
                'username'      => $input['username'],
                'created_at'    => $input['created_at']
            ));
            return $statement->rowCount();
        } catch (\PDOException $e) {
            exit($e->getMessage());
        }
    }
}
