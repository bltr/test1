<?php

namespace App\Libs;

use Generator;

class ChunkedIteratorAggregate implements \IteratorAggregate
{
    public function __construct(private iterable $iterable, private int $chunk_size = 500)
    {
    }

    public function getIterator(): Generator
    {
        $chunk = [];
        foreach ($this->iterable as $item) {
            $chunk[] = $item;
            if (count($chunk) === $this->chunk_size) {
                yield $chunk;
                $chunk = [];
            }
        }

        if (count($chunk) > 0) {
            yield $chunk;
        }
    }
}
