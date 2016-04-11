<?php

// To generate :
// @see http://patorjk.com/software/taag/
// font name to use : http://artii.herokuapp.com/fonts_list

require('vendor/autoload.php');

class GitAscii
{
    const FILE_TO_MODIFY      = 'readme.md';
    const WORKSPACE_DIRECTORY = '../test';
    const DEBUG               = false;
    const GIT_URL             = 'git@github.com:lucascherifi/long-stories.git';
    private $font;
    private $valueMapping;
    private $commitMessages      = [
        'Today I will add the « %s »',
        'Oh today, I will add « %s ».',
        'Just add « %s ».',
        'Hey! I just add « %s » for now',
        'Hum, now I will add « %s » to my long list of commits',
        'At this time, I add « %s » and it will be a commit',
        'Tired today, but... I add « %s »',
        'Now I just want to add « %s »',
        'Time to add « %s »',
        'You know what? I will add « %s »',
        'Just a secret between you and me, I add « %s »',
        'New word today « %s »',
        'Today: word will be... « %s »!',
        'Hum if I added the « %s » word..',
        'Hey you, just look at the « %s » word !',
        'The word for today is... « %s »',
        'Add « %s »',
        'Quick add:  « %s »',
        'New word:  « %s »',
    ];
    private $commitContent       = '
    ### La Rochelle – Stupeur et incompréhension pour France Télévision après la découverte de ce week-end. Un homme,
    ancien candidat de l’émission Fort Boyard, dit avoir été oublié lors d’une épreuve de l’émission dans une des
    cellules, il y a plus de sept ans. Reportage.


    Le visage émacié, amaigri, Aymeric Ledeb revient de loin. L’homme, actuellement hospitalisé au CHU de la Rochelle,
    n’a pas encore raconté l’intégralité de son histoire aux enquêteurs mais on commence peu à peu à comprendre ce qui
    s’est passé. « C’était lors d’une épreuve de l’émission enregistrée sur le Fort. Il devait trouver un clé dans une
    série de jarres remplies de souris, insectes et autres matières visqueuses. Il n’a hélas pas pu terminer à temps et
    il est resté prisonnier comme le veut la règle », a expliqué un gendarme. Pour une raison jusqu’ici inexpliquée,
    le reste de ses coéquipiers va alors l’oublier dans sa cellule après la fin de l’émission. « Chacun a pensé qu’il
    était rentré par ses propres moyens, ou que vexé d’avoir échoué, il ne voulait pas reparler aux autres membres de
    l’équipe » raconte Ingrid, sa coéquipière de l’époque.
    L’enregistrement terminé, toutes les équipes regagnent ensuite le continent, laissant Aymeric à son triste sort.
    « L’épreuve a été supprimée lors de l’émission suivante et nous avons cessé d’utiliser cette partie du Fort pour les
    tournages. Personne n’est allé voir dans cette cellule, qui a été oubliée ensuite. Il y a des centaines de cellules
    de ce type dans tout le Fort » explique pour sa part Colin Jamiel, producteur de l’émission. Les murs très épais du
    site vont contenir les appels à l’aide de Aymeric. Le jeune homme va survivre miraculeusement en se nourrissant
    d’araignées, de souris, de rats et de racines.


    Le calvaire d’Aymeric va durer ainsi sept longues années. Jusqu’à ce week-end, quand une équipe chargée de la
    rénovation de certaines parties du Fort rouvre sa cellule. Ils y découvrent un homme blafard, les cheveux longs,
    presque aveugle. Pris en charge immédiatement par les secours, l’homme est rapidement hospitalisé. « Pendant qu’on
    s’occupait de lui, on a remarqué qu’il tenait quelque chose dans sa main, une petite clé » raconte un des pompiers.
    Ce qui prouverait donc que Aymeric avait donc presque réussi l’épreuve à l’époque.


    Pour l’instant l’ancien candidat n’a pas fait part d’une quelconque volonté de poursuivre en justice ses anciens
    camarades ainsi que la production de l’émission. S’il remportait un tel procès, les propriétaires du Fort
    pourraient bien débourser une somme astronomique de leur fameux boyards pour réparer le préjudice moral, mettant
    potentiellement en danger l’avenir de l’émission.

    ### Rennes – Le petit Benjamin, 8 ans, a sans doute vécu les vingt minutes les plus intenses de sa vie lorsqu’il
    a ouvert un paquet de chewing-gum dans la cour de récré. Récit.

