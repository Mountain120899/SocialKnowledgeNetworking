<?php

namespace Src\TableGateways;

class GetUserInfomationGateway
{

    private $db = null;

    public function __construct($db)
    {
        $this->db = $db;
    }

    public function GetUsername($userid)
    {
        $statement = "
            SELECT 
                username
            FROM
                user
            WHERE id = ?
        ";
        try {
            $statement = $this->db->prepare($statement);
            $statement->execute(array($userid));
            $result = $statement->fetchAll(\PDO::FETCH_ASSOC);
            return $result;
        } catch (\PDOException $e) {
            exit($e->getMessage());
        }
    }


    public function GetUserQuestion($username)
    {
        $statement = "
            SELECT 
                *
            FROM
                question
            WHERE username = :username
            and status = 1;
        ";

        try {
            $convert = strval($username);
            $statement = $this->db->prepare($statement);
            $statement->execute(array('username' => $convert));
            $result = $statement->fetchAll(\PDO::FETCH_ASSOC);
            return $result;
        } catch (\PDOException $e) {
            exit($e->getMessage());
        }
    }

    public function GetUserAnswer($username)
    {
        $statement = "
            SELECT 
                *
            FROM
                answer
            WHERE username = :username
            and status = 1;
        ";

        try {
            $convert = strval($username);
            $statement = $this->db->prepare($statement);
            $statement->execute(array('username' => $convert));
            $result = $statement->fetchAll(\PDO::FETCH_ASSOC);
            return $result;
        } catch (\PDOException $e) {
            exit($e->getMessage());
        }
    }
    public function GetUserPoint($username)
    {
        $statement = "
            select	sum(question_point) + sum(answer_point) as final_point
            from	(
                        select	username,
                                count(id) * 5			as question_point,
                                0						as answer_point
                        from	question
                        where	status = 1 and username = :username
                        group by username
                        union
                        select	username,
                                0			as question_point,
                                count(id)	as answer_point
                        from	answer
                        where	status = 1 and username = :username
                        group by username
                    ) T
            ";

        try {
            $convert = strval($username);
            $statement = $this->db->prepare($statement);
            $statement->execute(array('username' => $convert));
            $result = $statement->fetchAll(\PDO::FETCH_ASSOC);
         
            return intval($result[0]['final_point']);
        } catch (\PDOException $e) {
            exit($e->getMessage());
        }
    }
}
