<?php

namespace R1KO\PhpMigrate\Contracts;

interface ManagerInterface
{
    /**
     * @return MigrationExecutableInterface[]
     */
    public function getList(): array;
    public function make(string $name): MigrationModelInterface;
    public function getExecutableByModel(MigrationModelInterface $migration): MigrationExecutableInterface;
}
