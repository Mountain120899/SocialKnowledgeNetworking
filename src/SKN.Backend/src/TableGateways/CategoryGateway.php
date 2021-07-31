<?php

namespace Src\TableGateways;

class CategoryGateway
{

    private $db = null;

    public function __construct($db)
    {
        $this->db = $db;
    }

    public function findAll()
    {
        $statement = "
            SELECT 
                category_name
            FROM
                Category;
        ";

        try {
            $statement = $this->db->query($statement);
            $result = $statement->fetchAll(\PDO::FETCH_ASSOC);
            return $result;
        } catch (\PDOException $e) {
            exit($e->getMessage());
        }
    }

    public function find($id)
    {
        $statement = "
        select			DISTINCT
				q.*,
        		count(a.id)	over(partition by q.id)	as AnswerCount,
                c.category_name
        from	categoryquestion cq
                inner join question q
        			on	q.id			= cq.question_id
                    and q.status        = 1
        		left join category c
                    on	c.id			= cq.category_id
                left outer join	answer a
        			on	a.question_id	= q.id
                    and	a.status		= 1
        where	cq.category_id	= ?
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
