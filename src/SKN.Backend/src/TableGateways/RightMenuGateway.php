<?php

namespace Src\TableGateways;

class RightMenuGateway
{

    private $db = null;

    public function __construct($db)
    {
        $this->db = $db;
    }

    public function findInfor()
    {
        
            $statement = "
            Select	Max(questions)	as questions,
		            Max(answers)	as answers,
                    Max(users)		as users
            from	(
	        		select	count(1)	as questions,
	        				0			as answers,
	        				0			as users
	        		from	question
                    where   status  = 1
	        		UNION
	        		select	0			as questions,
	        				count(1)	as answers,
	        				0			as users
	        		from	answer
                    where   status  = 1
	        		UNION
	        		select	0			as questions,
	        				0			as answers,
	        				count(1)	as users
	        		from	user
	        	    ) T
        ";
        
        try {
            $statement = $this->db->query($statement);
            $result = $statement->fetchAll(\PDO::FETCH_ASSOC);
            return $result;
        } catch (\PDOException $e) {
            exit($e->getMessage());
        }
    }
    
    public function findUser()
    {
        $statement = "
        select	username,
        		sum(question_point) + sum(answer_point) as final_point
        from	(
        			select	username,
        					count(id) * 5			as question_point,
        					0						as answer_point
        			from	question
                    where	status = 1
        			group by username
        			union
        			select	username,
        					0			as question_point,
        					count(id)	as answer_point
        			from	answer
        			where	status = 1
        			group by username
        		) T
        group by username
        order by 2 desc
        limit 5
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
