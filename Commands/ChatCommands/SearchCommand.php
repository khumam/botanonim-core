<?php

namespace Longman\TelegramBot\Commands\UserCommands;

use Helpers\MessageHelper;
use Longman\TelegramBot\Commands\UserCommand;
use Longman\TelegramBot\Entities\ServerResponse;
use Longman\TelegramBot\Request;
use Models\ActiveChat;
use Models\Gender;
use Models\Queue;
use Models\User;

class SearchCommand extends UserCommand
{

    protected $name = 'search';
    protected $description = 'Search command';
    protected $usage = '/search';
    protected $version = '1.2.0';

    public function execute(): ServerResponse
    {
        try {
            $message = $this->getMessage();
            $chatId = $message->getChat()->getId();
            
            if ($this->checkActiveChat($chatId)) {
                return MessageHelper::sendMessage($chatId, 'Kamu masih berhubungan dengan orang lain masa mau cari yang lain lagi :( /stop dulu dong');
            }
            
            if ($this->checkNotVerified($chatId)) {
                return MessageHelper::sendMessage($chatId, 'Kamu belum terverifikasi. Klik /request jika belum pernah request sebelumnya. Tunggu ya admin akan segera kirimkan notifikasi');
            }

            $queue = $this->checkQueue($chatId);
            if (count($queue) == 0) {
                $this->setQueue($chatId);
                return MessageHelper::sendMessage($chatId, 'Tunggu sampai ada yang on ya. Kalau ada yang on nanti kami kasih notifikasi.');
            } else {
                $this->setActiveChat($queue, $chatId);
                MessageHelper::sendMessage($chatId, 'Kamu mendapatkan teman chat. Selamat berbincang');
                return MessageHelper::sendMessage($queue['user_id'], 'Kamu mendapatkan teman chat. Selamat berbincang');
            }
        } catch (\Exception $err) {
            return MessageHelper::sendMessage($chatId, 'Terjadi kesalahan. Silakan coba beberapa saat lagi.');
        }
    }

    private function checkActiveChat($chatId): bool 
    {
        $activeChat = ActiveChat::first(['from_id', '=', $chatId, 'or', 'to_id', '=', $chatId]);
        return count($activeChat) > 0;
    }

    private function checkNotVerified($chatId): bool
    {
        $user = User::first(['user_id', '=', $chatId]);
        return $user['verifed_at'] == null;
    }

    private function checkQueue($chatId): mixed
    {
        $queue = Queue::get(['user_id', '!=', $chatId, 'and', 'chat_id', '!=', $chatId, 'and', 'status', '=', 'search', 'order by rand() limit 1']);
        return $queue;
    }

    private function setQueue($chatId): bool
    {
        $gender = Gender::first(['user_id', '=', $chatId]);
        return Queue::create([
            'user_id' => $chatId,
            'chat_id' => $chatId,
            'status' => 'search',
            'gender' => $gender['gender']
        ]);
    }

    private function setActiveChat($queue, $chatId): bool
    {
        return ActiveChat::create([
            'from_id' => $chatId,
            'to_id' => $queue['chat_id'],
            'status' => 'search'
        ]);
    }

    private function generateMessage(): string
    {
        return "Silakan konfirmasi dengan klik perintah di bawah, bahwa kamu adalah seoarang\n\n/lakilaki\natau\n/perempuan\n\nKamu bisa melewati ini, akan tetapi ada beberapa fitur bot tidak bisa digunakan jika belum melakukan konfirmasi!\n\nKamu tidak bisa merubah bagian ini!";
    }
}