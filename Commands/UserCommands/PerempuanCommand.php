<?php

namespace Longman\TelegramBot\Commands\UserCommands;

use Helpers\MessageHelper;
use Longman\TelegramBot\Commands\UserCommand;
use Longman\TelegramBot\Entities\ServerResponse;
use Longman\TelegramBot\Request;
use Models\Gender;

class PerempuanCommand extends UserCommand
{

    protected $name = 'perempuan';
    protected $description = 'Perempuan command';
    protected $usage = '/perempuan';
    protected $version = '1.2.0';

    public function execute(): ServerResponse
    {
        try {
            $message = $this->getMessage();
            $chatId = $message->getChat()->getId();
            $gender = $this->setAction($chatId);
            if (!$gender) {
                return MessageHelper::sendMessage($chatId, 'Kamu sudah melakukan konfirmasi. Perubahan tidak bisa dilakukan.');
            }
            return MessageHelper::sendMessage($chatId, $this->generateMessage());
        } catch (\Exception $err) {
            return MessageHelper::sendMessage($chatId, 'Terjadi kesalahan, silakan coba lagi nanti');
        }
    }

    private function setAction($chatId): \PDOStatement|bool
    {
        $gender = Gender::first(['user_id', '=', $chatId]);
        if (!$gender) {
            return Gender::create([
                'chat_id' => $chatId,
                'user_id' => $chatId,
                'gender' => 'w',
            ]);
        }
        return false;
    }

    private function generateMessage(): string
    {
        return "Hallo, terima kasih sudah mengkonfirmasi bahwa kamu adalah seoarang <b>perempuan</b>!\n\nSelanjutnya klik /request untuk melakukan request penggunaan bot. Hal ini dilakukan untuk menghindari penggunaan bot yang sembarangan. Tenang, admin akan segera terima request kamu, dan akan ada notifikasi jika berhasil dikonfirmasi admin. Cek secara berkala, ya!";
    }
}