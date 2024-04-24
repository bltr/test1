<?php

declare(strict_types=1);

namespace App\Db;

use App\Libs\Db;

class MailingLogs
{
    public function insert(string $driver, int $user_id, string $subject, string $message): void
    {
        $pdo = Db::getPdo();

        $stmt = $pdo->prepare("insert into mailing_logs (driver, user_id, subject, message) values (:driver, :user_id, :subject, :message)");
        $stmt->execute(compact('driver', 'user_id', 'subject', 'message'));
    }
}
