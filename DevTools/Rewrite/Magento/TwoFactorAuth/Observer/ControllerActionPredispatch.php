<?php
declare(strict_types=1);

namespace MageEasy\DevTools\Rewrite\Magento\TwoFactorAuth\Observer;

use Magento\Framework\Event\Observer;

class ControllerActionPredispatch extends \Magento\TwoFactorAuth\Observer\ControllerActionPredispatch
{
    public function execute(Observer $observer)
    {
        return;
    }
}
