<?php

namespace Codilar\StoreLocator\Controller\Adminhtml\Stores;

use Codilar\StoreLocator\Api\Data\StoreInterfaceFactory;
use Codilar\StoreLocator\Api\StoreRepositoryInterface;
use Codilar\StoreLocator\Controller\Adminhtml\Stores;
use Magento\Backend\App\Action\Context;
use \Codilar\StoreLocator\Helper\Config as ConfigHelper;
use Magento\Backend\Model\View\Result\Page;
use Magento\Framework\Registry;
use Magento\Framework\View\Result\PageFactory;

class Edit extends Stores
{
    protected $coreRegistry;

    public function __construct(
        Context $context,
        PageFactory $resultPageFactory,
        StoreRepositoryInterface $storeRepository,
        StoreInterfaceFactory $storeFactory,
        ConfigHelper $configHelper,
        Registry $registry
    ) {
        $this->coreRegistry = $registry;
        parent::__construct($context, $resultPageFactory, $storeRepository, $storeFactory, $configHelper);
    }

    /**
     * {@inheritdoc}
     */
    public function execute()
    {
        if ($error = $this->checkGoogleApiKey()) {
            return $error;
        }

        $id = $this->getRequest()->getParam('store_id');
        $store = $this->storeFactory->create();

        if ($id) {
            try {
                $store = $this->storeRepository->get($id);
            } catch (\Magento\Framework\Exception\NoSuchEntityException $e) {
                $this->messageManager->addErrorMessage(__('This store no longer exists.'));
                $resultRedirect = $this->resultRedirectFactory->create();

                return $resultRedirect->setPath('*/*/');
            } catch (\Exception $e) {
                $this->messageManager->addErrorMessage($e->getMessage());
                $resultRedirect = $this->resultRedirectFactory->create();

                return $resultRedirect->setPath('*/*/');
            }
        }

        $data = $this->_getSession()->getFormData(true);
        if (!empty($data)) {
            $store->setData($data);
        }

        $this->coreRegistry->register('storelocator_store', $store);

        /** @var Page $resultPage */
        $resultPage = $this->_initAction();
        $resultPage->addBreadcrumb(
            $id ? __('Edit Store') : __('Add New Store'),
            $id ? __('Edit Store') : __('Add New Store')
        );
        $resultPage->getConfig()->getTitle()->prepend(__('Storelocator Stores'));
        $resultPage->getConfig()->getTitle()
            ->prepend($store->getId() ? $store->getName() : __('Add New Store'));

        return $resultPage;
    }
}
