<?php

namespace Longman\TelegramBot\Commands\UserCommands;

use Helpers\AdHelper;
use Helpers\CallbackHelper;
use Helpers\MessageHelper;
use Longman\TelegramBot\Commands\UserCommand;
use Longman\TelegramBot\Entities\ServerResponse;
use Longman\TelegramBot\Request;

class ConfirmCommand extends UserCommand
{

    protected $name = 'confirm';
    protected $description = 'Confirm command';
    protected $usage = '/confirm';
    protected $version = '1.2.0';

    public function execute(): ServerResponse
    {
        $message = new CallbackHelper($this);
        $chatId = $message->getChatId();
        return MessageHelper::sendMessage($chatId, $this->generateMessage());
    }

    private function generateMessage(): string
    {
        return "Silakan konfirmasi dengan klik perintah di bawah, bahwa kamu adalah seoarang\n\n/lakilaki\natau\n/perempuan\n\nKamu bisa melewati ini, akan tetapi ada beberapa fitur bot tidak bisa digunakan jika belum melakukan konfirmasi!\n\nKamu tidak bisa merubah bagian ini!";
    }
}