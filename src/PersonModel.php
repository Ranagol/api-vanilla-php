<?php

namespace Src;

use PDO;

/**
 * All db related stuff happens here.
 */
class PersonModel {

    private $db = null;

    public function __construct($db)
    {
        $this->db = $db;
    }

    /**
     * Example: http://localhost:8889/person
     *
     * @return void
     */
    public function findAll()
    {
        $statement = "
            SELECT 
                *
            FROM
                person;
        ";

        try {
            $statement = $this->db->query($statement);
            $result = $statement->fetchAll(PDO::FETCH_ASSOC);
            return $result;
        } catch (PDOException $e) {
            exit($e->getMessage());
        }
    }

    /**
     * Example: http://localhost:8889/person/1
     *
     * @param [type] $id
     * @return void
     */
    public function find($id)
    {
        $statement = "
            SELECT 
                *
            FROM
                person
            WHERE id = ?;
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

    /**
     * Example for the request from Postman
     * 
     * {
     * "firstname": "gdrga",
     * "lastname": "agreag"
     * }
     * Note: when making PUT and POST requests, make sure to set the Body type to raw, 
     * then paste the payload in JSON format and set the content type to JSON (application/json).
     * Explanation for (:firstname, :lastname); line:
     * we use here prepared statements. Source: https://www.w3schools.com/php/php_mysql_prepared_statements.asp
     * Basically we prepare a statement, but without values. The values will be added later,
     * during the statement execution.
     * 
     *
     * @param Array $input
     * @return void
     */
    public function insert(Array $input)
    {
        $statement = "
            INSERT INTO person 
                (firstname, lastname)
            VALUES
                (:firstname, :lastname);
        ";

        try {
            $statement = $this->db->prepare($statement);
            $statement->execute([
                'firstname' => $input['firstname'],
                'lastname'  => $input['lastname'],
            ]);
            return $statement->rowCount();
        } catch (\PDOException $e) {
            exit($e->getMessage());
        }    
    }

    public function update($id, Array $input)
    {
        $statement = "
            UPDATE person
            SET 
                firstname = :firstname,
                lastname  = :lastname,
            WHERE id = :id;
        ";

        try {
            $statement = $this->db->prepare($statement);
            $statement->execute(array(
                'id' => (int) $id,
                'firstname' => $input['firstname'],
                'lastname'  => $input['lastname'],
            ));
            return $statement->rowCount();
        } catch (\PDOException $e) {
            exit($e->getMessage());
        }    
    }

    /**
     * http://localhost:8889/person/1, but with DELETE request
     *
     * @param [type] $id
     * @return void
     */
    public function delete($id)
    {
        $statement = "
            DELETE FROM person
            WHERE id = :id;
        ";

        try {
            $statement = $this->db->prepare($statement);
            $statement->execute(['id' => $id]);
            return $statement->rowCount();
        } catch (\PDOException $e) {
            exit($e->getMessage());
        }    
    }
}