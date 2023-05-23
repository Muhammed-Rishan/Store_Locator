<?php

namespace Codilar\StoreLocator\Controller\Adminhtml;

use Codilar\StoreLocator\Api\StoreRepositoryInterface;
use Codilar\StoreLocator\Model\ResourceModel\Store\CollectionFactory as StoreCollectionFactory;
use Magento\Backend\App\Action;
use Magento\Ui\Component\MassAction\Filter;

abstract class MassAction extends Action
{
    protected $filter;
    protected $storeCollectionFactory;
    protected $storeRepository;

    public function __construct(
        Action\Context $context,
        Filter $filter,
        StoreCollectionFactory $storeCollectionFactory,
        StoreRepositoryInterface $storeRepository
    ) {
        $this->filter = $filter;
        $this->storeRepository = $storeRepository;
//        $this->categoryRepository= $categoryRepository;
        parent::__construct($context);
    }
}
