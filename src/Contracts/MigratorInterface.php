<?php

namespace R1KO\Migrate\Contracts;

interface MigratorInterface
{
    public function migrate(...$args): void;

    public function rollback(...$args): void;

    public function make(string $name): void;
}
