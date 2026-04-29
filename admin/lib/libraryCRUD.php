<?php
class CRUDLibrary {
    private $conn;

    // Constructor: Accept existing PDO connection
    public function __construct($pdo) {
        $this->conn = $pdo;
    }

    // Create a new record
    public function create($table, $data) {
        $columns = implode(", ", array_keys($data));
        $placeholders = ":" . implode(", :", array_keys($data));
        $sql = "INSERT INTO $table ($columns) VALUES ($placeholders)";
        $stmt = $this->conn->prepare($sql);
        return $stmt->execute($data);
    }

    // Read records from a table
    public function read($table, $where = "", $params = []) {
        $sql = "SELECT * FROM $table";
        if ($where) {
            $sql .= " WHERE $where";
        }
        $stmt = $this->conn->prepare($sql);
        $stmt->execute($params);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    // Read a single record
    public function readOne($table, $where, $params) {
        $sql = "SELECT * FROM $table WHERE $where LIMIT 1";
        $stmt = $this->conn->prepare($sql);
        $stmt->execute($params);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    // Update a record
    public function update($table, $data, $where, $params) {
        $setClause = implode(" = ?, ", array_keys($data)) . " = ?";
        $values = array_values($data);
        $sql = "UPDATE $table SET $setClause WHERE $where";
        $stmt = $this->conn->prepare($sql);
        return $stmt->execute(array_merge($values, $params));
    }

    // Delete a record
    public function delete($table, $where, $params) {
        $sql = "DELETE FROM $table WHERE $where";
        $stmt = $this->conn->prepare($sql);
        return $stmt->execute($params);
    }
}
?>