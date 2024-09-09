<?php

namespace R1KO\Migrate;

use R1KO\Migrate\Contracts\ManagerInterface;
use R1KO\Migrate\Contracts\MigrationModelInterface;
use R1KO\Migrate\Contracts\MigratorInterface;
use R1KO\Migrate\Contracts\OutputInterface;
use R1KO\Migrate\Contracts\StorageInterface;
use Throwable;

class Migrator implements MigratorInterface
{
    protected ManagerInterface $manager;
    protected StorageInterface $storage;
    protected OutputInterface $output;

    public function __construct(
        ManagerInterface $manager,
        StorageInterface $storage,
        OutputInterface $output
    )
    {
        $this->manager = $manager;
        $this->storage = $storage;
        $this->output = $output;
    }

    public function migrate(...$args): void
    {
        $migrations = $this->manager->getList();
        $executed = $this->storage->getList();
        // TODO: may be add progressbar

        foreach ($migrations as $migration) {
            if ($this->isExecuted($migration, $executed)) {
                continue;
            }

            try {
                $migration->execute(...$args);
                $this->storage->add($migration);
                $this->output->info(sprintf('[OK] %s', $migration->getName()));
            } catch (Throwable $exception) {
                $this->output->error(sprintf('[ERROR] %s', $migration->getName()));
                $this->output->error($exception->getMessage());
                $this->output->error($exception->getTraceAsString());
                $this->output->error('FAIL');
                return;
            }
        }
        $this->output->info('DONE');
    }

    public function rollback(...$args): void
    {
        $executed = $this->storage->getList();

        foreach ($executed as $migrationModel) {
            $migration = $this->manager->getExecutableByModel($migrationModel);

            try {
                $migration->rollback(...$args);
                $this->storage->remove($migration);
                $this->output->info(sprintf('[OK] %s', $migration->getName()));
            } catch (Throwable $exception) {
                $this->output->error(sprintf('[ERROR] %s', $migration->getName()));
                $this->output->error($exception->getMessage());
                $this->output->error($exception->getTraceAsString());
                $this->output->error('FAIL');
                return;
            }
        }
        $this->output->info('DONE');
    }

    private function isExecuted(MigrationModelInterface $migration, array $executed): bool
    {
        foreach ($executed as $executedMigration) {
            if ($executedMigration->getName() === $migration->getName()) {
                return true;
            }
        }

        return false;
    }

    public function make(string $name): void
    {
        try {
            $migration = $this->manager->make($name);
            $this->output->info(sprintf('[OK] %s', $migration->getName()));
        } catch (Throwable $exception) {
            $this->output->error(sprintf('[ERROR] %s', $exception->getMessage()));
            $this->output->error($exception->getTraceAsString());
        }
    }
}
