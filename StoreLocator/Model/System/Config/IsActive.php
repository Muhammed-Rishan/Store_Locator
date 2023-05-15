<?php
namespace Codilar\StoreLocator\Model\System\Config;

use \Magento\Framework\Option\ArrayInterface;
use \Codilar\StoreLocator\Model\Source\IsActive as Source;

class IsActive implements ArrayInterface
{
    /**
     * @var Source
     */
    private $source;


    public function __construct(Source $source)
    {
        $this->source = $source;
    }

    public function toOptionArray()
    {
        return $this->source->getAvailableStatuses();
    }
}
