<?php

declare(strict_types=1);

use Tracy\Dumper;

function dd(mixed $data): never
{
    d($data);
    die;
}

function d(mixed $data): void
{
    Dumper::dump($data, [
        'depth' => 2,
    ]);
}
