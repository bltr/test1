<?php

declare(strict_types=1);

namespace App\Libs\MailingQueue;

interface MailingQueue
{
    public function push(string $user_name, string $subject, string $message): void;
}
