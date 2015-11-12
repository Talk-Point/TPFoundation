<?php /** Array, das beim hinzufügen doppelter Keys, die Anzahl in einem Count speichert */
namespace TPFoundation\DataStructure;

/**
 * Key Count Array
 *
 * Statt doppelte Eintr�ge im Array zu haben, werden diese gez�hlt ine inem count value
 * array product structure
 * [
 *      'pk' => ['count' => 1, data => $data],
 * ]
 * @package TPFoundation\DataStructure
 * @example
 *   $a = new KeyCountArray();
 *   $a->add('1', 'data-1');
 *   $a->add('1', 'data-1-1');
 *   $a->add('2', 'data-2');
 *   foreach($a as $key => $value) {};
 *
 */
class KeyCountArray implements \Iterator
{
    /**
     * Array was den Content vorh�lt
     * @var array
     */
    protected $content;

    /**
     * @var array Keys des haupt Arrays auf dem iteriert wird
     */
    protected $index;
    /**
     * @var int index count auf dem iteriert wird
     */
    protected $index_count;

    /**
     * Konstruktor
     */
    public function __construct()
    {
        $this->content = [];
    }

    /**
     * Wird gefeuert, nachdem sich etwas am ARray ge�ndert hat
     */
    public function changeNotification()
    {

    }

    /**
     * F�gt ein Element zum Array hinzu
     *
     * F�gt ein Element hinzu, sollte dieser Key bereits exestieren. Wird der Count des Elements erh�ht.
     *
     * @param string $pk Eindeutiger Schl�ssel
     * @param mixed $data Daten die vorgehalten werden sollen
     */
    public function add($pk, $data)
    {
        if (!is_string($pk)) {
            throw new \InvalidArgumentException('UniqKeyArray: add $pk is not a string');
        }

        if ($this->keyExists($pk)) {
            $this->addExistsItem($pk, $data);
        } else {
            $this->addNewItem($pk, $data);
        }


        $this->changeNotification();
    }

    /**
     * F�gt ein neues Item dem Content Array hinzu
     * @param string $pk Eindeutiger Schl�ssel
     * @param mixed $data Daten die vorgehalten werden sollen
     */
    protected function addNewItem($pk, $data)
    {
        $this->content[$pk] = ['count' => 1, 'data' => $data];
    }

    /**
     * Erh�ht den Count eines Elements, weil es schon exestiert als Key
     * @param string $pk Eindeutiger Schl�ssel
     * @param mixed $data Daten die vorgehalten werden sollen
     */
    protected function addExistsItem($pk, $data)
    {
        $this->content[$pk]['count'] = $this->content[$pk]['count'] + 1;
        $this->content[$pk]['data'] = $data;
    }

    /**
     * Entfernt ein Element aus dem Array
     * @param string $pk Eindeutiger Schl�ssel
     * @param bool|false $force gibt an ob alle Elemente aus dem Array gel�scht werden sollen mit dem Key $pk
     * @return bool Gibt an ob das Element mit dem key im Array exestiert hat
     */
    public function remove($pk, $force = false)
    {
        if (!is_string($pk)) {
            throw new \InvalidArgumentException('UniqKeyArray: add $pk is not a string');
        }

        if (!$this->keyExists($pk)) {
            return false;
        }

        if ($force === true) {
            $this->removeForce($pk);
        } else {
            $this->removeKeyOrDecrementCOuntBase($pk);
        }

        $this->changeNotification();

        return true;
    }

    /**
     * Entfernt das Element direkt
     * @param string $pk Eindeutiger Schl�ssel
     */
    protected function removeForce($pk)
    {
        unset($this->content[$pk]);
    }

    /**
     * Entfernt das Element oder Decrementiert den Count
     * @param string $pk Eindeutiger Schl�ssel
     */
    protected function removeKeyOrDecrementCOuntBase($pk)
    {
        if ($this->content[$pk]['count'] > 1) {
            $this->content[$pk]['count'] = $this->content[$pk]['count'] - 1;
        } else {
            $this->removeForce($pk);
        }
    }

    /**
     * Testet ob ein Key im Array exestiert
     * @param string $pk Eindeutiger Schl�ssel
     * @return bool
     */
    protected function keyExists($pk)
    {
        return array_key_exists($pk, $this->content) ? true : false;
    }

    /**
     * L�scht das Array
     */
    public function clear()
    {
        $this->content = [];
    }

    /**
     * Gibt die Anzahl der Elemente zur�ck, Elemente * Count
     * @return int Anzahl der Elemente mal ihren Count
     */
    public function count()
    {
        $count = 0;
        foreach($this->content as $key => $value) {
            $count += 1 * $value['count'];
        }
        return $count;
    }

    /**
     * Return the current element
     * @link http://php.net/manual/en/iterator.current.php
     * @return mixed Can return any type.
     * @since 5.0.0
     */
    public function current()
    {
        $index = $this->index_count;
        $key = $this->index[$index];

        return [$key, $this->content[$key]];
    }

    /**
     * Move forward to next element
     * @link http://php.net/manual/en/iterator.next.php
     * @return void Any returned value is ignored.
     * @since 5.0.0
     */
    public function next()
    {
        $this->index_count++;
    }

    /**
     * Return the key of the current element
     * @link http://php.net/manual/en/iterator.key.php
     * @return mixed scalar on success, or null on failure.
     * @since 5.0.0
     */
    public function key()
    {
        return $this->index[$this->index_count];
    }

    /**
     * Checks if current position is valid
     * @link http://php.net/manual/en/iterator.valid.php
     * @return boolean The return value will be casted to boolean and then evaluated.
     * Returns true on success or false on failure.
     * @since 5.0.0
     */
    public function valid()
    {
        return ($this->index_count < count($this->index));
    }

    /**
     * Rewind the Iterator to the first element
     * @link http://php.net/manual/en/iterator.rewind.php
     * @return void Any returned value is ignored.
     * @since 5.0.0
     */
    public function rewind()
    {
        $this->index_count = 0;
        $this->index = array_keys($this->content);
    }
}