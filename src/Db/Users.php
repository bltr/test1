<?php

declare(strict_types=1);

namespace App\Db;

use App\Libs\Db;

class Users
{
    public function bulkInsert(array $data): void
    {
        $pdo = Db::getPdo();

        $placehoders = implode(
            ', ',
            array_pad(
                [],
                count($data),
                '(' .implode(', ', array_pad([], count(reset($data)), '?')) . ')'
            )
        );

        $stmt = $pdo->prepare("insert into users (outer_id, name) values $placehoders");
        $stmt->execute(array_merge(...$data));
    }

    public function getNotMailed(string $driver, string $subject): \Generator
    {
        $pdo = Db::getPdo();

        $stmt = $pdo->prepare(
            <<<SQL
                select u.id, u.name
                from users u
                    left join mailing_logs ml on u.id = ml.user_id and driver = :driver and subject = :subject 
                where ml.id is null
            SQL
        );

        $stmt->execute(compact('driver', 'subject'));

        while ($row = $stmt->fetch(\PDO::FETCH_ASSOC)) {
            yield $row;
        }
    }
}
