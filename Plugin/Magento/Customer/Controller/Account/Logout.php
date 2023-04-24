<?php

namespace MageEasy\DevTools\Plugin\Magento\Customer\Controller\Account;

use Magento\Customer\Model\Session;
use Magento\Framework\App\RequestInterface;
use Magento\Framework\Controller\Result\JsonFactory;

class Logout
{
    /**
     * @var Session
     */
    protected $session;

    /**
     * @var RequestInterface
     */
    protected $request;

    /**
     * @var JsonFactory
     */
    protected $resultJsonFactory;

    /**
     * @param JsonFactory $resultJsonFactory
     * @param Session $customerSession
     * @param RequestInterface $request
     */
    public function __construct(
        JsonFactory      $resultJsonFactory,
        Session          $customerSession,
        RequestInterface $request
    ) {
        $this->resultJsonFactory = $resultJsonFactory;
        $this->session = $customerSession;
        $this->request = $request;
    }

    public function afterExecute(\Magento\Customer\Controller\Account\Logout $subject, $result)
    {
        $isDeveloperLogout = $this->request->getPost('developerLogout');

        if ($isDeveloperLogout) {
            $this->session->destroy();

            $response['data'] = ["developer_logout_success" => true];
            $resultJson = $this->resultJsonFactory->create();
            $resultJson->setData($response);
            return $resultJson;
            exit();
        }

        return $result;
    }
}
