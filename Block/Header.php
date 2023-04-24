<?php

namespace MageEasy\DevTools\Block;

use MageEasy\DevTools\Helper\Cache;
use MageEasy\DevTools\Helper\Config;
use MageEasy\DevTools\Helper\Request;
use Magento\Customer\Model\Session as CustomerSession;
use Magento\Framework\App\Http\Context as HttpContext;
use Magento\Framework\View\Element\Template;
use Magento\Framework\View\Element\Template\Context;
use Magento\Persistent\Helper\Session as PersistentSession;

class Header extends Template
{
    /**
     * @var Context
     */
    protected $_context;

    /**
     * @var HttpContext
     */
    protected $_appContext;

    /**
     * @var PersistentSession
     */
    protected $_persistentSession;

    /**
     * @var CustomerSession
     */
    protected $_customerSession;

    /**
     * @var Config
     */
    protected $_config;
    /**
     * @var Request
     */
    protected $_requestHelper;

    /**
     * @var Cache
     */
    protected $_cacheHelper;

    /**
     * @param Context $context
     * @param Config $config
     * @param CustomerSession $customerSession
     * @param PersistentSession $persistentSession
     * @param HttpContext $appContext
     * @param Request $requestHelper
     * @param Cache $cacheHelper
     */
    public function __construct(
        Context           $context,
        Config            $config,
        CustomerSession   $customerSession,
        PersistentSession $persistentSession,
        HttpContext       $appContext,
        Request           $requestHelper,
        Cache             $cacheHelper
    ) {
        $this->_context = $context;
        $this->_config = $config;
        $this->_customerSession = $customerSession;
        $this->_persistentSession = $persistentSession;
        $this->_appContext = $appContext;
        $this->_requestHelper = $requestHelper;
        $this->_cacheHelper = $cacheHelper;

        parent::__construct($context);
    }

    public function isCustomerLoginEnabled()
    {
        return $this->_config->isCustomerLoginEnabled();
    }

    public function isNavigateToAdminEnabled()
    {
        return $this->_config->isNavigateToAdminEnabled();
    }

    public function isCustomerAuthenticated()
    {
        return $this->_customerSession->isLoggedIn()
            || $this->_appContext->getValue(\Magento\Customer\Model\Context::CONTEXT_AUTH)
            || $this->_persistentSession->isPersistent();
    }

    public function getCustomers()
    {
        return $this->_config->getCustomers();
    }

    public function getDevPathHintsStatus()
    {
        return $this->_config->getDevPathHintsStatus();
    }

    public function getPathHintsParameter()
    {
        return $this->_config->getPathHintsParameter();
    }

    public function getLessCompilationStatus()
    {
        return $this->_config->getLessCompilationStatus();
    }

    public function getIsLayoutLoggerEnabled()
    {
        return $this->_config->isLayoutLoggerEnabled();
    }

    public function getRequestInfo() {
       return $this->_requestHelper->getRequestInformation();
    }

    public function getHandles()
    {
        return $this->getLayout()->getUpdate()->getHandles();
    }

    public function getStore()
    {
        return $this->_context->getStoreManager()->getStore();
    }

    public function getWebsite()
    {
        return $this->_context->getStoreManager()->getWebsite();
    }

    public function getAvailableTypes() {

        return $this->_cacheHelper->getAvailableTypes();
    }
}
