<?php

namespace Codilar\StoreLocator\Controller\Index;

use Magento\Framework\View\Result\Page;

class Index extends \Codilar\StoreLocator\Controller\Index
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
