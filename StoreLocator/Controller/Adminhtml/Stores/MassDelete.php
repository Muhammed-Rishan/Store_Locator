<?php

namespace Codilar\StoreLocator\Controller\Adminhtml\Stores;

use Codilar\StoreLocator\Controller\Adminhtml\MassAction;
use Magento\Framework\Controller\ResultFactory;

class MassDelete extends MassAction
{
    public function execute()
    {
        $collection = $this->filter->getCollection($this->storeCollectionFactory->create());
        $collectionSize = $collection->getSize();

        foreach ($collection as $item) {
            $this->storeRepository->delete($item);
        }

        $this->messageManager->addSuccessMessage(__('A total of %1 store(s) have been deleted.', $collectionSize));
        $resultRedirect = $this->resultFactory->create(ResultFactory::TYPE_REDIRECT);
        return $resultRedirect->setPath('*/*/');
    }
}
