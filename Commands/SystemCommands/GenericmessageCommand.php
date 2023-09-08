<?php

namespace Longman\TelegramBot\Commands\SystemCommands;

use Helpers\MessageHelper;
use Longman\TelegramBot\Commands\SystemCommand;
use Longman\TelegramBot\Entities\ServerResponse;
use Longman\TelegramBot\Exception\TelegramException;
use Longman\TelegramBot\Request;
use Longman\TelegramBot\Telegram;
use Models\ActiveChat;

class GenericmessageCommand extends SystemCommand
{
    protected $name = Telegram::GENERIC_MESSAGE_COMMAND;
    protected $description = 'Handle generic message';
    protected $version = '1.2.0';
    protected $need_mysql = true;

    public function executeNoDb(): ServerResponse
    {
        if (self::$execute_deprecated && $deprecated_system_command_response = $this->executeDeprecatedSystemCommand()) {
            return $deprecated_system_command_response;
        }

        return Request::emptyResponse();
    }

    public function execute(): ServerResponse
    {
        $message = $this->getMessage();
        if ($active_conversation_response = $this->executeActiveConversation()) {
            return $active_conversation_response;
        }

        if (self::$execute_deprecated && $deprecated_system_command_response = $this->executeDeprecatedSystemCommand()) {
            return $deprecated_system_command_response;
        } else {
            return $this->processMessage($message);
        }
    }

    private function processMessage($message): ServerResponse
    { 
        $chatId = $message->getChat()->getId();
        $activeChat = ActiveChat::first(['from_id', '=', $chatId, 'or', 'to_id', '=', $chatId]);
        if (!$activeChat) {
            return MessageHelper::sendMessageAsUser($chatId, 'Kamu tidak sedang dalam percakapan. Gunakan /search untuk memulai mencari teman pasangan chat. Good luck!');
        }

        $sendTo = $activeChat['from_id'] == $chatId ? $activeChat['to_id'] : $activeChat['from_id'];
        return MessageHelper::sendMessageAsUser($sendTo, $message->getText());
    }
}