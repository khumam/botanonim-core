<?php

namespace Longman\TelegramBot\Commands\UserCommands;

use Helpers\CallbackHelper;
use Helpers\MessageHelper;
use Longman\TelegramBot\Commands\UserCommand;
use Longman\TelegramBot\Entities\InlineKeyboard;
use Longman\TelegramBot\Entities\ServerResponse;
use Longman\TelegramBot\Request;
use Models\ActiveChat;
use Models\Gender;
use Models\Queue;
use Models\User;

class StopCommand extends UserCommand
{

    protected $name = 'stop';
    protected $description = 'Stop command';
    protected $usage = '/stop';
    protected $version = '1.2.0';

    public function execute(): ServerResponse
    {
        try {
            $message = new CallbackHelper($this);
            $chatId = $message->getChatId();
            $replyMarkup = $this->replyMarkup();

            if (!$this->checkActiveChat($chatId)) {
                $this->deleteQueue($chatId);
                return MessageHelper::sendMessage($chatId, 'Kamu tidak sedang dalam percakapan dan status saat ini keluar dari antrian chat.', 'HTML', $replyMarkup);
            }

            if ($this->checkNotVerified($chatId)) {
                $this->deleteQueue($chatId);
                return MessageHelper::sendMessage($chatId, 'Kamu belum terverifikasi. Klik /request jika belum pernah request sebelumnya. Tunggu ya admin akan segera kirimkan notifikasi');
            }

            $activeChat = $this->getActiveChat($chatId);
            $sendTo = $activeChat['from_id'] == $chatId ? $activeChat['to_id'] : $activeChat['from_id'];
            $this->deleteActiveChat($chatId);
            MessageHelper::sendMessage($sendTo, 'Wah sayang sekali teman bicaramu mengakhiri hubungan. Tenang, akhir dari sebuah hubungan bukan akhir dari seluruh semesta. Yuk /search lagi.', 'HTML', $replyMarkup);
            return MessageHelper::sendMessage($chatId, 'Kamu mengakhiri percakapan dengan lawan bicaramu.', 'HTML', $replyMarkup);
        } catch (\Exception $err) {
            return MessageHelper::sendMessage($chatId, 'Terjadi kesalahan. Silakan coba beberapa saat lagi.');
        }
    }

    private function checkActiveChat($chatId): bool
    {
        $activeChat = ActiveChat::first(['from_id', '=', $chatId, 'or', 'to_id', '=', $chatId]);
        return $activeChat;
    }

    private function getActiveChat($chatId): mixed
    {
        return ActiveChat::first(['from_id', '=', $chatId, 'or', 'to_id', '=', $chatId]);
    }

    private function deleteActiveChat($chatId): \PDOStatement|bool
    {
        return ActiveChat::delete(['from_id', '=', $chatId, 'or', 'to_id', '=', $chatId]);
    }

    private function deleteQueue($chatId): \PDOStatement|bool
    {
        return Queue::delete(['user_id', '=', $chatId, 'or', 'chat_id', '=', $chatId]);
    }

    private function replyMarkup()
    {
        $keyboard = new InlineKeyboard([
            ['text' => '🔍 Cari teman', 'callback_data' => 'command_search'],
            ['text' => '⛔️ Peraturan bot', 'callback_data' => 'command_rules'],
        ]);
        return $keyboard;
    }

    private function generateMessage(): string
    {
        return "Silakan konfirmasi dengan klik perintah di bawah, bahwa kamu adalah seoarang\n\n/lakilaki\natau\n/perempuan\n\nKamu bisa melewati ini, akan tetapi ada beberapa fitur bot tidak bisa digunakan jika belum melakukan konfirmasi!\n\nKamu tidak bisa merubah bagian ini!";
    }
}