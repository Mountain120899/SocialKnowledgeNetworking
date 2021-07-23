<?php

namespace Src\TableGateways;

class QuestionsGateway
{

    private $db = null;

    public function __construct($db)
    {
        $this->db = $db;
    }

    public function findAll()
    {
        $statement = "
        select	q.*,
                count(a.id) as AnswerCount,
                c.category_name
        from	question q
                left outer join answer a
        	        on	a.question_id	= q.id
                    and a.status        = 1
        		left outer join categoryquestion cq
        			on	cq.question_id	= q.id
                left outer join category c
                    on	c.id			= cq.category_id
        where	q.status = 1
        Group by q.id;
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
        select	q.*,
                count(a.id) over(partition by q.id)		as AnswerCount,
                c.category_name
        from	question q
                left outer join answer a
                    on a.question_id	= q.id
                    and a.status        = 1
                left outer join categoryquestion cq
                    on	cq.question_id	= q.id
                left outer join category c
                    on	c.id			= cq.category_id
        where	q.id		= ?
        and		q.status	= 1";
        try {
            $statement = $this->db->prepare($statement);
            $statement->execute(array($id));
            $result = $statement->fetchAll(\PDO::FETCH_ASSOC);
            return $result;
        } catch (\PDOException $e) {
            exit($e->getMessage());
        }
    }

    public function findRecentQuestion(){
        $statement = "  select	q.*,
                        		count(a.id)	as AnswerCount,
                                c.category_name
                        from	question q
                                left outer join answer a
                                    on a.question_id	= q.id
                                    and a.status        = 1
                                left outer join categoryquestion cq
                                    on	cq.question_id	= q.id
                                left outer join category c
                                    on	c.id			= cq.category_id
                        where	q.status = 1
                        group by q.id
                        order by created_at DESC
                        limit	5";
        try {
            $statement = $this->db->query($statement);
            $result = $statement->fetchAll(\PDO::FETCH_ASSOC);
            return $result;
        } catch (\PDOException $e) {
            exit($e->getMessage());
        }
    }

    public function findQuestionHavingMostAnswer(){
        $statement = "
        select  q.*,
		        count(a.id)	as AnswerCount,
                c.category_name
        from	question q
		        left outer join answer a
			        on a.question_id	= q.id
                    and a.status        = 1
                left outer join categoryquestion cq
                    on	cq.question_id	= q.id
                left outer join category c
                    on	c.id			= cq.category_id
        where	q.status = 1            
        group by q.id
        order by AnswerCount DESC
        limit 5 ";
        try {
            $statement = $this->db->query($statement);
            $result = $statement->fetchAll(\PDO::FETCH_ASSOC);
            return $result;
        } catch (\PDOException $e) {
            exit($e->getMessage());
        }
    }

    public function findQuestionWithoutAnswer(){
        $statement = "
        select	q.*,
                count(a.id)	as AnswerCount,
                c.category_name
        from	question q
                left outer join answer a
                    on a.question_id	= q.id
                    and a.status        = 1
                left outer join categoryquestion cq
                    on	cq.question_id	= q.id
                left outer join category c
                    on	c.id			= cq.category_id    
        where	q.status = 1
        group by q.id
        having	count(a.id) = 0";

        try {
            $statement = $this->db->query($statement);
            $result = $statement->fetchAll(\PDO::FETCH_ASSOC);
            return $result;
        } catch (\PDOException $e) {
            exit($e->getMessage());
        }
    }
}