    Encore des étoiles plein les yeux, Benjamin, élève en CE2, nous raconte ce qui restera pour longtemps l’un des
    grands moments de son existence : « Jamais je n’aurais cru qu’un simple paquet de chewing-gum ferait de moi le roi
    de la récré. Comme tous les jours, à chaque récré, je m’apprêtais à rester seul dans mon coin à dévorer
    « J’aime Lire », mais avant de me plonger dans l’histoire, j’ai ouvert le paquet de chewing-gum que ma maman
    m’avait offert la veille pour me féliciter de mon bon bulletin du premier trimestre. Et là, d’un coup, j’ai vu
    toute l’école s’approcher de moi en tendant la main. J’étais le centre du monde ! Tous les garçons qui ne veulent
    jamais de moi pour le match de football ont arrêté de jouer pour venir me voir. Certains connaissaient même mon
    prénom. Mieux : Clara, la plus jolie de la classe, m’a adressé la parole et fait un bisou sur la joue pour me
    remercier ».

    Sur son petit nuage, Benjamin, sourire jusqu’aux oreilles, continue son histoire : « C’était la folie ! Je
    voyais des bulles de chewing-gum roses se former autour de moi puis éclater comme lors d’un feu d’artifice. Je
    crois qu’avec le goût fraise j’avais fait le bon choix ». L’enfant nous explique que sa joie fut de courte durée,
    car, en face de lui, Nicolas, un garçon de CM1, venait de sortir de son sac un paquet de Choco BN : « Je me suis
    retrouvé seul en quelques secondes, mon paquet vide dans les mains. Je n’avais même pas eu le temps de m’en
    garder un pour moi. Et inutile de vous dire que je suis arrivé trop tard pour avoir un BN au chocolat. »

    Pas plus contrariée que ça, sa mère l’a cependant vite fait redescendre sur Terre : « Maman m’a énormément grondé
    en découvrant que le paquet était vide. Elle m’a rappelé qu’elle ne comptait pas nourrir l’école entière. Mais
    je compte bien réussir mon deuxième semestre pour recommencer. Se faire aduler au moins une fois dans sa vie est
    une expérience que je souhaite à tout le monde, nous avoue-t-il, avant de terminer, généreux : au fait, vous
    voulez un chewing-gum ? ».
    ';
    private $commitContentArray  = [];
    private $commitContentCursor = 0;
    /**
     * @var int
     */
    private $lineBreaks;

    public function __construct(
        $font = 'banner3',
        $lineBreaks = 0,
        $valueMapping = ['#' => 2, ' ' => 1],
        $commitMessages = null,
        $commitContent = null
    ) // spaces (0-3)
    {
        $this->workspacePath = __DIR__ . '/' . self::WORKSPACE_DIRECTORY;
        $this->font = $font;
        $this->valueMapping = $valueMapping;
        $this->lineBreaks = $lineBreaks;
        if ($commitMessages) {
            $this->commitMessages = $commitMessages;
        }
        if ($commitContent) {
            $this->commitContent = $commitContent;
        }

        $this->commitContentArray = explode(' ', $this->commitContent);
    }

    public function write($str)
    {

        $this->resetGitRepo();

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
        $this->forcePush();
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

    public function addCommit(Datetime $date)
    {
        $filePath = $this->workspacePath . '/' . self::FILE_TO_MODIFY;
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

        $this->execCmd('cd ' . $this->workspacePath . ' && git add ' . self::FILE_TO_MODIFY . ' && git commit -m \'' . $message . '\' --date="' . $dateStr . '"');
    }

    private function execCmd($cmd)
    {
        if (self::DEBUG) {
            echo $cmd . "\n";
        }
        $res = `$cmd`;
        if (self::DEBUG) {
            echo $res . "\n";
        }
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

    private function getPreviousSunday(DateTime $date)
    {
        return $this->sub($date, $date->format('w'));
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

    private function resetGitRepo()
    {
        $this->execCmd('cd ' . $this->workspacePath . ' && rm -rf .git; rm ' . self::FILE_TO_MODIFY . '; git init && git remote set-url origin ' . self::GIT_URL . '');
    }

    private function forcePush()
    {
        $this->execCmd('cd ' . $this->workspacePath . ' && git push --force --set-upstream origin master');
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

    public function writeJson($filename)
    {
        $json = json_decode(file_get_contents(__DIR__ . '/artwork.json'), true);
        $symbol = $this->getSymbolFromJson($json);
        echo "===================================================\n";
        $this->displaySymbol($symbol);
        echo "===================================================\n";
        $date = new DateTime();
        $date->setTime(12, 0, 0);
        $lastSunday = $this->getPreviousSunday($date);
        $this->writeSymbol($symbol, $lastSunday);
        $this->forcePush();
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
}

//$ga = new GitAscii();$ga->write(' Lucas');die;

$ga = new GitAscii('banner3', 0, [
    '#eeeeee' => 0,
    '#cdeb8b' => 1,
    '#6bba70' => 2,
    '#009938' => 3,
    '#006e2e' => 4,
]);
$ga->writeJson('artwork.json');
