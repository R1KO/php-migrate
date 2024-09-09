<?php

namespace R1KO\Migrate\Contracts;

interface OutputInterface
{
    public function info(string $message);
    public function error(string $message);
}
