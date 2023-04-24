<?php
declare(strict_types=1);

namespace MageEasy\DevTools\Rewrite\Magento\TwoFactorAuth\Observer;

use Magento\Framework\Event\Observer;
use Magento\TwoFactorAuth\Observer\ControllerActionPredispatch as ControllerActionPredispatchAlias;

class ControllerActionPredispatch extends ControllerActionPredispatchAlias
{
    public function execute(Observer $observer)
    {
        return;
    }
}
