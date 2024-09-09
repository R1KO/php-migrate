<?php

namespace R1KO\Migrate\Contracts;

interface MigrationExecutableInterface extends MigrationModelInterface
{
    public function execute(...$args): void;
    public function rollback(...$args): void;
}
