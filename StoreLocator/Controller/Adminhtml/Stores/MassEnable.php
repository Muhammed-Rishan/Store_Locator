<?php

namespace Codilar\StoreLocator\Controller\Adminhtml\Stores;

use Codilar\StoreLocator\Controller\Adminhtml\MassAction;
use Magento\Framework\Controller\ResultFactory;

class MassEnable extends MassAction
{
    public function execute()
    {
        $collection = $this->filter->getCollection($this->storeCollectionFactory->create());
        $collectionSize = $collection->getSize();
        foreach ($collection as $store) {
            $store->setIsActive(true);
            $this->storeRepository->save($store);
        }
        $this->messageManager->addSuccessMessage(__('A total of %1 store(s) have been enabled.', $collectionSize));
        $resultRedirect = $this->resultFactory->create(ResultFactory::TYPE_REDIRECT);
        return $resultRedirect->setPath('*/*/');
    }
}
