<?php

namespace Codilar\StoreLocator\Controller\Adminhtml\Stores;

use Codilar\StoreLocator\Api\Data\StoreInterfaceFactory;
use Codilar\StoreLocator\Api\StoreRepositoryInterface;
use Codilar\StoreLocator\Controller\Adminhtml\Stores;
use Codilar\StoreLocator\Helper\Config as ConfigHelper;
use Magento\Backend\App\Action\Context;
use Magento\Backend\Model\View\Result\ForwardFactory;
use Magento\Framework\View\Result\PageFactory;

class NewAction extends Stores
{
    protected $resultForwardFactory;

    public function __construct(
        Context $context,
        PageFactory $resultPageFactory,
        StoreRepositoryInterface $storeRepository,
        StoreInterfaceFactory $storeFactory,
        ConfigHelper $configHelper,
        ForwardFactory $resultForwardFactory
    ) {
        $this->resultForwardFactory = $resultForwardFactory;
        parent::__construct($context, $resultPageFactory, $storeRepository, $storeFactory, $configHelper);
    }

    public function execute()
    {
        if ($error = $this->checkGoogleApiKey()) {
            return $error;
        }
        $resultForward = $this->resultForwardFactory->create();
        return $resultForward->forward('edit');
    }
}
