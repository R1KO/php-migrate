<?php

namespace R1KO\PhpMigrate\Contracts;

interface OutputInterface
{
    public function info(string $message);
    public function error(string $message);
}
