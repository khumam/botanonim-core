<?php

namespace Helpers;

use Exception;
use Longman\TelegramBot\DB;
use PDO;

class DatabaseHelper
{
    protected const BANNEDS_TABLE = 'banneds';
    protected const ACTIVE_CHATS_TABLE = 'active_chats';
    protected const REPORTS_TABLE = 'reports';
    protected const QUEUES_TABLE = 'queues';
    protected const BLACKLISTS_TABLE = 'blacklists';
    protected const GENDERS_TABLE = 'genders';

    protected static function getPdo()
    {
        $pdo = DB::getPdo();
        return $pdo;
    }

    public static function fetch($sql)
    {
        try {
            $pdo = self::getPdo();
            $db = $pdo->prepare($sql);
            $db->execute();
            $result = $db->fetch(PDO::FETCH_ASSOC);

            return $result;
        } catch (Exception $e) {
            echo $e->getMessage();
        }
    }

    public static function count($sql)
    {
        try {
            $pdo = self::getPdo();
            $db = $pdo->prepare($sql);
            $db->execute();
            $result = $db->fetch(PDO::FETCH_ASSOC);

            return count($result);
        } catch (Exception $e) {
            echo $e->getMessage();
        }
    }

    public static function query($sql)
    {
        try {
            $pdo = self::getPdo();
            $query = $pdo->query($sql);

            return $query;
        } catch (Exception $e) {
            echo $e->getMessage();
        }
    }
}