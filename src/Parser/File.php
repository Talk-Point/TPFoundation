<?php /** File repräsentation */
namespace TPFoundation\Parser;

use Exception;
use Iterator;
use TPFoundation\Helper\Exception\FileException;
use TPFoundation\Helper\Exception\FileNotReadableException;

/**
 * File Class is representiert ein file auf dem Dateisystem
 * @package TPFoundation\Helper
 * @example
 *      $file = new File(__DIR__.'/file-no-last-line', $line_start_position=50, $line_end_position=1000);
 *      $string = '';
 *      foreach($file as $key => $line){
 *         $string .= $key.$line;
 *      }
 */
class File extends \SplFileObject implements Iterator
{
    /**
     * Pfad zur Datei
     * @var string
     */
    protected $path;

    /**
     * Zeile in der gestartet werden soll
     * @var int
     */
    protected $line_start_position;

    /**
     * Zeile in der Datei in der gestoppt werden soll
     * @var int
     */
    protected $line_end_position;

    /**
     * Konstruktor
     * @param string $path Pfad zu der Datei
     * @param int $line_start_position
     * @param null $line_end_position
     * @throws FileException
     */
    public function __construct($path, $line_start_position=0, $line_end_position=null)
    {
        if (!is_string($path)) {
            throw new \InvalidArgumentException('File: $path not a string');
        }
        $this->path = $path;

        try {
            parent::__construct($path);
        } catch (Exception $e) {
            throw new FileNotReadableException($message='File can not read', $code=100, $previous=$e);
        }

        $this->line_start_position = $line_start_position;
        $this->line_end_position = $line_end_position;
    }

    /**
     * Gibt die Anzahl der Zeilen zurück
     * @return int count
     */
    public function getLinesCount()
    {
        $lines = COUNT(FILE($this->path));
        return $lines;
    }

    /**
     * (PHP 5 &gt;= 5.0.0)<br/>
     * Return the current element
     * @link http://php.net/manual/en/iterator.current.php
     * @return mixed Can return any type.
     */
    public function current()
    {
        return parent::current();
    }

    /**
     * (PHP 5 &gt;= 5.0.0)<br/>
     * Return the key of the current element
     * @link http://php.net/manual/en/iterator.key.php
     * @return mixed scalar on success, or null on failure.
     */
    public function key()
    {
        return parent::key();
    }

    /**
     * (PHP 5 &gt;= 5.0.0)<br/>
     * Checks if current position is valid
     * @link http://php.net/manual/en/iterator.valid.php
     * @return boolean The return value will be casted to boolean and then evaluated.
     * Returns true on success or false on failure.
     */
    public function valid()
    {
        if (!is_null($this->line_end_position)) {
            $line = $this->key();
            if ($line > $this->line_end_position) {
                return false;
            }
        }
        return parent::valid();
    }

    /**
     * Rewind the Iterator to the first element
     * @link http://php.net/manual/en/iterator.rewind.php
     * @return void Any returned value is ignored.
     */
    public function rewind()
    {
        parent::rewind();
        $this->seek($this->line_start_position);
    }
}
