<?php

namespace Helpers;

use Helpers\DatabaseHelper;
use Models\ActiveChat;
use Models\Banned;
use Models\Blacklist;
use Models\Queue;
use Models\Report;

class UtilityHelper extends DatabaseHelper
{
    public static function checkBanned($chatId)
    {
        $banned = Banned::get(['user_id', '=', $chatId])->count();

        if ($banned > 0) {
            return MessageHelper::sendMessage($chatId, 'Maaf akun kamu telah di banned karena telah melanggar aturan. Segala pelanggar aturan akan ditindak tegas oleh admin!');
        }

        return true;
    }

    public static function checkBlacklist($chatId)
    {
        $blacklist = Blacklist::get(['user_id', '=', $chatId])->count();

        if ($blacklist > 0) {
            return MessageHelper::sendMessage($chatId, 'Maaf akun kamu telah di blacklist karena telah melanggar aturan. Akun yang ter-blacklist tidak bisa menggunakan bot ini lagi!');
        }

        return true;
    }

    public static function checkActiveChat($chatId)
    {
        $activeChats = ActiveChat::get(['from_id', '=', $chatId, 'OR', 'to_id', '=', $chatId])->count();

        if ($activeChats > 0) {
            return MessageHelper::sendMessage($chatId, 'Kamu masih memiliki chat yang sedang aktif. Silakan /stop terlebih dahulu untuk memulai mencari yang baru!');
        }

        return true;
    }

    public static function addQueue($chatId, $status = 'search', $gender = null)
    {
        return Queue::create([
            'user_id' => $chatId,
            'chat_id' => $chatId,
            'status' => $status,
            'gender' => $gender
        ]);
    }

    public static function addReports($reportedId, $reportedBy, $reason)
    {
        return Report::create([
            'reported_id' => $reportedId,
            'reported_by' => $reportedBy,
            'reason' => $reason,
        ]);
    }

    public static function addBanned($chatId, $reason)
    {
        return Banned::create([
            'chat_id' => $chatId,
            'user_id' => $chatId,
            'reason' => $reason,
        ]);
    }

    public static function addBlacklist($chatId, $reason)
    {
        return Blacklist::create([
            'chat_id' => $chatId,
            'user_id' => $chatId,
            'reason' => $reason,
        ]);
    }

    public static function addActiveChat($from, $to, $status = 'search')
    {
        return ActiveChat::create([
            'from_id' => $from,
            'to_id' => $to,
            'status' => $status,
        ]);
    }

    public static function deleteBanned($chatId)
    {
        return Banned::delete(['user_id', '=', $chatId]);
    }

    public static function clearReport($chatId)
    {
        return Report::delete(['user_id', '=', $chatId]);
    }
}