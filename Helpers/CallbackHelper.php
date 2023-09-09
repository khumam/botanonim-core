<?php

namespace Helpers;

class CallbackHelper
{
    public $message;
    public $chatId;
    public $notes = null;

    public function __construct($main)
    {
        $this->message = $main->getMessage() ?? $main->getCallbackQuery();
        $this->chatId = $this->message->getFrom()->getId();
        $this->notes = $this->message->getText(true);
    }

    public function getChatId()
    {
        return $this->chatId;
    }

    public function getNotes()
    {
        return $this->notes == null ? $this->notes : trim($this->notes);
    }
}