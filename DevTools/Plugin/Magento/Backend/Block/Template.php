<?php
namespace MageEasy\DevTools\Plugin\Magento\Backend\Block;

class Template
{
    protected $_config;

    public function __construct(\MageEasy\DevTools\Helper\Config $config)
    {
        $this->_config = $config;
    }

    public function beforeToHtml(\Magento\Backend\Block\Template $subject)
    {
        if ($this->_config->isAdminLoginEnabled()) {
            if ($subject->getTemplate() === 'Magento_Backend::admin/login.phtml') {
                $subject->setTemplate('MageEasy_DevTools::admin/login.phtml');
            }
        }
    }
}
