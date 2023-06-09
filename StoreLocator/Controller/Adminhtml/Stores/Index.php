<?php

namespace Codilar\StoreLocator\Controller\Adminhtml\Stores;

use Codilar\StoreLocator\Controller\Adminhtml\Stores;

class Index extends Stores
{
    public function execute()
    {
        $resultPage = $this->_initAction();
        $resultPage->getConfig()->getTitle()->prepend(__('Store Locator - Stores'));

        return $resultPage;
    }
}
