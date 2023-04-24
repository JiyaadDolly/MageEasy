<?php

namespace MageEasy\DevTools\Helper;

use Magento\Framework\App\Cache\Frontend\Pool;
use Magento\Framework\App\Cache\TypeListInterface;
use Magento\Framework\App\Helper\AbstractHelper;
use Magento\Framework\App\Helper\Context;
use Magento\Framework\App\Cache\Manager;

class Cache extends AbstractHelper
{

    /**
     * @var TypeListInterface
     */
    private $_cacheTypeList;

    /**
     * @var Pool
     */
    private $_cacheFrontendPool;

    /**
     * @var Manager
     */
    private $_cacheManager;

    /**
     * @param Context $context
     * @param TypeListInterface $cacheTypeList
     * @param Pool $cacheFrontendPool
     */
    public function __construct(
        Context $context,
        TypeListInterface $cacheTypeList,
        Pool $cacheFrontendPool,
        Manager $cacheManager
    )
    {
        parent::__construct($context);

        $this->_cacheTypeList = $cacheTypeList;
        $this->_cacheFrontendPool = $cacheFrontendPool;
        $this->_cacheManager = $cacheManager;
    }

    public function refreshCache()
    {
        $types = $this->getAvailableTypes();

        foreach ($types as $cacheKey => $type)
        {
            $this->_cacheTypeList->cleanType($cacheKey);
        }
    }

    public function getAvailableTypes()
    {
        $cacheTypes = $this->_cacheTypeList->getTypes();
        $invalidatedCacheTypes = $this->_cacheTypeList->getInvalidated();

        foreach ($cacheTypes as $type)
        {
            foreach ($invalidatedCacheTypes as $invalidType)
            {
                if($type->getId() == $invalidType->getId())
                {
                    $type->setInvalidated(1);
                }
                else
                {
                    $type->setInvalidated(0);
                }
            }
        }

        return $cacheTypes;
    }

    public function refreshCacheByType($type) {

        $this->_cacheTypeList->cleanType($type);
    }

    public function setEnabled($type, $isEnabled) {

        return $this->_cacheManager->setEnabled([$type], $isEnabled);
    }
}
