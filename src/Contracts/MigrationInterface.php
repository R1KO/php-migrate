<?php

namespace R1KO\Migrate\Contracts;

interface MigrationInterface
{
    public function up(): void;
    public function down(): void;
    public function with(...$args): MigrationInterface;
}
