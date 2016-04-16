<?php

namespace Kasifi\Gitaski\Command;

use Exception;
use Kasifi\Gitaski\GitAski;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Style\SymfonyStyle;
use Symfony\Component\Yaml\Yaml;

class RunCommand extends Command
{
    /**
     * return void
     */
    protected function configure()
    {
        $this
            ->setName('run')
            ->setDescription('Build Github ASCII art')
            ->addArgument(
                'github_repository_url',
                InputArgument::OPTIONAL,
                'Which github repository URL?'
            )
            ->addOption(
                'use_text',
                null,
                InputOption::VALUE_REQUIRED,
                'If set, the ascii art will be generated from this text.'
            )
            ->addOption(
                'artwork_path',
                null,
                InputOption::VALUE_REQUIRED,
                'If set, the JSON file at this path will be used instead of the text.'
            )
            ->addOption(
                'input_filepath',
                'f',
                InputOption::VALUE_REQUIRED,
                'If set, this file will be used to generate dummy content.',
                __DIR__ . '/../Resources/fixtures/sample.md'
            )
            ->addOption(
                'commit_list_yml_filepath',
                null,
                InputOption::VALUE_REQUIRED,
                'If set, this file will be used to generate dummy content.',
                __DIR__ . '/../Resources/fixtures/commit-messages.yml'
            )
            ->addOption(
                'output_filename',
                null,
                InputOption::VALUE_REQUIRED,
                'If set, this filename will be used for the commited file.',
                'README.md'
            )
            ->addOption(
                'force',
                null,
                InputOption::VALUE_NONE,
                'If set, the commits will be really pushed to the repository URL, else it run in dry-mode mode.'
            );
    }

    /**
     * @param InputInterface  $input
     * @param OutputInterface $output
     *
     * @return void
     * @throws Exception
     */
    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $io = new SymfonyStyle($input, $output);

        $force = $input->getOption('force');
        $githubRepositoryUrl = $input->getArgument('github_repository_url');
        $inputFilePath = $input->getOption('input_filepath');
        if (!file_exists($inputFilePath)) {
            throw new Exception('Input file: '. $inputFilePath . ' was not found.');
        }
        $outputFilename = $input->getOption('output_filename');

        $commitsMessageYmlPath = $input->getOption('commit_list_yml_filepath');
        if (!file_exists($commitsMessageYmlPath)) {
            throw new Exception('Commit message file: '.$commitsMessageYmlPath . ' was not found.');
        }
        $commitMessages = Yaml::parse(file_get_contents($commitsMessageYmlPath));

        $gitaski = new GitAski($force, $githubRepositoryUrl, $inputFilePath, $outputFilename, $commitMessages);
        $gitaski->setIo($io);

        $useText = $input->getOption('use_text');
        if ($useText) {
            $gitaski->writeText($useText);
        } else {
            $artworkPath = $input->getOption('artwork_path');
            if (!$artworkPath) {
                throw new \InvalidArgumentException('Either "use_text" or "artwork_path" option should be defined');
            }
            $gitaski->writeJson($artworkPath);
        }
        $gitaski->clean();
    }
}