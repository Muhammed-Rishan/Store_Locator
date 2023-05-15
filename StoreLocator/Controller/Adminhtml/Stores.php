<?php

namespace Codilar\StoreLocator\Controller\Adminhtml;

use \Magento\Backend\App\Action;
use \Magento\Framework\View\Result\PageFactory;
use \Codilar\StoreLocator\Api\StoreRepositoryInterface;
use \Codilar\StoreLocator\Api\Data\StoreInterfaceFactory;
//use \Codilar\StoreLocator\Helper\Config as ConfigHelper;

abstract class Stores extends Action
{

    protected $resultPageFactory;

    protected $storeRepository;

    protected $storeFactory;

//    private $configHelper;


    public function __construct(
        Action\Context $context,
        PageFactory $resultPageFactory,
        StoreRepositoryInterface $storeRepository,
        StoreInterfaceFactory $storeFactory,
//        ConfigHelper $configHelper
    ) {
        $this->resultPageFactory = $resultPageFactory;
        $this->storeRepository = $storeRepository;
        $this->storeFactory = $storeFactory;
//        $this->configHelper = $configHelper;
        parent::__construct($context);
    }


    protected function _initAction()
    {
        $resultPage = $this->resultPageFactory->create();
        $resultPage->setActiveMenu('Codilar_StoreLocator::stores');
        return $resultPage;
    }


    protected function _isAllowed()
    {
        return $this->_authorization->isAllowed('Codilar_StoreLocator::stores');
    }


//    protected function checkGoogleApiKey()
//    {
//        if ($this->configHelper->getGoogleApiKeyFrontend() === null) {
//            $this->messageManager->addErrorMessage(__('Google Api Key is not set! Go to Stores -> Configuration -> Codilar Extensions -> Store Locator to change extension settings.'));
//            $resultRedirect = $this->resultRedirectFactory->create();
//            return $resultRedirect->setPath('*/*/index');
//        }
//        return false;
//    }
}
