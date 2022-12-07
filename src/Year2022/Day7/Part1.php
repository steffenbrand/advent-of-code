<?php

declare(strict_types=1);

namespace AoC\Year2022\Day7;

class Part1
{
    private string $currentDirectory = '';
    private array $fileSystem = self::FS_EMPTY_DIRECTORY_TEMPLATE;
    private int $sum = 0;

    private const FS_SIZE = 'size';
    private const FS_SUB_DIRECTORIES = 'dirs';
    private const FS_EMPTY_DIRECTORY_TEMPLATE = [
        self::FS_SIZE => 0,
        self::FS_SUB_DIRECTORIES => [],
    ];

    private const TYPE_COMMAND = 'command';
    private const TYPE_DIRECTORY = 'directory';
    private const TYPE_FILE = 'file';

    private const INDICATOR_COMMAND = '$ ';
    private const INDICATOR_DIRECTORY = 'dir ';

    private const COMMAND_CHANGE_DIRECTORY = 'cd ';

    private const DIRECTORY_SEPARATOR = '/';
    private const DIRECTORY_BACK = '..';

    public function solve(string $puzzle): int
    {
        foreach (explode(PHP_EOL, $puzzle) as $line) {
            $type = $this->determineType($line);

            switch ($type) {
                case self::TYPE_COMMAND:
                    $this->handleCommand($line);
                    break;
                case self::TYPE_FILE:
                    $this->handleFile($line);
                    break;
            }
        }

        $this->readDirectoryRecursive($this->fileSystem, 100000);

        return $this->sum;
    }

    private function readDirectoryRecursive(array $directory, int $maxFileSize): void
    {
        if ($directory[self::FS_SIZE] <= $maxFileSize) {
            $this->sum += $directory[self::FS_SIZE];
        }

        foreach ($directory[self::FS_SUB_DIRECTORIES] as $subDirectory) {
            $this->readDirectoryRecursive($subDirectory, $maxFileSize);
        }
    }

    private function handleCommand(string $line): void
    {
        $command = explode(self::INDICATOR_COMMAND, $line);
        $commandType = substr($command[1], 0, 3);

        if (self::COMMAND_CHANGE_DIRECTORY !== $commandType) {
            return;
        }

        $directory = explode(self::COMMAND_CHANGE_DIRECTORY, $command[1])[1];

        switch ($directory) {
            case self::DIRECTORY_SEPARATOR:
                $this->currentDirectory = '';
                return;
            case self::DIRECTORY_BACK:
                $this->moveUp();
                break;
            default:
                $this->moveDown($directory);
                break;
        }
    }

    private function moveUp(): void
    {
        $directoryStructure = explode('/', $this->currentDirectory);
        array_pop($directoryStructure);
        $this->currentDirectory = implode(self::DIRECTORY_SEPARATOR, $directoryStructure);
    }

    private function moveDown(string $directory): void
    {
        $this->currentDirectory .= '' === $this->currentDirectory
            ? $directory
            : self::DIRECTORY_SEPARATOR . $directory;
    }

    private function handleFile(string $line): void
    {
        $fileSize = (int) explode(' ', $line)[0];

        $current = &$this->fileSystem;

        foreach (explode(self::DIRECTORY_SEPARATOR, $this->currentDirectory) as $dir) {
            if (!$dir) {
                continue;
            }

            if (!array_key_exists($dir, $current[self::FS_SUB_DIRECTORIES])) {
                $current[self::FS_SUB_DIRECTORIES][$dir] = self::FS_EMPTY_DIRECTORY_TEMPLATE;
            }

            $current[self::FS_SIZE] += $fileSize;

            $current = &$current[self::FS_SUB_DIRECTORIES][$dir];
        }

        $current[self::FS_SIZE] += $fileSize;
    }

    private function determineType(string $line) {
        if (str_contains($line, self::INDICATOR_COMMAND)) {
            return self::TYPE_COMMAND;
        }

        if (str_contains($line, self::INDICATOR_DIRECTORY)) {
            return self::TYPE_DIRECTORY;
        }

        return self::TYPE_FILE;
    }
}