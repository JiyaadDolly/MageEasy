<?php

namespace MageEasy\DevTools\Helper;

use Magento\Backend\App\Area\FrontNameResolver;
use Magento\Framework\App\Helper\AbstractHelper;
use Magento\Framework\App\Helper\Context;
use Magento\Framework\App\ProductMetadataInterface;
use Magento\Framework\App\State;

class Request extends AbstractHelper
{
    /**
     * @var Context
     */
    private $_context;

    /**
     * @var State
     */
    private $_appState;

    /**
     * @var FrontNameResolver
     */
    protected $_frontNameResolver;

    /**
     * @var ProductMetadataInterface
     */
    protected $_productMetadata;

    /**
     * @param Context $context
     * @param State $appState
     * @param FrontNameResolver $frontNameResolver
     * @param ProductMetadataInterface $productMetadata
     */
    public function __construct(
        Context                  $context,
        State                    $appState,
        FrontNameResolver        $frontNameResolver,
        ProductMetadataInterface $productMetadata
    )
    {
        parent::__construct($context);

        $this->_context = $context;
        $this->_appState = $appState;
        $this->_frontNameResolver = $frontNameResolver;
        $this->_productMetadata   = $productMetadata;
    }

    public function getRequestInformation()
    {
        $request = $this->_context->getRequest();

        $requestData["base_url"] = ['name' => 'Base Url', 'value' => $request->getDistroBaseUrl(), 'is_url' => true];
        $requestData["path_info"] = ['name' => 'Path Info', 'value' => $request->getPathInfo()];
        $requestData["module_name"] = ['name' => 'Module Name', 'value' => $request->getModuleName()];
        $requestData["route"] = ['name' => 'Route', 'value' => $request->getRouteName()];
        $requestData["controller"] = ['name' => 'Controller', 'value' => $request->getControllerName()];
        $requestData["action"] = ['name' => 'Action', 'value' => $request->getActionName()];
        $requestData["full_action"] = ['name' => 'Full Action', 'value' => $request->getFullActionName()];
        $requestData["area"] = ['name' => 'Area', 'value' => $this->_appState->getAreaCode()];
        $requestData["client_ip"] = ['name' => 'Client IP', 'value' => $request->getClientIp()];
        $requestData["magento_version"] = ['name' => 'Magento', 'value' => $this->_productMetadata->getVersion()];
        $requestData["mode"] = ['name' => 'Mage Mode', 'value' => $this->_appState->getMode()];
        $requestData["backend_url"] = ['name' => 'Backend', 'value' => $request->getDistroBaseUrl() . $this->_frontNameResolver->getFrontName(), 'is_url' => true];

        if ($request->getBeforeForwardInfo()) {
            $requestData["before_forward"] = ['name' => 'Before Forward', 'value' => $request->getBeforeForwardInfo()];
        }

        if ($request->getParams()) {
            $requestData["params"] = ['name' => 'Params', 'value' => implode(",", $request->getParams())];
        }

        return $requestData;
    }
}
