<?php

declare(strict_types=1);

namespace App\Controllers;

use App\Db\MailingLogs;
use App\Db\Users;
use App\Exceptions\ValidationException;
use App\Libs\MailingQueue\DriverType;
use App\Libs\MailingQueue\EmailQueue;
use App\Libs\MailingQueue\MailingQueue;
use App\Libs\MailingQueue\TelegramQueue;

class MailingController
{
    private Users $users;
    private MailingLogs $mailing_logs;

    public function __construct()
    {
        $this->users = new Users();
        $this->mailing_logs = new MailingLogs();
    }

    public function send(array $data): array
    {
        $this->validate($data);

        ['driver' => $driver, 'subject' => $subject, 'message' => $message] = $data;

        $users = $this->users->getNotMailed($driver, $subject);

        $mailing_queue = $this->getMailingQueue($driver);

        // $time = time();
        foreach ($users as $user) {
            $mailing_queue->push($user['name'], $subject, $message);
            $this->mailing_logs->insert($driver, $user['id'], $subject, $message);

            // для имитации неожиданного прерывания через 1 сек
            //if (time() - $time > 1) die;
        }

        return ['success' => true];
    }

    public function getMailingQueue(string $driver): MailingQueue
    {
        return match ($driver) {
            DriverType::EMAIL->value => new EmailQueue(),
            DriverType::TELEGRAM->value => new TelegramQueue(),
        };
    }

    public function validate(array $data)
    {
        if (empty($data['driver'])) {
            throw new ValidationException('Driver is required');
        }

        if (empty($data['subject'])) {
            throw new ValidationException('Subject is required');
        }

        if (empty($data['message'])) {
            throw new ValidationException('Message is required');
        }

        if (!in_array($data['driver'], DriverType::values())) {
            throw new ValidationException('Driver is not valid');
        }
    }
}
