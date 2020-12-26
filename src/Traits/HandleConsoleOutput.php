<?php

namespace App\Traits;

use JMS\Serializer\SerializerBuilder;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Style\SymfonyStyle;

trait HandleConsoleOutput
{
    public function showTitle(InputInterface $input, OutputInterface $output, string $title) {
        $io = new SymfonyStyle($input, $output);
        $io->title($title);
    }

    public function showSection(InputInterface $input, OutputInterface $output, string $subTitle) {
        $io = new SymfonyStyle($input, $output);
        $io->section($subTitle);
    }

    public function showListing(InputInterface $input, OutputInterface $output, array $listing) {
        $io = new SymfonyStyle($input, $output);
        $io->listing($listing);
    }

    public function showTable(InputInterface $input, OutputInterface $output, array $header, array $rows) {
        $io = new SymfonyStyle($input, $output);
        $io->table($header, $rows);
    }

    public function showDetails(InputInterface $input, OutputInterface $output, $dto)
    {
        $serializer = SerializerBuilder::create()->build();
        $json = $serializer->serialize($dto, 'json');
        $dto = json_decode($json, true);

        foreach($dto as $field => $value) {
            if (is_array($value) && !empty($value[0]) && is_array($value[0])) {
                $this->showSection($input, $output, $field);
                $this->showTable($input, $output, array_keys($value[0]), $value);
            } elseif (is_array($value)) {
                $this->showSection($input, $output, $field);
                $this->showListing($input, $output, $value);
            } else {
                $output->writeln("<info>{$field}</info>: {$value}");
            }
        }
        $output->writeln('<comment>==================</comment>');
    }

    public function showList(InputInterface $input, OutputInterface $output, iterable $dtos)
    {
        foreach($dtos as $dto) {
            $this->showDetails($input, $output, $dto);
        }
    }

    public function showSuccess(InputInterface $input, OutputInterface $output, string $success) {
        $io = new SymfonyStyle($input, $output);
        $io->success($success);
    }

    public function showError(InputInterface $input, OutputInterface $output, string $error) {
        $io = new SymfonyStyle($input, $output);
        $io->error($error);
    }
}