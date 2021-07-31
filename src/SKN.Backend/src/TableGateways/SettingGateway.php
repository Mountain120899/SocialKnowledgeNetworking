<?php

namespace Src\TableGateways;

class SettingGateway
{

    private $db = null;

    public function __construct($db)
    {
        $this->db = $db;
    }

    public function find($username)
    {
        $statement = "
            SELECT 
                setting_value
            FROM
                Setting
            WHERE setting_name = ?;
        ";
        
        try {
            $statement = $this->db->prepare($statement);
            $statement->execute(array($username));
            $result = $statement->fetchAll(\PDO::FETCH_ASSOC);
            return $result;
        } catch (\PDOException $e) {
            exit($e->getMessage());
        }
    }

    public function update($name,  $value)
    {
        $statement = "
            UPDATE Setting
            SET 
                setting_value = :value
            WHERE setting_name = :name;
        ";

        try {
            $statement = $this->db->prepare($statement);
            $statement->execute(array(
                'name' => $name,
                'value' => $value
            ));
            return $statement->rowCount();
        } catch (\PDOException $e) {
            exit($e->getMessage());
        }
    }

}