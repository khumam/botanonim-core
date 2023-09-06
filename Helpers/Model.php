<?php

namespace Helpers;
use Helpers\DatabaseHelper;

class Model
{
    public static function create($data)
    {
        $data = self::extractData($data);
        $credential = self::extractCredential($data);
        $table = self::getTable();
        $keys = $credential['keys'];
        $values = $credential['values'];
        $sql = "INSERT INTO $table $keys VALUES $values;";

        return DatabaseHelper::query($sql);
    }

    public static function update($data, $where)
    {
        $data = self::extractDataUpdate($data);
        $where = self::extractWhere($where);
        $table = self::getTable();
        $sql = "UPDATE $table SET $data WHERE $where;";

        return DatabaseHelper::query($sql);
    }

    public static function delete($where)
    {
        $where = self::extractWhere($where);
        $table = self::getTable();
        $sql = "DELETE FROM $table WHERE $where";

        return DatabaseHelper::query($sql);
    }

    public static function first($where)
    {
        $where = self::extractWhere($where);
        $table = self::getTable();
        $sql = "SELECT * FROM $table WHERE $where LIMIT 1";

        return DatabaseHelper::fetch($sql);
    }

    public static function get($where)
    {
        $where = self::extractWhere($where);
        $table = self::getTable();
        $sql = "SELECT * FROM $table WHERE $where";

        return DatabaseHelper::fetch($sql);
    }

    private static function extractData($data)
    {
        $result = [];

        foreach ($data as $idx => $val) {
            $result['key'][] = $idx;
            $result['value'][] = gettype($val) == 'string' ? "'$val'" : $val;
        }

        return $result;
    }

    private static function extractDataUpdate($data)
    {
        $result = [];

        foreach ($data as $idx => $val) {
            $result[] = $idx . '=' . ((gettype($val) == 'string') ? "'$val'" : $val);
        }

        return implode(',', $result);
    }

    private static function extractCredential($data)
    {
        $keys = '(' . implode(',', $data['key']) . ')';
        $values = '(' . implode(',', $data['value']) . ')';

        return [
            'keys' => $keys,
            'values' => $values,
        ];
    }

    private static function extractWhere($where)
    {
        return implode(' ', $where);
    }

    private static function getTable()
    {
        return get_class_vars(get_called_class())['table'] ?? '';
    }
}