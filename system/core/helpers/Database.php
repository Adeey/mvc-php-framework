<?php

namespace System\Core\Helpers;

use mysqli;
use System\Config\DBConfig;

class Database
{
    private ?mysqli $db;
    private ?string $modifyTable;
    private ?string $query;

    public function __construct(
        ?mysqli $db = null,
        ?string $table = null,
        ?string $query = null
    )
    {
        if (!$db) {
            $this->db = new mysqli(
                DBConfig::HOST,
                DBConfig::USER,
                DBConfig::PASSWORD,
                DBConfig::DATABASE,
                DBConfig::PORT
            );
        }

        if ($db) {
            $this->db = $db;
        }

        if ($table) {
            $this->modifyTable = $table;
        }

        if ($query) {
            $this->query = $query;
        }
    }

    public static function table(string $table)
    {
        return new self(null, $table);
    }

    public function join(string $table)
    {
        $this->query .= " JOIN `" . $table . "`";

        return new self($this->db, $this->modifyTable, $this->query);
    }

    public function on(string $oneTable, string $oneField, string $twoTable, string $twoField)
    {
        $this->query .= " ON `" . $oneTable . "`.`" . $oneField . "` = `" . $twoTable . "`.`" . $twoField . "`";

        return new self($this->db, $this->modifyTable, $this->query);
    }

    public function select($field = '*')
    {
        $this->query = "SELECT ";

        if (is_array($field)) {
            foreach ($field as $key => $item) {
                $this->query .= "`" . $item . "`";

                if ($key !== (count($field) - 1)) {
                    $this->query .= ", ";
                } else {
                    $this->query .= " ";
                }
            }
        } else {
            $this->query .= "* ";
        }

        $this->query .= " FROM `" . $this->modifyTable . "`";

        return new self($this->db, $this->modifyTable, $this->query);
    }

    public function selectRaw(string $raw = '*')
    {
        $this->query = "SELECT " . $raw . " FROM `" . $this->modifyTable . "`";

        return new self($this->db, $this->modifyTable, $this->query);
    }

    public function where($field, $sep, $value)
    {
        if (strstr($this->query, 'WHERE')) {
            $this->query .= " AND `" . $field . "` " . $sep . " '" . $this->escapeString($value) . "'";
        } else {
            $this->query .= " WHERE `" . $field . "` " . $sep . " '" . $this->escapeString($value) . "'";
        }

        return new self($this->db, $this->modifyTable, $this->query);
    }

    public function whereRaw($raw)
    {
        if (strstr($this->query, 'WHERE')) {
            $this->query .= " AND " . $raw;
        } else {
            $this->query .= " WHERE " . $raw;
        }

        return new self($this->db, $this->modifyTable, $this->query);
    }

    public function get()
    {
        return $this->getArray($this->db->query($this->query));
    }

    public function run()
    {
        return $this->db->query($this->query);
    }

    public function first()
    {
        return $this->db->query($this->query)->fetch_assoc();
    }

    public function update($params)
    {
        $this->query = "UPDATE `" . $this->modifyTable . "` ";

        foreach ($params as $key => $item) {
            if (strstr($this->query, 'SET')) {
                $this->query .= ", `" . $key . "` = '" . $this->escapeString($item) . "'";
            } else {
                $this->query .= "SET `" . $key . "` = '" . $this->escapeString($item) . "'";
            }
        }

        return new self($this->db, $this->modifyTable, $this->query);
    }

    public function insert($params)
    {
        $this->query = "INSERT INTO `" . $this->modifyTable . "` (";

        foreach (array_keys($params) as $key) {
            $this->query .= '`' . $key . '`,';
        }

        $this->query = substr_replace($this->query ,'', -1);
        $this->query .= ') VALUES (';

        foreach (array_values($params) as $value) {
            $this->query .= "'" . $this->escapeString($value) . "',";
        }

        $this->query = substr_replace($this->query ,'', -1);
        $this->query .= ')';

        return new self($this->db, $this->modifyTable, $this->query);
    }

    public function delete()
    {
        $this->query = "DELETE FROM `" . $this->modifyTable . "`";

        return new self($this->db, $this->modifyTable, $this->query);
    }

    public function getQuery()
    {
        return $this->query;
    }

    public function query($query)
    {
        return $this->db->query($query);
    }

    private function getArray($value)
    {
        $response = [];
        for ($i = 0; $i < $value->num_rows; $i++) {
            $response[] = $value->fetch_assoc();
        }
        return $response;
    }

    private function escapeString($value)
    {
        return $this->db->real_escape_string($value);
    }
}