<?php

class DataBase
{
    private $conn;
    private $db_name = 'wfs205';
    private $host = "localhost";
    private $user = "root";
    private $password = '';
    public function Connect()
    {

        try {
            $this->conn = new PDO("mysql:host=$this->host;dbname=$this->db_name", $this->user, $this->password);
            $this->conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        } catch (PDOException $e) {
            echo "Connection failed: " . $e->getMessage();
            exit();
        }
        $this->conn->query("SET NAMES 'utf8'");
        return true;
    }
    public function Select(string $table, string $columns = "*", string $where = "")
    {
        $sql = "SELECT $columns FROM $table WHERE $where";

        if (empty($where)) {
            $sql = "SELECT $columns FROM $table ";
        }
        try {
            $this->conn->beginTransaction();
            $result = $this->conn->query($sql);
            $result->setFetchMode(PDO::FETCH_OBJ);
            if (empty($result)) {
                throw new Exception("Error Request Result Empty", 1);
            }
            $this->conn->commit();
        } catch (Exception $e) {
            $this->conn->rollback();
            throw new Exception(pprint($e->getMessage()) . "Error Request Result Empty", 2);
        }
        return $result->fetchAll(PDO::FETCH_OBJ);
    }
    public function Update(string $table, string $column, string $where): bool
    {
        $sql = "UPDATE $table SET $column WHERE $where";
        try {
            $this->conn->beginTransaction();
            $this->conn->query($sql);
            $this->conn->commit();
        } catch (Exception $e) {
            $this->conn->rollback();
            throw new Exception(pprint($e->getMessage()) . "Error Request Result Empty", 2);
        }
        return true;
    }
    public function Insert(string $table, array $column, array $values = [""])
    {
        $cols = implode(",", $column);
        $vals = "'" . implode("','", $values) . "'";
        $sql = "INSERT INTO $table ($cols)  VALUES ($vals)";
        try {
            $this->conn->beginTransaction();
            $this->conn->query($sql);
            $this->conn->commit();
        } catch (Exception $e) {
            $this->conn->rollback();
            throw new Exception(pprint($e->getMessage()) . "Error Request Result Empty", 2);
        }
        return true;
    }
    public function Delete(string $table, string $where)
    {
        $sql = "DELETE FROM $table WHERE $where";
        try {
            $this->conn->beginTransaction();
            $this->conn->query($sql);
            $this->conn->commit();
        } catch (Exception $e) {
            $this->conn->rollback();
            throw new Exception(pprint($e->getMessage()) . "Error Request Result Empty", 2);
        }
        return true;
    }

    public function Query(string $query)
    {
        try {
            $this->conn->beginTransaction();
            $result = $this->conn->query($query);
            $result->setFetchMode(PDO::FETCH_OBJ);
            if (empty($result)) {
                throw new Exception("Error Request Result Empty", 1);
            }
            $this->conn->commit();
        } catch (Exception $e) {
            $this->conn->rollback();
            throw new Exception(pprint($e->getMessage()) . "Error Request Result Empty", 2);
        }
        return $result->fetchAll(PDO::FETCH_OBJ);
    }
}

$db = new DataBase();
$db->Connect();


function pprint($data)
{
    echo '<pre>';
    print_r($data);
    echo '</pre>';
}
function Validate($data)
{
    $data = trim($data);
    $data = stripslashes($data);
    $data = htmlspecialchars($data);
    return $data;
}