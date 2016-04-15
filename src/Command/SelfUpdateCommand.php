<?php

namespace Kasifi\Gitaski\Command;

use Exception;
use Humbug\SelfUpdate\Updater;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Style\SymfonyStyle;

class SelfUpdateCommand extends Command
{
    /**
     * return void
     */
    protected function configure()
    {
        $this
            ->setName('self-update')
            ->setDescription('Self update of Gitaski binary.');
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

        $updater = new Updater();
        $updater->getStrategy()->setPharUrl('http://lucascherifi.github.io/gitaski/gitaski.phar');
        $updater->getStrategy()->setVersionUrl('http://lucascherifi.github.io/gitaski/gitaski.phar.version');
        $io = new SymfonyStyle($input, $output);
        try {
            $result = $updater->update();
            if (!$result) {
                $io = new SymfonyStyle($input, $output);
                $io->success('No update needed.');
                exit(0);
            }
            $new = $updater->getNewVersion();
            $old = $updater->getOldVersion();
            $io->success(sprintf('Updated from %s to %s', $old, $new));
            exit(0);
        } catch (\Exception $e) {
            $io->error($e->getMessage());
            exit(1);
        }
    }
}