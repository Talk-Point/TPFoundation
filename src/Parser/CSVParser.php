<?php /** Parst eine CSV Line by Line */

namespace TPFoundation\Parser;

/**
 * Parst eine CSV Datei Zeile f�r Zeile
 * @package TPFoundation\Parser
 * @example
 *      $csv = new CSVParser(__DIR__.'/test-delimiter.csv', $options=[
 *          'delimiter' => '|',
 *          'enclosure' => '"',
 *          'escape' => '\\'
 *      ]);
 *      $csv->parse($headerCall=function() use($mock){
 *          return true;
 *      }, $lineCall=function($line_array, $line_string, $line_count, $header_array) use ($mock) {
 *          return true; // False falls die Zeile nicht erfolgreich geparst werden konnte
 *      });
 */
class CSVParser extends Parser
{
    /**
     * Bestimmt das Feldtrennzeichen (nur ein Zeichen).
     * @var string
     */
    protected $delimiter;

    /**
     * Bestimmt das Textmarkierungszeichen (nur ein Zeichen).
     * @var string
     */
    protected $enclosure;

    /**
     * Bestimmt das Maskierungszeichen (nur ein Zeichen). Standardm��ig wird ein Backslash (\) verwendet.
     * @var string
     */
    protected $escape;

    /**
     * Gibt an ob die CSV Datei einen Header hat
     * @var bool
     */
    protected $is_header;

    /**
     * Konstruktor
     * @param string $path
     * @param array $options
     */
    public function __construct($path, $options=[])
    {
        parent::__construct($path, $options);

        $this->delimiter = $this->optionLoadVar($options, 'delimiter', ',');
        $this->enclosure = $this->optionLoadVar($options, 'enclosure', '"');
        $this->is_header = $this->optionLoadVar($options, 'is_header', false);
        $this->escape = $this->optionLoadVar($options, 'escape', '\\');
    }

    /**
     * Parst eine CSV Line by Line
     * @param callable $headerCall wird gecallt wenn der Header geparst wird
     * @param callable $lineCall wird f�r jede Zeile gecallt
     */
    public function parse(callable $headerCall, callable $lineCall)
    {
        // Header
        $hcall = $headerCall;
        $lcall = $lineCall;
        $this->parseLineByLine(function($line_count, $line_string) use ($hcall, $lcall) {
            $line_array = $this->splitCSVString($line_string);
            $header_array = null;
            if (($line_count==0) AND ($this->is_header)) {
                $rv = $hcall($line_count, $line_array);
                $header_array = $line_array;
            } else {
                $rv = $lcall($line_array, $line_string, $line_count, $header_array);
            }
            return $rv;
        });
    }

    /**
     * Splittet einen CSV String in ein Array mit den Optionen
     * @param $string
     * @return array
     */
    protected function splitCSVString($string)
    {
        return $line_array = str_getcsv($string, $delimiter=$this->delimiter,
            $enclosure=$this->enclosure,
            $escape=$this->escape
        );
    }
}
