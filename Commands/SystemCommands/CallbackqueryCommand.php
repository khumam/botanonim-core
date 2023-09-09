<?php

namespace Longman\TelegramBot\Commands\SystemCommands;

use Helpers\MessageHelper;
use Longman\TelegramBot\Commands\SystemCommand;
use Longman\TelegramBot\Entities\ServerResponse;

class CallbackqueryCommand extends SystemCommand
{

    protected $name = 'callbackquery';
    protected $description = 'Handle the callback query';
    protected $version = '1.2.0';

    public function execute(): ServerResponse
    {
        $callback_query = $this->getCallbackQuery();
        $callback_data = $callback_query->getData();
        $user_id = $callback_query->getFrom()->getId();

        return $this->processCallback($callback_data, $user_id);
    }

    private function processCallback($data, $chatId)
    {
        $data = explode('_', $data);
        switch ($data[0]) {
            case 'command':
                return $this->getTelegram()->executeCommand($data[1]);
        }
    }
}