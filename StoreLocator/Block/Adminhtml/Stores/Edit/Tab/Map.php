<?php
namespace Codilar\StoreLocator\Block\Adminhtml\Stores\Edit\Tab;

use Codilar\StoreLocator\Block\Adminhtml\Stores\Helper\GoogleMap;
use Codilar\StoreLocator\Model\Config\Source\Country;
use Magento\Backend\Block\Template\Context;
use Magento\Backend\Block\Widget\Form\Generic;
use Magento\Framework\Data\FormFactory;
use Magento\Framework\Registry;

class Map extends Generic
{
    /**
     * @var Country
     */
    private $country;

    public function __construct(
        Context $context,
        Registry $registry,
        FormFactory $formFactory,
        Country $country,
        array $data = []
    ) {
        $this->country = $country;

        parent::__construct($context, $registry, $formFactory, $data);
    }

    /**
     * View URL getter
     *
     * @param int $storeId
     *
     * @return string
     */
    public function getViewUrl(int $storeId): string
    {
        return $this->getUrl('storelocator/*/*', ['store_id' => $storeId]);
    }

    /**
     * @return $this
     */
    protected function _prepareForm(): static
    {
        $model = $this->_coreRegistry->registry('storelocator_store');

        $form = $this->_formFactory->create();

        $fieldset = $form->addFieldset(
            'map_fieldset',
            ['legend' => __('Localization informations')]
        );

        $fieldset->addType('google_map', GoogleMap::class);

        $fieldset->addField(
            'lat',
            'text',
            [
                'name'     => 'lat',
                'label'    => __('Latitude'),
                'required' => true
            ]
        );

        $fieldset->addField(
            'lng',
            'text',
            [
                'name'     => 'lng',
                'label'    => __('Longitude'),
                'required' => true
            ]
        );

        $fieldset->addField(
            'zoom',
            'text',
            [
                'name'     => 'zoom',
                'label'    => __('Zoom'),
                'required' => true
            ]
        );
        $fieldset->addField(
            'store_search_by_address',
            'button',
            [
                'name' => 'store_search_by_address'
            ]
        );
        $fieldset->addField(
            'store_location',
            'google_map',
            [
                'name'  => 'store_location',
                'label' => __('Store Location'),
                'title' => __('Store Location')
            ]
        );

        $data = $model->getData();
        $form->setValues($data);
        $this->setForm($form);

        return parent::_prepareForm();
    }
}
