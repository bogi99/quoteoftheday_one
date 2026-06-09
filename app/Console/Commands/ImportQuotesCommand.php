<?php

namespace App\Console\Commands;

use App\Models\Quotes;
use Illuminate\Console\Attributes\Description;
use Illuminate\Console\Attributes\Signature;
use Illuminate\Console\Command;

#[Signature('csv:import {file}')]
#[Description('Import quotes from a CSV file into the database.')]
class ImportQuotesCommand extends Command
{
    public function handle(): int
    {
        $filePath = $this->argument('file');

        if (! is_string($filePath) || $filePath === '' || ! file_exists($filePath)) {
            $this->error("File not found: {$filePath}");

            return self::FAILURE;
        }

        $handle = fopen($filePath, 'r');

        if ($handle === false) {
            $this->error("Could not open file: {$filePath}");

            return self::FAILURE;
        }

        $header = fgetcsv($handle);

        if ($header === false) {
            fclose($handle);
            $this->error("Could not read header from file: {$filePath}");

            return self::FAILURE;
        }

        $batch = [];
        $batchSize = 100;
        $totalImported = 0;

        while (($row = fgetcsv($handle)) !== false) {
            $data = array_combine($header, $row);

            if ($data === false) {
                continue;
            }

            $batch[] = [
                'quote' => $data['quote'] ?? '',
                'author' => $data['author'] ?? '',
                'created_at' => now(),
                'updated_at' => now(),
            ];

            if (count($batch) >= $batchSize) {
                Quotes::insert($batch);
                $totalImported += count($batch);
                $batch = [];
            }
        }

        if ($batch !== []) {
            Quotes::insert($batch);
            $totalImported += count($batch);
        }

        fclose($handle);

        $this->info("Imported {$totalImported} quotes from {$filePath}.");

        return self::SUCCESS;
    }
}
