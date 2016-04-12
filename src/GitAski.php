<?php

namespace Kasifi\Gitaski;

use DateTime;
use Symfony\Component\Console\Style\SymfonyStyle;

class GitAski
{
    /** @var SymfonyStyle */
    private $io;

    /** @var GitProcessor */
    private $gitProcessor;

    /** @var DateTime */
    private $lastSunday;

    /**
     * Gitaski constructor.
     *
     * @param boolean $force
     * @param string  $githubRepositoryUrl
     * @param         $inputFilePath
     * @param         $outputFilename
     * @param array   $commitMessages
     */
    public function __construct($force, $githubRepositoryUrl, $inputFilePath, $outputFilename, array $commitMessages)
    {
        $this->gitProcessor= new GitProcessor($githubRepositoryUrl, $force, $inputFilePath, $outputFilename, $commitMessages);

        $date = new DateTime();
        $date->setTime(12, 0, 0);
        $this->lastSunday = $this->gitProcessor->getPreviousSunday($date);
    }

    /**
     * @param SymfonyStyle $io
     */
    public function setIo($io)
    {
        $this->io = $io;
        $this->gitProcessor->setIo($this->io);
    }

    public function writeText($str)
    {
        $this->gitProcessor->initLocalRepository();

        $asciiString = AsciiHelper::generateAsciiFromText($str);

        $this->io->note('Ascii string received:');
        $this->io->write($asciiString);

        $symbol = AsciiHelper::generateSymbolFromAsciiString($asciiString, ['#' => 2, ' ' => 1]);

        $this->write($symbol);
    }

    public function writeJson($filename)
    {
        $json = json_decode(file_get_contents(__DIR__ . '/' . $filename), true);
        $symbol = AsciiHelper::generateSymbolFromJson($json, [
            '#eeeeee' => 0,
            '#cdeb8b' => 1,
            '#6bba70' => 2,
            '#009938' => 3,
            '#006e2e' => 4,
        ]);
        $this->write($symbol);
    }

    public function clean() {
        $this->gitProcessor->clean();
    }

    /**
     * @param $symbol
     */
    private function write($symbol)
    {
        $this->io->note('Symbol to draw');
        $this->io->write(AsciiHelper::renderSymbol($symbol));
        $this->gitProcessor->writeSymbol($symbol, $this->lastSunday);
    }
}
