<?php

namespace R1KO\PhpMigrate\Contracts;

interface StorageInterface
{
    public function getList(): array;
    public function add(MigrationModelInterface $migration): void;
    public function remove(MigrationModelInterface $migration): void;
}
