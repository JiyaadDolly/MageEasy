<?php
namespace MageEasy\DevTools\Plugin\Magento\Backend\Block;

use MageEasy\DevTools\Helper\Config;

class Template
{
    /**
     * @var Config
     */
    protected $_config;

    /**
     * @param Config $config
     */
    public function __construct(Config $config)
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
