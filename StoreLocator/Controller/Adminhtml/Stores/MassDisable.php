<?php

namespace Codilar\StoreLocator\Controller\Adminhtml\Stores;

use Codilar\StoreLocator\Controller\Adminhtml\MassAction;
use Magento\Framework\Controller\ResultFactory;

class MassDisable extends MassAction
{
    public function execute()
    {
        $collection = $this->filter->getCollection($this->storeCollectionFactory->create());
        $collectionSize = $collection->getSize();

        foreach ($collection as $store) {
            $store->setIsActive(false);
            $this->storeRepository->save($store);
        }

        $this->messageManager->addSuccessMessage(__('A total of %1 store(s) have been disabled.', $collectionSize));
        $resultRedirect = $this->resultFactory->create(ResultFactory::TYPE_REDIRECT);
        return $resultRedirect->setPath('*/*/');
    }
}
