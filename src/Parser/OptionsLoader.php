<?php /** Verarbeitet Optionen für Klassen */

namespace TPFoundation\Parser;

/**
 * OptionsLoader verarbeitet Optionen für Klassen
 * @package TPFoundation\Helper
 */
trait OptionsLoader
{
    /**
     * Lädt eine Variable aus dem Option array
     * @param array $options Optionen der Klasse
     * @param string $name Name der Variable
     * @param $var Variable in die es gespeichert werden soll
     * @param string $default Default Value der Variable
     */
    public function optionLoadVar(array $options, $name, $var, $default)
    {
        array_key_exists($name, $options) ? $var = $options[$name] : $var = $default;
    }
}