<?php

namespace MageEasy\DevTools\Block;

class Header extends \Magento\Framework\View\Element\Template
{
    protected $_context;
    protected $_appContext;
    protected $_persistentSession;
    protected $_customerSession;
    protected $_config;
    protected $_requestHelper;
    protected $_cacheHelper;

    /**
     * @var \Magento\Store\Model\StoreManagerInterface
     */
    protected $_storeManager;

    public function __construct(
        \Magento\Framework\View\Element\Template\Context $context,
        \MageEasy\DevTools\Helper\Config $config,
        \Magento\Customer\Model\Session $customerSession,
        \Magento\Persistent\Helper\Session $persistentSession,
        \Magento\Framework\App\Http\Context $appContext,
        \MageEasy\DevTools\Helper\Request $requestHelper,
        \MageEasy\DevTools\Helper\Cache $cacheHelper
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
