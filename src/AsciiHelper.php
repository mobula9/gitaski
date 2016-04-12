<?php

namespace Kasifi\Gitaski;

use Exception;

class AsciiHelper
{
    /**
     * @param array $symbol
     *
     * @return string
     */
    public static function renderSymbol($symbol)
    {
        $output = '';
        foreach ($symbol as $row) {
            foreach ($row as $cell) {
                switch ($cell) {
                    case 0:
                        $output .= " ";
                        break;
                    case 1:
                        $output .= "░";
                        break;
                    case 2:
                        $output .= "▒";
                        break;
                    case 3:
                        $output .= "▓";
                        break;
                    case 4:
                        $output .= "█";
                        break;
                }
            }
            $output .= "\n";
        }

        return $output;
    }

    /**
     * @param string $ascii
     * @param array  $charMapping
     *
     * @return array
     * @throws Exception
     */
    public static function generateSymbolFromAsciiString($ascii, $charMapping)
    {
        $symbol = [];
        $lines = explode("\n", $ascii);
        $width = strlen($lines[0]);
        if ($width > 52) {
            throw new Exception('Text width should be <= 52 chars, now it\'s ' . $width . '.');
        }

        foreach ($lines as $cols) {
            $newCols = [];
            for ($i = 0; $i < strlen($cols); $i++) {
                $col = $cols[$i];
                $newCols[] = self::getMappedValue($col, $charMapping);
            }
            $symbol[] = $newCols;
        }

        return $symbol;
    }

    /**
     * @param $string
     *
     * @return string
     */
    public static function generateAsciiFromText($string)
    {
        $lineBreaks = 0;
        $font = 'banner3';

        $ascii = file_get_contents('http://artii.herokuapp.com/make?text=' . urlencode($string) . '&font=' . $font);
        $lines = explode("\n", $ascii);
        $width = count($lines[0]);

        if ($lineBreaks > 0) {
            $more = '';
            for ($i = 0; $i < $lineBreaks; $i++) {
                $more .= str_pad($more, $width) . "\n";
            }
            $ascii = $more . $ascii;
        }
        $lines = explode("\n", $ascii);

        $ret = [];
        foreach ($lines as $key => $line) {
            if ($key < 7) {
                $ret[] = $line;
            }
        }

        return $ascii;
    }

    /**
     * @param array $parsedJson
     * @param array $charMapping
     *
     * @return array
     * @throws Exception
     */
    public static function generateSymbolFromJson($parsedJson, $charMapping)
    {
        $lines = $parsedJson['layers'][0]['rows'];

        $symbol = [];
        $width = count($lines[0]['cells']);
        if ($width > 52) {
            throw new Exception('Text width should be <= 52 chars, now it\'s ' . $width . '.');
        }
        if (count($lines) < 5) {
            throw new Exception('Text height should be >= 5 lines, now it\'s ' . count($lines) . '.');
        }

        foreach ($lines as $key => $line) {
            if ($key < 7) {
                $newCols = [];
                foreach ($line['cells'] as $cell) {
                    $col = $cell[2];
                    $newCols[] = self::getMappedValue($col, $charMapping);
                }
                $symbol[] = $newCols;
            }
        }

        if (count($symbol) != 7) {
            $newCols = [];
            for ($i = 0; $i < (7 - count($symbol)); $i++) {
                for ($j = 0; $j < $width; $j++) {
                    $newCols[] = 0;
                }
            }
            $symbol[] = $newCols;
        }

        return $symbol;
    }

    /**
     * @param string $char
     * @param array  $charMapping
     *
     * @return int
     */
    public static function getMappedValue($char, $charMapping)
    {
        $value = 0;
        if (isset($charMapping[$char])) {
            $value = $charMapping[$char];
        } else {
            if ($char == ' ') {
                $value = 0;
            }
        }

        return $value;
    }
}