<?php

namespace Kasifi\Gitascii;

use DateTime;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Yaml\Yaml;

class GitAscii
{
    private $font                = 'banner3';

    private $valueMapping;

    private $githubRepositoryUrl;

    /** @var string */
    private $filePath;

    /** @var bool */
    private $force;

    /** @var OutputInterface */
    private $output;

    /**
     * @var int
     */
    private $lineBreaks;

    public function __construct()
    {
//        $lineBreaks = 0,
//        $valueMapping = ,
//        $commitMessages = null,
//        $commitContent = null

        $this->resourcesPath = realpath(__DIR__ . '/Resources');
        $this->lineBreaks = 0;

        $this->gitHelper = new GitHelper($this->output, $this->resourcesPath);
    }

    public function write($str)
    {
        $this->valueMapping = ['#' => 2, ' ' => 1];

        $this->gitHelper->resetGitRepo();

        $ascii = $this->getAscii($str);

        echo "===================================================\n";
        echo $ascii . "\n";

        $symbol = $this->getSymbolFromAscii($ascii);

        echo "===================================================\n";
        $this->displaySymbol($symbol);
        echo "===================================================\n";
        $date = new DateTime();
        $date->setTime(12, 0, 0);
        $lastSunday = $this->getPreviousSunday($date);
        $this->writeSymbol($symbol, $lastSunday);
        //$this->forcePush();
    }

    public function writeJson($filename)
    {
//        'banner3', 0, [
//            '#eeeeee' => 0,
//            '#cdeb8b' => 1,
//            '#6bba70' => 2,
//            '#009938' => 3,
//            '#006e2e' => 4,
//        ]

        $json = json_decode(file_get_contents(__DIR__ . '/' . $filename), true);
        $symbol = $this->getSymbolFromJson($json);
        echo "===================================================\n";
        $this->displaySymbol($symbol);
        echo "===================================================\n";
        $date = new DateTime();
        $date->setTime(12, 0, 0);
        $lastSunday = $this->getPreviousSunday($date);
        $this->writeSymbol($symbol, $lastSunday);
        //$this->forcePush();
    }

    private function getPreviousSunday(DateTime $date)
    {
        return $this->sub($date, $date->format('w'));
    }

    /**
     * @return mixed
     */
    public function getGithubRepositoryUrl()
    {
        return $this->githubRepositoryUrl;
    }

    /**
     * @param mixed $githubRepositoryUrl
     */
    public function setGithubRepositoryUrl($githubRepositoryUrl)
    {
        $this->githubRepositoryUrl = $githubRepositoryUrl;
    }

    /**
     * @param OutputInterface $output
     */
    public function setOutput($output)
    {
        $this->output = $output;
    }

    /**
     * @return boolean
     */
    public function isForce()
    {
        return $this->force;
    }

    /**
     * @param boolean $force
     */
    public function setForce($force)
    {
        $this->force = $force;
    }

    /**
     * @return string
     */
    public function getFilePath()
    {
        return $this->filePath;
    }

    /**
     * @param string $filePath
     */
    public function setFilePath($filePath)
    {
        $this->filePath = $filePath;
    }
}
