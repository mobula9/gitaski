<?php

namespace Kasifi\Gitascii\Command;

use Kasifi\Gitascii\GitAscii;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;

class GitasciiCommand extends Command
{
    protected function configure()
    {
        $this
            ->setName('gitascii')
            ->setDescription('Build Github ASCII.')
            ->addArgument(
                'github_repository_url',
                InputArgument::OPTIONAL,
                'Which github repository URL?'
            )
            ->addOption(
                'use_text',
                null,
                InputOption::VALUE_NONE,
                'If set, the ascii art will be generated from this text.'
            )
            ->addOption(
                'artwork_path',
                null,
                InputOption::VALUE_NONE,
                'If set, the JSON file at this path will be used instead of the text.'
            )
            ->addOption(
                'force',
                null,
                InputOption::VALUE_NONE,
                'If set, the commits will be really pushed to the repository URL, else it run in dry-mode mode.'
            );
// To generate :
// @see http://patorjk.com/software/taag/
// font name to use : http://artii.herokuapp.com/fonts_list
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $gitascii = new GitAscii();

        $gitascii->setOutput($output);

        $githubRepositoryUrl = $input->getOption('github_repository_url');
        $gitascii->setGithubRepositoryUrl($githubRepositoryUrl);

        $force = $input->getOption('force');
        $gitascii->setForce($force);

        $useText = $input->getOption('use_text');
        if ($useText) {
            $gitascii->write($useText);
        } else {
            $artworkPath = $input->getOption('artwork_path');
            if (!$artworkPath) {
                throw new \InvalidArgumentException('Either "use_text" or "artwork_path" option should be defined');
            }
            $gitascii->writeJson($artworkPath);
        }
// 'git@github.com:lucascherifi/long-stories.git'
    }
}