<?php

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
}
