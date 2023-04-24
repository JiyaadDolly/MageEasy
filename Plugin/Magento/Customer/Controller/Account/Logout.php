<?php

namespace MageEasy\DevTools\Plugin\Magento\Customer\Controller\Account;

class Logout
{
    protected $session;

    protected $request;

    protected $resultJsonFactory;

    public function __construct(
        \Magento\Framework\Controller\Result\JsonFactory $resultJsonFactory,
        \Magento\Customer\Model\Session $customerSession,
        \Magento\Framework\App\RequestInterface $request
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
