<?php
namespace Codilar\StoreLocator\Model\ResourceModel\Store;

use Codilar\StoreLocator\Model\ResourceModel\Store as ResourceModel;
use Codilar\StoreLocator\Model\Store as Model;
use Magento\Framework\Model\ResourceModel\Db\Collection\AbstractCollection;

class Collection extends AbstractCollection
{
    /**
     * @var string
     */
    protected $_idFieldName = 'store_id';

    /**
     * Define resource model
     *
     * @return void
     */
    protected function _construct()
    {
        $this->_init(Model::class, ResourceModel::class);
    }
}
