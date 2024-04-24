<?php

declare(strict_types=1);

namespace App\Controllers;

use App\Libs\ChunkedIteratorAggregate;
use App\Libs\CsvFileIteratorAggregate;
use App\Db\Users;
use App\Exceptions\ValidationException;

class ImportController
{
    private Users $users;

    public function __construct()
    {
        $this->users = new Users();
    }

    public function import(array $file): array
    {
        if (empty($file['data'])) {
            throw new ValidationException('File is required');
        }

        $iterator = new CsvFileIteratorAggregate($file['data']['tmp_name']);
        $chunked_iterator = new ChunkedIteratorAggregate($iterator);

        foreach ($chunked_iterator as $chunk) {
            $data = array_map(
                fn ($entry) => array_filter(array_map(fn ($field) => trim($field), $entry)),
                $chunk
            );

            $this->users->bulkInsert($data);
        }

        return ['success' => true];
    }
}
