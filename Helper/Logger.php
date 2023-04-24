<?php

namespace MageEasy\DevTools\Helper;

use Magento\Framework\App\Helper\AbstractHelper;
use Magento\Framework\App\Helper\Context;

class Logger extends AbstractHelper
{
    /**
     * @param Context $context
     */
    public function __construct(Context $context)
    {
        parent::__construct($context);
    }

    public function log($dataToLog, $filename, Array $emailaddress = [], $email = false)
    {
        if (empty($filename)) {
            return;
        }

        $writer = new \Zend_Log_Writer_Stream(BP . '/var/log/' . $filename . ".log");
        $logger = new \Zend_Log();
        $logger->addWriter($writer);

        if (is_array($dataToLog) || is_object($dataToLog)) {
            $logger->debug(print_r($dataToLog, 1));
        } else {
            $logger->debug($dataToLog);
        }
    }
}
