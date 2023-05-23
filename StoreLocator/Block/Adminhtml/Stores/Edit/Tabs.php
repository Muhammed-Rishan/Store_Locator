<?php
/**
 * Copyright © 2023 Codilar. All rights reserved.
 */

namespace Codilar\StoreLocator\Block\Adminhtml\Stores\Edit;

use Codilar\StoreLocator\Block\Adminhtml\Stores\Edit\Tab\Info;
use Codilar\StoreLocator\Block\Adminhtml\Stores\Edit\Tab\Map;
use Magento\Framework\Exception\LocalizedException;

class Tabs extends \Magento\Backend\Block\Widget\Tabs
{
    /**
     * {@inheritdoc}
     */
    protected function _construct()
    {
        parent::_construct();
        $this->setId('storelocator_stores_edit_tabs');
        $this->setDestElementId('edit_form');
        $this->setTitle(__('Store Edit'));
    }

    /**
     * {@inheritdoc}
     * @throws LocalizedException
     * @throws \Exception
     */
    protected function _beforeToHtml()
    {
        $this->addTab(
            'store_info',
            [
                'label' => __('General Informations'),
                'title' => __('General Informations'),
                'content' => $this->getLayout()->createBlock(
                    Info::class
                )->toHtml(),
                'active' => true
            ]
        );


        $this->addTab(
            'map_info',
            [
                'label' => __('Location Map'),
                'title' => __('Location Map'),
                'content' => $this->getLayout()->createBlock(
                    Map::class
                )->toHtml(),
                'active' => false
            ]
        );

        return parent::_beforeToHtml();
    }
}
