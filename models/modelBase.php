<?php
function findById($pdo, $id) {
    try {
        $sql = "SELECT * FROM t_produits WHERE  = ?";

        $stmt = $pdo->prepare($sql);
        $stmt->execute([$id]);

        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    } catch (Exception $e) {
        echo "Erreur : " .$e->getMessage();
    }
}
function findBy2($pdo, $element, $table, $champ, $id) {
    try {
        $sql = "SELECT $element FROM $table WHERE $champ = ?";

        $stmt = $pdo->prepare($sql);
        $stmt->execute([$id]);

        $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
        return $result;

    } catch (PDOException $e) {
        echo "Erreur : " .$e->getMessage();
    }
}

function findAll($pdo, $table) {
    $pdo = connect();
    try {
        $sql = "SELECT * FROM $table";
        $stmt = $pdo->prepare($sql);
        $stmt->execute([]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    } catch (PDOException $e) {
            echo "Erreur : " .$e->getMessage();
    }
}

function insert($pdo, $table, $data) {
    try {
        $column = implode(',', array_keys($data));
        $value = implode(',', array_fill(0, count($data), '?'));
        $sql = "INSERT INTO $table ($column) VALUES ($value)";
        $stmt = $pdo->prepare($sql);
        
        if ($stmt->execute(array_values($data))) {
            return $stmt->rowCount();
        } else {
            return false;
        }
    } catch (PDOException $e) {
        echo "Erreur : " . $e->getMessage();
        echo "SQL : " . $sql . "\n";
        return false;
    }
}
function update($pdo, $table, $data, $where) {
    try {
        $column = implode(',', array_keys($data));
        $value = implode(',', array_fill(0, count($data), '?'));
        $sql = "UPDATE $table SET $column = $value WHERE $where";
        $stmt = $pdo->prepare($sql);
        if ($stmt->execute(array_values($data))) {
            return $stmt->rowCount();
        } else {
                return false;
        }
    } catch (PDOException $e) {
        echo "Erreur : " . $e->getMessage();
        return false;
    }
}
function delete($pdo, $table, $where) {
    try {
        $sql = "DELETE FROM $table WHERE $where";
        $stmt = $pdo->prepare($sql);
        if ($stmt->execute()) {
            return $stmt->rowCount();
            } else {
                return false;
            }
    } catch (PDOException $e) {
        echo "Erreur : " . $e->getMessage();
        return false;
    }
}


?>