<?php

namespace Kasifi\Gitaski\Command;

use Exception;
use Humbug\SelfUpdate\Strategy\ShaStrategy;
use Humbug\SelfUpdate\Updater;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
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
        $io = new SymfonyStyle($input, $output);

        $updater = new Updater();
        $strategy = $updater->getStrategy();

        if ($strategy instanceof ShaStrategy) {
            $strategy->setPharUrl('http://lucascherifi.github.io/gitaski/gitaski.phar');
            $strategy->setVersionUrl('http://lucascherifi.github.io/gitaski/gitaski.phar.version');
        }

        $result = $updater->update();
        if (!$result) {
            $io = new SymfonyStyle($input, $output);
            $io->success('No update needed.');

            return;
        }
        $new = $updater->getNewVersion();
        $old = $updater->getOldVersion();
        $io->success(sprintf('Updated from %s to %s', $old, $new));

        return;
    }
}