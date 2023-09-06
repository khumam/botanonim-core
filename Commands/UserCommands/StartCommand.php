<?php

namespace Longman\TelegramBot\Commands\UserCommands;

use Helpers\MessageHelper;
use Longman\TelegramBot\Commands\UserCommand;
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

        MessageHelper::sendMessage($chatId, $this->generateMessage());
        return MessageHelper::sendMessage($chatId, $this->generateSecondMessage());
    }

    private function generateMessage(): string
    {
        return "Hallo selamat datang di UNNES Anonim Bot!\n\nIni merupakan bot anonim untuk mahasiswa UNNES! Kamu bisa mencari teman belajar, teman main, bantuan, dan lain sebagainya di sini. Semua data yang nantinya diterima bersifat anonim, jadi tidak akan tahu siapa yang mengirim dan siapa yang menerima. Karena ini bersifat anonim, pastikan kalian TIDAK MENGIRIM DATA PRIBADI ATAU DATA PENTING LAINNYA DI SINI. Jika ada yang demikian, admin tidak bertanggung jawab atas penyalahgunaan tersebut. Gunakan dengan bijak, ya!\n\nJangan lupa, baca rules di /rules";
    }

    private function generateSecondMessage(): string
    {
        return "Silakan konfirmasi dengan klik perintah di bawah, bahwa kamu adalah seoarang\n\n/lakilaki\natau\n/perempuan\n\nKamu bisa melewati ini, akan tetapi ada beberapa fitur bot tidak bisa digunakan jika belum melakukan konfirmasi!\n\nKamu tidak bisa merubah bagian ini!";
    }
}