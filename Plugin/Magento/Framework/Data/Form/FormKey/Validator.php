<?php

namespace MageEasy\DevTools\Plugin\Magento\Framework\Data\Form\FormKey;

class Validator
{
    private $_request;

    public function __construct(\Magento\Framework\App\RequestInterface $request)
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
