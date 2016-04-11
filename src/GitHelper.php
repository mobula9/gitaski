<?php

namespace Kasifi\Gitascii;

use DateInterval;
use DateTime;
use Exception;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Yaml\Yaml;

class GitHelper
{
    const WORKSPACE_DIRECTORY = '../test';
    
    /** @var OutputInterface */
    private $output;

    private $commitContentCursor = 0;

    private $commitMessages;

    private $resourcesPath;

    private $commitContent;
    private $commitContentArray  = [];

    public function __construct(OutputInterface $output, $resourcesPath)
    {
        $this->output = $output;
        $this->commitMessages = Yaml::parse(file_get_contents($this->resourcesPath.'/commit-messages.yml'));
        $commitContent = file_get_contents($this->resourcesPath.'/sample.md');
        $this->commitContent = explode(' ', $commitContent);
        $this->workspacePath = realpath(__DIR__ . '/' . self::WORKSPACE_DIRECTORY);
    }

    public function addCommit(DateTime $date)
    {
        $filePath = $this->workspacePath . '/' . $this->filePath;
        $message = $this->commitMessages[array_rand($this->commitMessages)];

        if (!file_exists($filePath)) {
            touch($filePath);
        }

        $this->commitContentCursor++;

        $content = implode(' ', array_slice($this->commitContentArray, 0, $this->commitContentCursor));

        $message = sprintf($message, $this->commitContentArray[$this->commitContentCursor - 1]);
        $message = str_replace('\'', '-', $message);
        $message = str_replace('"', '-', $message);

        file_put_contents($filePath, $content);

        $dateStr = $date->format('r');

        $this->execCmd('cd ' . $this->workspacePath . ' && git add ' . $this->filePath . ' && git commit -m \'' . $message . '\' --date="' . $dateStr . '"');
    }

    private function resetGitRepo()
    {
        $this->execCmd('cd ' . $this->workspacePath . ' && rm -rf .git; rm ' . $this->filePath . '; git init && git remote set-url origin ' . $this->githubRepositoryUrl . '');
    }

    private function forcePush()
    {
        $this->execCmd('cd ' . $this->workspacePath . ' && git push --force --set-upstream origin master');
    }

    private function writeSymbol($symbol, DateTime $lastSunday)
    {
        $dates = $this->getDatesFromSymbol($symbol, $lastSunday);
        foreach ($dates as $date) {
            for ($i = 0; $i < $date['count']; $i++) {
                $this->addCommit($date['date']);
                echo '.';
            }
        }
        echo "\n";
    }

    private function getDatesFromSymbol($symbol, DateTime $lastSunday)
    {
        $dates = [];

        $width = count($symbol[0]);
        $height = count($symbol);

        if ($height != 7) {
            throw new Exception('Line height != 7');
        }

        $firstSunday = $this->sub($lastSunday, $width * $height);

        foreach ($symbol as $lineNumber => $line) {
            foreach ($line as $colNumber => $commitCount) {
                $daysGapWithFirstSunday = $lineNumber + $colNumber * 7;
                $date = $this->add($firstSunday, $daysGapWithFirstSunday);
                $dates[$date->format('Y-m-d')] = ['date' => $date, 'count' => $commitCount];
            }
        }
        ksort($dates);

        //dump($dates);die;

        return $dates;
    }

    private function sub(DateTime $date, $days)
    {
        $date = clone $date;

        return $date->sub(new DateInterval('P' . $days . 'D'));
    }

    private function add(DateTime $date, $days)
    {
        $date = clone $date;

        return $date->add(new DateInterval('P' . $days . 'D'));
    }

    private function execCmd($cmd)
    {
        if ($this->output->getVerbosity() >= OutputInterface::VERBOSITY_VERBOSE) {
            $this->output->writeln($cmd);
        }
        $res = `$cmd`;
        if ($this->output->getVerbosity() >= OutputInterface::VERBOSITY_VERBOSE) {
            $this->output->writeln($res);
        }
    }
}