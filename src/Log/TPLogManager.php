<?php /* Log Manager */

namespace TPFoundation\Log;

use Monolog\Logger;
use Monolog\Handler\StreamHandler;

class TPLogManager
{
    protected $log;

    /**
     * Konsturktor
     */
    public function __construct()
    {
        $logTitle = tpenv('TP_LOG_NAME', 'TP-Log');

        $log = tpenv('TP_LOG', 'developement');
        $this->log = new Logger($logTitle);
        if ($log == 'developement') {
            $this->log->pushHandler(new StreamHandler('php://stderr', Logger::DEBUG));
        } else {
            $slack_token = tpenv('TP_LOG_SLACK_TOKEN');
            $slack_room = tpenv('TP_LOG_SLACK_ROOM');
            $slackHandler = new \Monolog\Handler\SlackHandler($slack_token, $slack_room);
            $slackHandler->setFormatter(new \Monolog\Formatter\LineFormatter());
            $this->log->pushHandler($slackHandler, Logger::INFO);
        }

    }

    public function info($message, array $options = [])
    {
        $this->log->addInfo($message);
    }

    public function debug($message, array $options = [])
    {
        $this->log->addDebug($message, $options);
    }

    public function error($message, array $options = [])
    {
        $this->log->addError($message, $options);
    }

    public function critical($message, array $options = [])
    {
        $this->log->addCritical($message, $options);
    }
}