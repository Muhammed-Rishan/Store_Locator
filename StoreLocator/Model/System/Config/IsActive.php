<?php
namespace Codilar\StoreLocator\Model\System\Config;

use Codilar\StoreLocator\Model\Source\IsActive as Source;
use Magento\Framework\Option\ArrayInterface;

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
