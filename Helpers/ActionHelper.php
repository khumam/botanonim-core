<?php

namespace Helpers;

use Longman\TelegramBot\Request;

class ActionHelper
{
    public static function sendAction($chatId, string $action)
    {
        return Request::sendChatAction([
            'chat_id' => $chatId,
            'action' => $action,
        ]);
    }

    public static function sendTyping($chatId)
    {
        return Request::sendChatAction([
            'chat_id' => $chatId,
            'action' => 'typing',
        ]);
    }
}