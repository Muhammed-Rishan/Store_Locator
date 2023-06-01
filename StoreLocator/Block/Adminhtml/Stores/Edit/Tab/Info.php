<?php
namespace Codilar\StoreLocator\Block\Adminhtml\Stores\Edit\Tab;

use Codilar\StoreLocator\Model\Config\Source\Country;
use Codilar\StoreLocator\Model\System\Config\IsActive;
use Magento\Backend\Block\Template\Context;
use Magento\Backend\Block\Widget\Form\Generic;
use Magento\Framework\Data\FormFactory;
use Magento\Framework\Registry;

class Info extends Generic
{
    /**
     * @var IsActive
     */
    private IsActive $isActive;

    /**
     * @var Country
     */
    private Country $country;

    public function __construct(
        Context $context,
        Registry $registry,
        FormFactory $formFactory,
        IsActive $isActive,
        Country $country,
        array $data = []
    ) {
        $this->isActive = $isActive;
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
    protected function _prepareForm()
    {
        $model = $this->_coreRegistry->registry('storelocator_store');

        $form = $this->_formFactory->create();

        $fieldset = $form->addFieldset(
            'base_fieldset',
            ['legend' => __('Informations')]
        );

        if ($model->getId()) {
            $selectField = $fieldset->addField(
                'store_id',
                'hidden',
                ['name' => 'store_id']
            );
        }

        $fieldset->addField(
            'name',
            'text',
            [
                'name'     => 'name',
                'label'    => __('Name'),
                'required' => true
            ]
        );
        $fieldset->addField(
            'des',
            'textarea',
            [
                'name'     => 'des',
                'label'    => __('Description'),
                'required' => false
            ]
        );

        $fieldset->addField(
            'is_active',
            'select',
            [
                'label'   => __('Status'),
                'title'   => __('Status'),
                'name'    => 'is_active',
                'options' => $this->isActive->toOptionArray()
            ]
        );

        $fieldset = $form->addFieldset(
            'address_fieldset',
            ['legend' => __('Address')]
        );

        $fieldset->addField(
            'address',
            'text',
            [
                'name'     => 'address',
                'label'    => __('Address'),
                'required' => true
            ]
        );

        $fieldset->addField(
            'city',
            'text',
            [
                'name'     => 'city',
                'label'    => __('City'),
                'required' => false
            ]
        );

        $fieldset->addField(
            'state',
            'text',
            [
                'name'     => 'state',
                'label'    => __('State'),
                'required' => false
            ]
        );

        $fieldset->addField(
            'postcode',
            'text',
            [
                'name'     => 'postcode',
                'label'    => __('Zip Code'),
                'required' => true
            ]
        );

        $fieldset->addField(
            'country',
            'select',
            [
                'name'     => 'country',
                'label'    => __('Country'),
                'options'  => $this->country->toOptionArray(),
                'required' => true
            ]
        );

        $fieldset->addField(
            'email',
            'text',
            [
                'name'     => 'email',
                'label'    => __('E-mail'),
                'required' => false
            ]
        );

        $fieldset->addField(
            'phone',
            'text',
            [
                'name'     => 'phone',
                'label'    => __('Phone Number'),
                'required' => false
            ]
        );

        $fieldset->addField(
            'fax',
            'text',
            [
                'name'     => 'fax',
                'label'    => __('Fax'),
                'required' => false
            ]
        );

        $fieldset->addField(
            'website',
            'text',
            [
                'name'     => 'website',
                'label'    => __('Website'),
                'required' => false
            ]
        );

        $fieldset = $form->addFieldset(
            'image_fieldset',
            ['legend' => __('Store Image')]
        );

        $data = $model->getData();

        $after_element_html = '';
        if (isset($data['image_store'])) {
            $objectManager = \Magento\Framework\App\ObjectManager::getInstance();
            $storeManager = $objectManager->
            get('Magento\Store\Model\StoreManagerInterface');
            $currentStore = $storeManager->getStore();
            $mediaUrl = $currentStore->
            getBaseUrl(\Magento\Framework\UrlInterface::URL_TYPE_MEDIA);
            $image = json_decode($data['image_store']);
            if ($image) {
                $after_element_html = '<div style="margin-top:15px;">
                <a href="' . $mediaUrl . $image . '" target="_blank">
                <image src="' . $mediaUrl . $image . '" style="max-width:250px;" />
                </a><div>';
            }
        }
        $fieldset->addField(
            'image_stored',
            'file',
            [
                'name' => 'image_stored',
                'label' => __('Store Image'),
                'title' => __('Store Image'),
                'note' => 'Allow image type: jpg, jpeg, gif, png',
                'after_element_html' => $after_element_html
            ]
        );

        if (!$model->getId()) {
            $model->setData('is_active', '1');
        }

        $form->setValues($data);
        $this->setForm($form);

        return parent::_prepareForm();
    }
}
