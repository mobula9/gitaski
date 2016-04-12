<?php

namespace Kasifi\Gitaski;

use DateInterval;
use DateTime;
use Exception;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Style\SymfonyStyle;
use Symfony\Component\Process\Process;

class GitProcessor
{
    /** @var bool */
    private $force;

    /** @var SymfonyStyle */
    private $io;

    private $splitContentCursor = 0;

    /** @var array */
    private $commitMessages;

    /** @var array */
    private $splitContent = [];

    /** @var string */
    private $outputFilename;

    /** @var string */
    private $githubRepositoryUrl;

    /**
     * GitHelper constructor.
     *
     * @param string  $githubRepositoryUrl
     * @param boolean $force
     * @param string  $inputFilePath
     * @param string  $outputFilename
     * @param array   $commitMessages
     */
    public function __construct(
        $githubRepositoryUrl,
        $force,
        $inputFilePath,
        $outputFilename,
        array $commitMessages
    ) {
        $this->githubRepositoryUrl = $githubRepositoryUrl;
        $this->force = $force;
        $this->outputFilename = $outputFilename;
        $this->commitMessages = $commitMessages;
        $splitContent = file_get_contents($inputFilePath);
        $this->splitContent = explode(' ', $splitContent);
        $workspacePath = sys_get_temp_dir() . '/gitaski' . rand(0, 1000000);
        mkdir($workspacePath);
        $this->workspacePath = realpath($workspacePath);
    }

    /**
     * @return void
     */
    public function initLocalRepository()
    {
        $this->execCmd('git init && git remote set-url origin ' . $this->githubRepositoryUrl, true);
    }

    /**
     * @param DateTime $date
     */
    public function addCommit(DateTime $date)
    {
        $filePath = $this->workspacePath . '/' . $this->outputFilename;
        $message = $this->commitMessages[array_rand($this->commitMessages)];

        if (!file_exists($filePath)) {
            touch($filePath);
        }

        $this->splitContentCursor++;

        $content = implode(' ', array_slice($this->splitContent, 0, $this->splitContentCursor));

        $message = sprintf($message, $this->splitContent[$this->splitContentCursor - 1]);
        $message = str_replace('\'', '-', $message);
        $message = str_replace('"', '-', $message);

        file_put_contents($filePath, $content);

        $dateStr = $date->format('r');

        $this->execCmd('git add ' . $this->outputFilename . ' && git commit -m \'' . $message . '\' --date="' . $dateStr . '"');
    }

    public function clean()
    {
        $this->execCmd('rm -rf ' . $this->workspacePath);
    }

    /**
     * @param DateTime $date
     *
     * @return DateTime
     */
    public function getPreviousSunday(DateTime $date)
    {
        return $this->sub($date, $date->format('w'));
    }

    /**
     * @param SymfonyStyle $io
     */
    public function setIo(SymfonyStyle $io)
    {
        $this->io = $io;
    }

    /**
     * @return void
     */
    private function forcePush()
    {
        $this->execCmd('git push --force --set-upstream origin master');
    }

    /**
     * @param array    $symbol
     * @param DateTime $lastSunday
     *
     * @throws Exception
     */
    public function writeSymbol($symbol, DateTime $lastSunday)
    {
        $dates = $this->getDatesFromSymbol($symbol, $lastSunday);
        foreach ($dates as $date) {
            for ($i = 0; $i < $date['count']; $i++) {
                $this->addCommit($date['date']);
                echo '.';
            }
        }
        echo "\n";
        if ($this->force) {
            $this->forcePush();
            $this->io->comment('Git local checkout has been created and pushed to the origin repository. You can now view it online.');
        } else {
            $this->io->warning('Git local checkout has been created but not sent. Use --force to really push it to the github account.');
        }
        $this->io->success('Done.');
    }

    /**
     * @param array    $symbol
     * @param DateTime $lastSunday
     *
     * @return array
     * @throws Exception
     */
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

        return $dates;
    }

    /**
     * @param DateTime $date
     * @param integer  $days
     *
     * @return DateTime
     */
    private function sub(DateTime $date, $days)
    {
        $date = clone $date;

        return $date->sub(new DateInterval('P' . $days . 'D'));
    }

    /**
     * @param DateTime $date
     * @param integer  $days
     *
     * @return DateTime
     */
    private function add(DateTime $date, $days)
    {
        $date = clone $date;

        return $date->add(new DateInterval('P' . $days . 'D'));
    }

    /**
     * @param string $cmd
     * @param bool   $ignoreErrors
     *
     * @throws Exception
     */
    private function execCmd($cmd, $ignoreErrors = false)
    {
        $cmd = 'cd ' . $this->workspacePath . ' && ' . $cmd;
        if ($this->io->getVerbosity() >= OutputInterface::VERBOSITY_VERBOSE) {
            $this->io->comment($cmd);
        }
        $process = new Process($cmd);

        $process->run(function ($type, $buffer) use ($ignoreErrors) {
            if (Process::ERR === $type) {
                if ($ignoreErrors) {
                    if ($this->io->getVerbosity() >= OutputInterface::VERBOSITY_VERBOSE) {
                        $this->io->comment($buffer);
                    }
                } else {
                    $this->io->error($buffer);
                }
            } else {
                if ($this->io->getVerbosity() >= OutputInterface::VERBOSITY_VERBOSE) {
                    $this->io->comment($buffer);
                }
            }
        });

        if (!$ignoreErrors && !$process->isSuccessful()) {
            throw new Exception($process->getOutput() . $process->getErrorOutput());
        }
    }
}