<?php

namespace Longman\TelegramBot\Commands\UserCommands;

use Helpers\CallbackHelper;
use Helpers\MessageHelper;
use Longman\TelegramBot\Commands\UserCommand;
use Longman\TelegramBot\Entities\ServerResponse;
use Longman\TelegramBot\Request;
use Models\RequestJoin;

class RequestCommand extends UserCommand
{

    protected $name = 'request';
    protected $description = 'Request command';
    protected $usage = '/request';
    protected $version = '1.2.0';

    public function execute(): ServerResponse
    {
        try {
            $message = new CallbackHelper($this);
            $chatId = $message->getChatId();
            $this->setAction($chatId);
            return MessageHelper::sendMessage($chatId, $this->generateMessage());
        } catch (\Exception $err) {
            return MessageHelper::sendMessage($chatId, 'Terjadi kesalahan. Silakan coba beberapa saat lagi.');
        }
    }

    private function setAction($chatId): \PDOStatement|bool
    {
        $checkRequestStatus = RequestJoin::first(['user_id', '=', $chatId]);
        var_dump($checkRequestStatus);
        if (!$checkRequestStatus) {
            return RequestJoin::create([
                'user_id' => $chatId,
                'chat_id' => $chatId
            ]);
        }
        return true;
    }

    private function generateMessage(): string
    {
        return "Pengajuan request penggunaan bot sudah dikirimkan. Tunggu admin memvalidasi ya. Kamu akan mendapatkan notifikasi jika proses berhasil";
    }
}