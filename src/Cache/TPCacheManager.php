<?php /* TPCache managed den Cache für php stash */

namespace TPFoundation\Cache;

use Exception;
use RedisException;
use Stash;
use TPFoundation\Log\TPLog;
use Config;

/**
 * TPCache in Stash
 * @package App\Providers
 *
 * @example
 *  $item = TPCache::get(['pk', '123'], function() {
 *      return 'aergojaerg';
 *  }, 3600);
 *  echo $item;
 */
class TPCacheManager
{
    /**
     * Pool in dem gespeichert wird
     * @var Stash\Pool
     */
    protected $pool;

    /**
     *
     */
    public function __construct()
    {
        $cache_driver = tpenv('TP_CACHE_DRIVER', 'file');
        $this->createPool();
        return $this->pool;
    }

    protected function createPool()
    {
        $cache_driver = tpenv('TP_CACHE_DRIVER', 'file');
        switch($cache_driver)
        {
            case 'redis':
                $driver = new Stash\Driver\Redis();
                $server = Config::get('database.redis.default.host');
                $port = Config::get('database.redis.default.port');
                $database = Config::get('database.redis.default.database');
                TPLog::debug('Server Config: ', ['server' => $server, 'port' => $port]);
                $driver->setOptions(['servers' => [[$server, $port]], 'database' => $database]);
                break;
            default:
                $driver = new Stash\Driver\FileSystem();
                $driver->setOptions(['path' => $this->storagePath().'/framework/cache/stash']);
        }

        $this->pool = new Stash\Pool($driver);
    }

    public function storagePath()
    {
        if (function_exists("storage_path")) {
            return storage_path();
        }
        return '/tmp/';
    }

    /**
     * Gibt den Inhalt zurück oder erstellt ihn mit dem Callback
     * @param string|array $itemName eindeutigr Path zum Item
     * @param callable $setCallback CallBack mit dem das Item generiert wird
     * @param int $timeout Timeout in milliseconds
     * @return mixed|null das Item
     */
    public function getOrCreate($itemName, callable $setCallback, $timeout=3600)
    {
        return $this->get($itemName, $setCallback, $timeout);
    }

    /**
     * Gibt den Content des Items aus dem Cache zurück
     * @param string|array $itemName Item name
     * @param null $setCallback
     * @param int $timeout
     * @return Stash\Item
     * @throws Exception
     */
    public function get($itemName, $setCallback=null, $timeout = 3600)
    {
        try {
            return $this->getItem($itemName, $setCallback, $timeout)->get();
        } catch (RedisException $e) {
            $this->createPool();
            return $this->get($itemName, $setCallback, $timeout);
        } catch (Exception $e) {
            throw new Exception('TPCache: can not get');
        }
    }

    /**
     * Gibt ein Stash\Item aus dem Cache zurück
     * @param string|array $itemName eindeutigr Path zum Item
     * @param null $setCallback
     * @param int $timeout
     * @return Stash\Item
     */
    public function getItem($itemName, $setCallback=null, $timeout = 3600)
    {
        if (is_array($itemName)) {
            $itemName = $this->itemNameArrayToPath($itemName);
        }
        $item = $this->pool->getItem($itemName);
        if ($item->isMiss() && is_callable($setCallback)) {
            $call = $setCallback;
            $item->set($call(), $timeout);
        }
        return $item;
    }

    /**
     * Explizietes setzen der Daten für den Wahrenkorb
     * @param string|array $itemName eindeutigr Path zum Item
     * @param mixed $data Daten die gesetzt werden sollen
     * @param int $timeout Timeout in milliseconds
     * @throws Exception
     */
    public function set($itemName, $data, $timeout=3600)
    {
        try {
            if (is_array($itemName)) {
                $itemName = $this->itemNameArrayToPath($itemName);
            }
            $item = $this->pool->getItem($itemName);
            $item->set($data, $timeout);
        } catch (RedisException $e) {
            $this->createPool();
            return $this->set($itemName, $data, $timeout);
        } catch (Exception $e) {
            throw new Exception('TPCache: can not set');
        }
    }

    /**
     * Erstellt aus einem Array einen String und concatoniert die einzelnen Elemente
     * @param array $itemNameArray
     * @return string
     */
    private function itemNameArrayToPath(array $itemNameArray)
    {
        $path = '';
        foreach($itemNameArray as $key => $value) {
            $path .= '/'.$value;
        }
        return $path;
    }

    /**
     * Löscht den Cache eines Items und seine unter objekte
     * @param string|array $itemName eindeutigr Path zum Item
     */
    public function clearPath($itemName)
    {
        if (is_array($itemName)) {
            $itemName = $this->itemNameArrayToPath($itemName);
        }
        $item = $this->pool->getItem($itemName);
        $item->clear();
    }
}
