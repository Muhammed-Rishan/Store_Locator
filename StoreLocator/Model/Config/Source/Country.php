<?php
namespace Codilar\StoreLocator\Model\Config\Source;

use Magento\Directory\Model\ResourceModel\Country\Collection as CountryCollection;
use Magento\Framework\Option\ArrayInterface;

class Country implements ArrayInterface
{
    private $countryCollection;

    public function __construct(CountryCollection $countryCollection)
    {
        $this->countryCollection = $countryCollection;
    }

    private $options;

    public function toOptionArray($isMultiselect = false, $foregroundCountries = '')
    {
        $optionsArr = [];
        if (!$this->options) {
            $this->options = $this->countryCollection->loadData()->setForegroundCountries(
                $foregroundCountries
            )->toOptionArray(
                false
            );
        }

        $options = $this->options;
        if (!$isMultiselect) {
            array_unshift($options, ['value' => '', 'label' => __('--Please Select--')]);
        }

        foreach ($options as $option) {
            $optionsArr[$option['value']] = $option['label'];
        }

        return $optionsArr;
    }
}
