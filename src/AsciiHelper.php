<?php

namespace Kasifi\Gitascii;

class AsciiHelper
{
    private function displaySymbol($symbol)
    {
        foreach ($symbol as $row) {
            foreach ($row as $cell) {
                switch ($cell) {
                    case 0:
                        echo " ";
                        break;
                    case 1:
                        echo "░";
                        break;
                    case 2:
                        echo "▒";
                        break;
                    case 3:
                        echo "▓";
                        break;
                    case 4:
                        echo "█";
                        break;
                }
            }
            echo "\n";
        }
    }

    private function getSymbolFromAscii($ascii)
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
                $newCols[] = $this->getMappedValue($col);
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
    private function getAscii($string)
    {
        $ascii = file_get_contents('http://artii.herokuapp.com/make?text=' . urlencode($string) . '&font=' . $this->font);
        $lines = explode("\n", $ascii);
        $width = count($lines[0]);

        if ($this->lineBreaks > 0) {
            $more = '';
            for ($i = 0; $i < $this->lineBreaks; $i++) {
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

    private function getSymbolFromJson($json)
    {
        $lines = $json['layers'][0]['rows'];

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
                    $newCols[] = $this->getMappedValue($col);
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

    private function getMappedValue($col)
    {
        $value = 0;
        if (isset($this->valueMapping[$col])) {
            $value = $this->valueMapping[$col];
        } else {
            if ($col == ' ') {
                $value = 0;
            }
        }

        return $value;
    }
}