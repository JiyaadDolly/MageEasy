<?php
declare(strict_types=1);

namespace MageEasy\DevTools\Controller\Query;

use MageEasy\DevTools\Helper\Cache;
use Magento\Framework\App\Action\Action;
use Magento\Framework\App\Action\Context;
use Magento\Framework\App\Config\Storage\WriterInterface;
use Magento\Framework\Controller\Result\JsonFactory;

class Index extends Action
{
    /**
     * @var JsonFactory
     */
    private $_resultJsonFactory;

    /**
     * @var WriterInterface
     */
    private $_configWriter;

    /**
     * @var Cache
     */
    private $_cacheHelper;

    /**
     * @param Context $context
     * @param JsonFactory $resultJsonFactory
     * @param WriterInterface $configWriter
     * @param Cache $cacheHelper
     */
    public function __construct(
        Context $context,
        JsonFactory $resultJsonFactory,
        WriterInterface $configWriter,
        Cache $cacheHelper
    ) {
        $this->_resultJsonFactory = $resultJsonFactory;
        $this->_configWriter = $configWriter;
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
        $toggle = $this->getRequest()->getParam('toggle');
        $value = $this->getRequest()->getParam('value') == "true" ? 1 : 0;

        if ($toggle == "path_hints") {
            $this->_configWriter->save("dev/debug/template_hints_storefront", $value);
            $this->_configWriter->save("dev/debug/template_hints_blocks", $value);
            $message = "dev/debug/template_hints_storefront set to " . $value;
            $this->_cacheHelper->refreshCache();
        }

        if ($toggle == "layout_logger") {
            $this->_configWriter->save("dev/mageeasy/layout_logger/general/enabled", $value);
            $message = "dev/debug/template_hints_blocks set to " . $value;
            $this->_cacheHelper->refreshCache();
        }

        if ($toggle == "less_compilation") {
            if ($value == 0) {
                $this->_configWriter->save("dev/front_end_development_workflow/type", "server_side_compilation");
                $message = "dev/front_end_development_workflow/type set to server_side_compilation";
            } elseif ($value == 1) {
                $this->_configWriter->save("dev/front_end_development_workflow/type", "client_side_compilation");
                $message = "dev/front_end_development_workflow/type set to client_side_compilation";
            }
            $this->_cacheHelper->refreshCache();
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
