<?php

namespace MageEasy\DevTools\Helper;

use Magento\Framework\App\Config\ScopeConfigInterface;
use Magento\Framework\App\Helper\AbstractHelper;
use Magento\Framework\App\Helper\Context;
use Magento\Store\Model\ScopeInterface;

class Config extends AbstractHelper
{
    /**
     * @var ScopeConfigInterface
     */
    protected $_scopeConfig;

    /**
     * @param Context $context
     * @param ScopeConfigInterface $scopeConfig
     */
    public function __construct(
        Context                                            $context,
        ScopeConfigInterface $scopeConfig
    ) {
        parent::__construct($context);
        $this->_scopeConfig = $scopeConfig;
    }

    public function getConfig($field, $storeId = null)
    {
        return $this->scopeConfig->getValue($field, ScopeInterface::SCOPE_STORE, $storeId);
    }

    // ADMIN LOGIN
    public function isAdminLoginEnabled()
    {
        return $this->getConfig("dev/mageeasy/admin_login/general/enabled");
    }

    public function adminLoginGetUsers()
    {
        $users = $this->getConfig("dev/mageeasy/admin_login/admin_users/users");
        $users = json_decode($users);
        $usersArray = [];

        if (!empty($users)) {
            foreach ($users as $user) {
                $usersArray[] = $user;
            }
        }
        return $usersArray;
    }

    // CUSTOMER LOGIN
    public function isCustomerLoginEnabled()
    {
        return $this->getConfig("dev/mageeasy/customer_login/general/enabled");
    }

    public function getCustomers()
    {
        $users = $this->getConfig("dev/mageeasy/customer_login/customer/list");
        $users = json_decode($users);
        $usersArray = [];

        if (!empty($users)) {
            foreach ($users as $user) {
                $usersArray[] = $user;
            }
        }
        return $usersArray;
    }

    // LAYOUT LOGGER
    public function isLayoutLoggerEnabled()
    {
        return $this->getConfig("dev/mageeasy/layout_logger/general/enabled");
    }

    // NAVIGATE TO ADMIN
    public function isNavigateToAdminEnabled()
    {
        return $this->getConfig("dev/mageeasy/navigate_to_admin/general/enabled");
    }

    public function getDevPathHintsStatus()
    {
        return (bool)$this->getConfig("dev/debug/template_hints_storefront");
    }

    public function getPathHintsParameter()
    {
        return $this->getConfig("dev/debug/template_hints_parameter_value");
    }

    public function getLessCompilationStatus()
    {
        return $this->getConfig("dev/front_end_development_workflow/type");
    }



}
