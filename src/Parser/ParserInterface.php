<?php /** Parser Interface */

namespace TPFoundation\Parser;


/**
 * Interface ParserInterface
 * @package TPFoundation\Parser
 */
interface ParserInterface
{
    /**
     * Konstruktor
     * @param string $path
     * @param array $options
     */
    public function __construct($path, $options=[]);

    /**
     * Gibt an ob es beim Parsen zu errors gekommen ist
     * @return bool
     */
    public function isErrorByParsing();

    /**
     * Gibt ein Error Array zurück, was die Zeilen enthält die nicht geparst werden konnten
     * @return array error_by_linenumber
     */
    public function errors();
}