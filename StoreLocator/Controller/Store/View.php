<?php

namespace Codilar\StoreLocator\Controller\Store;

use Magento\Framework\View\Result\Page;

class View extends \Codilar\StoreLocator\Controller\Index
{
    /**
     * @return Page
     */
    public function execute()
    {
        $resultPage = $this->resultPageFactory->create();
        $resultPage->getConfig()->getTitle()->set(__('Store Locator'));

        return $resultPage;
    }
}
