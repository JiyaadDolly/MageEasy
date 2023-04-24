<?php
declare(strict_types=1);

namespace MageEasy\DevTools\Controller\Query;

use MageEasy\DevTools\Helper\Cache as CacheAlias;
use Magento\Framework\App\Action\Action;
use Magento\Framework\App\Action\Context;
use Magento\Framework\Controller\Result\JsonFactory;

class Cache extends Action
{
    /**
     * @var JsonFactory
     */
    private $_resultJsonFactory;

    /**
     * @var CacheAlias
     */
    private $_cacheHelper;

    /**
     * @param Context $context
     * @param JsonFactory $resultJsonFactory
     * @param CacheAlias $cacheHelper
     */
    public function __construct(
        Context $context,
        JsonFactory $resultJsonFactory,
        CacheAlias $cacheHelper
    ) {
        $this->_resultJsonFactory = $resultJsonFactory;
        $this->_cacheHelper = $cacheHelper;

        parent::__construct($context);
    }

    /**
     * Execute view action
     *
     * @return \Magento\Framework\Controller\ResultInterface
     */
    public function execute()
    {
        $message = "";
        $key = $this->getRequest()->getParam('key');
        $value = $this->getRequest()->getParam('value');

        if ($key == "refresh_cache") {
            $message = "Cache has been refreshed";
            $this->_cacheHelper->refreshCache();
        }

        if ($key == "refresh_cache_single") {
            $message = $value . " cache has been refreshed";
            $this->_cacheHelper->refreshCacheByType($value);
        }

        if ($key == "toggle_status") {
            $type = $this->getRequest()->getParam('type');

            $message = $type . " cache type status has been updated to " . $value;

            if ($value == "false") {
                $this->_cacheHelper->setEnabled($type, 0);
            } else {
                $this->_cacheHelper->setEnabled($type, 1);
                $this->_cacheHelper->refreshCacheByType($type);
            }
        }

        $response['data'] = [
            "success" => true,
            "message" => $message
        ];
        $resultJson = $this->_resultJsonFactory->create();
        $resultJson->setData($response);
        return $resultJson;
        exit();
    }
}
