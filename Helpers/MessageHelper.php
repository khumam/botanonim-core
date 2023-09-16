<?php

namespace Helpers;

use Longman\TelegramBot\Entities\ServerResponse;
use Longman\TelegramBot\Request;

class MessageHelper
{
    public static function sendMessage($chatId, $message, $parseMode = 'HTML', $replyMarkup = null): ServerResponse
    {
        ActionHelper::sendTyping($chatId);
        $data = [
            'chat_id' => $chatId,
            'parse_mode' => $parseMode,
            'text' => '🤖 ' . $message,
            'reply_markup' => $replyMarkup
        ];

        return Request::sendMessage($data);
    }

    public static function sendMessageAsUser($chatId, $message, $parseMode = 'HTML'): ServerResponse
    {
        ActionHelper::sendTyping($chatId);
        $data = [
            'chat_id' => $chatId,
            'parse_mode' => $parseMode,
            'text' => $message,
        ];

        return Request::sendMessage($data);
    }

    public static function sendPhoto($chatId, $url): ServerResponse
    {
        ActionHelper::sendTyping($chatId);
        $data = [
            'chat_id' => $chatId,
            'photo' => $url
        ];
        return Request::sendPhoto($data);
    }

    public static function sendEmptyResponse(): ServerResponse
    {
        return Request::emptyResponse();
    }

    public static function sendAd($chatId, $message, $parseMode = 'HTML', $replyMarkup = null): ServerResponse
    {
        ActionHelper::sendTyping($chatId);
        $data = [
            'chat_id' => $chatId,
            'parse_mode' => $parseMode,
            'text' => '📢 ' . $message,
            'reply_markup' => $replyMarkup
        ];

        return Request::sendMessage($data);
    }
}