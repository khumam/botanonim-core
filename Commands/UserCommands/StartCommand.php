<?php

namespace Longman\TelegramBot\Commands\UserCommands;

use Helpers\MessageHelper;
use Longman\TelegramBot\Commands\UserCommand;
use Longman\TelegramBot\Entities\InlineKeyboard;
use Longman\TelegramBot\Entities\ServerResponse;
use Longman\TelegramBot\Request;

class StartCommand extends UserCommand
{

    protected $name = 'start';
    protected $description = 'Start command';
    protected $usage = '/start';
    protected $version = '1.2.0';

    public function execute(): ServerResponse
    {
        $message = $this->getMessage();
        $chatId = $message->getChat()->getId();
        $replyMarkup = $this->generateReplyMarkup();

        return MessageHelper::sendMessage($chatId, $this->generateMessage(), 'HTML', $replyMarkup);
    }

    private function generateMessage(): string
    {
        return "Hallo selamat datang di UNNES Anonim Bot!\n\nIni merupakan bot anonim untuk mahasiswa UNNES! Kamu bisa mencari teman belajar, teman main, bantuan, dan lain sebagainya di sini. Semua data yang nantinya diterima bersifat anonim, jadi tidak akan tahu siapa yang mengirim dan siapa yang menerima. Karena ini bersifat anonim, pastikan kalian TIDAK MENGIRIM DATA PRIBADI ATAU DATA PENTING LAINNYA DI SINI. Jika ada yang demikian, admin tidak bertanggung jawab atas penyalahgunaan tersebut. Gunakan dengan bijak, ya!";
    }

    private function generateReplyMarkup()
    {
        $inlineKeyboard = new InlineKeyboard([
            ['text' => '📢 Dukung Bot Anonim Unnes', 'url' => 'https://saweria.co/anoninesbot']
        ], [
            ['text' => '☎️ Hubungi Admin', 'callback_data' => 'command_mimin'],
            ['text' => '⚡️ Request Aktivasi', 'callback_data' => 'command_request']
        ], [
            ['text' => '🆔 Konfirmasi Diri', 'callback_data' => 'command_confirm'],
            ['text' => '⛔️ Peraturan Bot', 'callback_data' => 'command_rules'],
        ]);
        return $inlineKeyboard;
    }
}