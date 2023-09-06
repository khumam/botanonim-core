<?php

namespace Longman\TelegramBot\Commands\UserCommands;

use Helpers\MessageHelper;
use Longman\TelegramBot\Commands\UserCommand;
use Longman\TelegramBot\Entities\ServerResponse;
use Longman\TelegramBot\Request;
use Models\ActiveChat;
use Models\Report;

class ReportCommand extends UserCommand
{

    protected $name = 'report';
    protected $description = 'Report command';
    protected $usage = '/report';
    protected $version = '1.2.0';

    public function execute(): ServerResponse
    {
        try {
            $message = $this->getMessage();
            $chatId = $message->getChat()->getId();
            $reason = trim($message->getText(true));
            $this->setAction($chatId, $reason);
            return MessageHelper::sendMessage($chatId, $this->generateMessage());
        } catch (\Exception $err) {
            return MessageHelper::sendMessage($chatId, 'Terjadi kesalahan. Silakan coba lagi nanti');
        }
    }

    private function setAction($chatId, $reason): \PDOStatement|bool
    {
        $activeChat = ActiveChat::get(['from_id', '=', $chatId, 'or', 'to_id', '=', $chatId]);
        $reportedUser = $activeChat['from_id'] == $chatId ? $activeChat['to_id'] : $activeChat['from_id'];
        return Report::create([
            'reported_id' => $reportedUser,
            'reported_by' => $chatId,
            'reason' => $reason
        ]);
    }

    private function generateMessage(): string
    {
        return "Report berhasil dilakukan dan akan segera admin proses. Terima kasih sudah membantu bot lebih baik, orang baik :).";
    }
}