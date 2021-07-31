<?php

namespace Src\TableGateways;

class UserGateway
{

    private $db = null;

    public function __construct($db)
    {
        $this->db = $db;
    }

    public function loginUserGW(array $input)
    {
        $statement = "
            SELECT 
                *
            FROM
                User
            WHERE
                username = :username AND password = :password;
        ";

        try {
            $statement = $this->db->prepare($statement);
            $statement->execute(array(
                'username' => $input['username'],
                'password' => sha1($input['password'])
            ));
            return $statement->rowCount();
        } catch (\PDOException $e) {
            exit($e->getMessage());
        }
    }

    public function find($username)
    {
        $statement = "
            SELECT 
                *
            FROM
                User
            WHERE username = ?;
        ";
        
        try {
            $statement = $this->db->prepare($statement);
            $statement->execute(array($username));
            $result = $statement->fetchAll(\PDO::FETCH_ASSOC);
            return $result[0];
        } catch (\PDOException $e) {
            exit($e->getMessage());
        }
    }

    public function insert(array $input)
    {
        $statement = "
            INSERT INTO User 
                (username, password, full_name, email, yearofbirth)
            VALUES
                (:username, :password, :full_name, :email, :yearofbirth);
        ";

        try {
            $statement = $this->db->prepare($statement);
            $statement->execute(array(
                'username' => $input['username'],
                'password' => sha1($input['password']),
                'full_name' => $input['full_name'],
                'email' => $input['email'],
                'yearofbirth' => $input['yearofbirth']
            ));
            return $statement->rowCount();
        } catch (\PDOException $e) {
            exit($e->getMessage());
        }
    }

    public function update($id, array $input)
    {
        $statement = "
            UPDATE User
            SET 
                username = :username,
                password = :password,
                full_name = :full_name,
                email = :email,
                yearofbirth = :yearofbirth
            WHERE id = :id;
        ";

        try {
            $statement = $this->db->prepare($statement);
            $statement->execute(array(
                'id' => (int) $id,
                'username' => $input['username'],
                'password' => sha1($input['password']),
                'full_name' => $input['full_name'],
                'email' => $input['email'],
                'yearofbirth' => $input['yearofbirth']
            ));
            return $statement->rowCount();
        } catch (\PDOException $e) {
            exit($e->getMessage());
        }
    }

}
