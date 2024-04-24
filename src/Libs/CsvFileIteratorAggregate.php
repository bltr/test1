<?php

declare(strict_types=1);

namespace App\Libs;

use Exception;
use Generator;
use IteratorAggregate;

class CsvFileIteratorAggregate implements IteratorAggregate
{
    public function __construct(private string $fileName, private string $separator = ',')
    {
    }

    public function getIterator(): Generator
    {
        if (!file_exists($this->fileName)) {
            throw new Exception('No such file or directory');
        }
        $file = fopen($this->fileName, 'r');

        while (($attributes = fgetcsv($file, null, $this->separator)) !== false) {
            yield $attributes;
        }
    }
}
