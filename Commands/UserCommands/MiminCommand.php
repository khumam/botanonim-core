<?php

namespace Longman\TelegramBot\Commands\UserCommands;

use Helpers\MessageHelper;
use Longman\TelegramBot\Commands\UserCommand;
use Longman\TelegramBot\Entities\ServerResponse;
use Longman\TelegramBot\Request;
use Models\AdminNote;

class MiminCommand extends UserCommand
{

    protected $name = 'mimin';
    protected $description = 'Mimin command';
    protected $usage = '/mimin';
    protected $version = '1.2.0';

    public function execute(): ServerResponse
    {
        try {
            $message = $this->getMessage();
            $chatId = $message->getChat()->getId();
            $notes = trim($message->getText(true));
            $this->setAction($chatId, $notes);
            return MessageHelper::sendMessage($chatId, $this->generateMessage());
        } catch (\Exception $err) {
            return MessageHelper::sendMessage($chatId, 'Terjadi kesalahan. Silakan coba lagi nanti');
        }
    }

    private function setAction($chatId, $notes): \PDOStatement|bool
    {
        return AdminNote::create([
            'user_id' => $chatId,
            'chat_id' => $chatId,
            'notes' => $notes
        ]);
    }

    private function generateMessage(): string
    {
        return "Terima kasih sudah menghubungi Admin. Kami cek dulu ya :)";
    }
}