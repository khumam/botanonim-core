<?php

namespace Longman\TelegramBot\Commands\UserCommands;

use Helpers\CallbackHelper;
use Helpers\MessageHelper;
use Longman\TelegramBot\Commands\UserCommand;
use Longman\TelegramBot\Entities\InlineKeyboard;
use Longman\TelegramBot\Entities\ServerResponse;
use Longman\TelegramBot\Request;

class RulesCommand extends UserCommand
{

    protected $name = 'rules';
    protected $description = 'Rules command';
    protected $usage = '/rules';
    protected $version = '1.2.0';

    public function execute(): ServerResponse
    {
        $message = new CallbackHelper($this);
        $chatId = $message->getChatId();

        $replyMarkup = $this->generateReplyMarkup();

        return MessageHelper::sendMessage($chatId, $this->generateMessage(), 'HTML', $replyMarkup);
    }

    private function generateMessage(): string
    {
        return "Rules dan Peraturan Bot\n\n1. Tidak boleh SARA dalam bentuk apapun\n2. Tidak boleh pornografi dalam bentuk apapun\n3. Tidak boleh mengarah ke pelecehan dalam bentuk apapun\n4. Tidak boleh mengirimkan data pribadi dalam bentuk apapun\n5. Tidak boleh promosi atau jualan dalam bentuk apapun\n6. Sejatinya bot dibuat untuk saling ngobrol, dan mencari teman\n7. Selalu berhati-hati dalam menggunakan\n8. Admin tidak bertanggung jawab jika terjadi sesuatu yang tidak mengenakan, akan tetapi akan berusaha membantu jika ada hal yang bertentangan dengan normal sosial yang berlaku.";
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