<?php /** Parser Abstract */

namespace TPFoundation\Parser;
use Exception;
use TPFoundation\Parser\File;
use TPFoundation\Parser\OptionsLoader;

/**
 * Abstrakter Parser
 * @package TPFoundation\Parser
 */
abstract class Parser implements ParserInterface
{
    use OptionsLoader;
    /**
     * Zeile in der gestartet werden soll
     * @var File
     */
    protected $file;

    /**
     * @var int
     */
    protected $line_start;

    /**
     * Zeile in der Datei in der gestoppt werden soll
     * @var null|int
     */
    protected $line_end;

    /**
     * Error Array mit den jeweiligen Zeilen
     * @var array
     */
    protected $error_line_array;

    /**
     * Gibt an ob beim parsen Errors passiert sind
     * @var bool
     */
    protected $is_errors_by_parsing;

    /**
     * Konstruktor
     * @param string $path
     * @param array $options
     */
    public function __construct($path, $options=[])
    {
        if (!is_array($options)) {
            throw new \InvalidArgumentException('OptionsLoader not a array');
        }

        $this->line_start = $this->optionLoadVar($options, 'line_start', 0);
        $this->line_end = $this->optionLoadVar($options, 'line_end', null);
        $this->error_line_array = [];
        $this->is_errors_by_parsing = false;
        $this->file = new File($path, $line_start_position=$this->line_start, $line_end_position=$this->line_end);
    }

    /**
     * Merkt sich die Zeile und denn Error und schaltet das Error Flag an
     * @param $line_count
     */
    protected function errorRaise($line_count)
    {
        $this->is_errors_by_parsing = true;
        array_push($this->error_line_array, $line_count);
    }

    /**
     * Gibt an ob es beim Parsen zu errors gekommen ist
     * @return bool
     */
    public function isErrorByParsing()
    {
        return $this->is_errors_by_parsing;
    }

    /**
     * Gibt ein Error Array zur�ck, was die Zeilen enth�lt die nicht geparst werden konnten
     * @return array error_by_linenumber
     */
    public function errors()
    {
        return $this->error_line_array;
    }

    /**
     * Parst eine datei Zeile f�r zeile und ruft den call auf
     * @param callable $call Call der aufgerufen wird bei jeder Zeile
     */
    public function parseLineByLine(callable $call)
    {
        // parse csv
        foreach($this->file as $line_count => $line_string) {
            try {
                $rv = $call($line_count, $line_string);
                ($rv == false) ? $this->errorRaise($line_count) : null;
            } catch (Exception $e) {
                $this->errorRaise($line_count);
            }
        }
    }
}