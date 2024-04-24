<?php

declare(strict_types=1);

namespace App\Libs\MailingQueue;

class TelegramQueue implements MailingQueue
{
    private $file;

    public function __construct()
    {
        $this->file = fopen('../telegram.log', 'a');
    }

    public function push(string $user_name, string $subject, string $message): void
    {
        // пишием в файл для имитации отправки
        fwrite($this->file, $user_name . "\n");
    }
}
