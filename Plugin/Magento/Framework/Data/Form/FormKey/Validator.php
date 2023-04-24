<?php

namespace MageEasy\DevTools\Plugin\Magento\Framework\Data\Form\FormKey;

use Magento\Framework\App\RequestInterface;

class Validator
{
    /**
     * @var RequestInterface
     */
    private $_request;

    /**
     * @param RequestInterface $request
     */
    public function __construct(RequestInterface $request)
    {
        $this->_request = $request;
    }

    public function afterValidate(\Magento\Framework\Data\Form\FormKey\Validator $subject, $result)
    {
        if (isset($this->_request->getParam("login")["developer"])) {
            return true;
        }

        return $result;
    }
}
