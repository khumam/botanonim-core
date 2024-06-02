<?php

namespace Helpers;

use Longman\TelegramBot\Entities\InlineKeyboard;
use Longman\TelegramBot\Request;
use Models\Ads;

class AdHelper
{
    public $replyMarkup = null;
    public $image = null;
    public $content = '';
    public $chatId;
    public $ads;
    public $mainLink = 'https://unnes.botanonim.com/storage/media/';

    public function __construct($chatId)
    {
        $this->chatId = $chatId;
        $this->getActiveAd();
    }

    protected function getActiveAd()
    {
        $now = "'" . date('Y-m-d') . "'";
        $this->ads = Ads::first(['DATE(start_at)', '<=', $now, 'and', 'DATE(end_at)', '>=', $now]);
        if ($this->ads) {
            $this->image = $this->mainLink . $this->ads['image'];
            $this->content = $this->ads['content'];
            $this->replyMarkup = $this->processReplyMarkup($this->ads['metadata']);
        }
    }

    protected function processReplyMarkup($replyMarkup)
    {
        $replyMarkup = json_decode($replyMarkup);
        $keyboard = [];
        foreach ($replyMarkup as $items) {
            $keyboardData = [];
            foreach ($items as $key => $value) {
                $keyboardData[$key] = $value;
            }
            array_push($keyboard, $keyboardData);
        }
        return new InlineKeyboard($keyboard);
    }

    public function send()
    {
        if ($this->ads) {
            if ($this->image !== null) {
                MessageHelper::sendPhoto($this->chatId, $this->image);
            }

            // Add views data
            $dataUpdate = [
                'views' => $this->ads['views'] + 1,
            ];
            Ads::update($dataUpdate, ['id', '=', $this->ads['id']]);

            return MessageHelper::sendAd($this->chatId, $this->content, 'HTML', $this->replyMarkup);
        }
        return MessageHelper::sendEmptyResponse();
    }


}