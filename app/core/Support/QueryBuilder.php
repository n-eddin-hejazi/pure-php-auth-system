<?php

namespace App\Core\Support;
use \PDO;
class QueryBuilder
{
    private static $pdo;
    public static function make(PDO $pdo)
    {
        self::$pdo = $pdo;
    }

    public static function get(string $table)
    {
        $query = self:: $pdo->prepare("SELECT * FROM {$table}");
        $query->execute();
        $result = $query->fetchAll(PDO::FETCH_OBJ);

        return $result;
    }

    public static function insert($table, $data)
    {   
        $fields = array_keys($data);
        $values = array_values($data);
        $fields_as_string = implode(',', $fields);
        $secured_fields = str_repeat('?,', count($fields) - 1) . '?';

        $query = "INSERT INTO {$table} ({$fields_as_string}) VALUES ({$secured_fields})";
        $stmt = self::$pdo->prepare($query);
        $stmt->execute($values);
    }
}