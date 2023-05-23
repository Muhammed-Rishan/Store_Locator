<?php
/**
 * Copyright © 2019 Codilar. All rights reserved.
 */

namespace Codilar\StoreLocator\Block\Store;

use Codilar\StoreLocator\Helper\Config as ConfigHelper;
use Codilar\StoreLocator\Model\ResourceModel\Store\CollectionFactory as StoreCollectionFactory;
use Magento\Framework\Json\Helper\Data as DataHelper;

class LocationStoresView extends \Magento\Framework\View\Element\Template
{
    private $storeCollectionFactory;
    private $dataHelper;
    private $configHelper;
    private $_jsonEncoder;

    public function __construct(
        \Magento\Framework\View\Element\Template\Context $context,
        \Magento\Framework\Json\EncoderInterface $jsonEncoder,
        StoreCollectionFactory $storeCollectionFactory,
        DataHelper $dataHelper,
        ConfigHelper $configHelper,
        array $data = []
    ) {
        $this->storeCollectionFactory = $storeCollectionFactory;
        $this->dataHelper = $dataHelper;
        $this->_jsonEncoder = $jsonEncoder;
        $this->configHelper = $configHelper;
        parent::__construct($context, $data);
    }

    public function getStoreViewLocator()
    {
        $objectManager = \Magento\Framework\App\ObjectManager::getInstance();
        $req = $objectManager->get('Magento\Framework\App\Request\Http');
        $id = $req->getParam('key');
        $model = $objectManager->create('Codilar\StoreLocator\Model\Store');
        $locations = $model->load($id);
        return $locations;
    }

    public function getApiKey()
    {
        $googleApiKey = $this->configHelper->getGoogleApiKeyFrontend();
        return $googleApiKey;
    }
    public function getString()
    {
        return '?' . http_build_query($this->getRequest()->getParams());
    }
    public function getJsonLocations()
    {
        $objectManager = \Magento\Framework\App\ObjectManager::getInstance();
        $req = $objectManager->get('Magento\Framework\App\Request\Http');
        $id = $req->getParam('key');
        $locations_model = $this->storeCollectionFactory->create();
        $locationsArray = [];
        foreach ($locations_model as $location) {
            if ($location->getId() == $id) {
                $location->load($location->getId());
                $locationsArray[] = $location;
            }
        }
        $locations = $locationsArray;
        $locationArray = [];
        $locationArray['items'] = [];
        foreach ($locations as $location) {
            $locationArray['items'][] = $location->getData();
        }
        $locationArray['totalRecords'] = count($locationArray['items']);
        $store = $this->_storeManager->getStore(true)->getId();
        $locationArray['currentStoreId'] = $store;

        return $this->_jsonEncoder->encode($locationArray);
    }
    public function getBaloonTemplate()
    {
        $mediaUrl = $this->_storeManager->getStore()->getBaseUrl(\Magento\Framework\UrlInterface::URL_TYPE_MEDIA);
        $baloon = '<h2><div class="locator-title">{{name}}</div></h2>
                    <div class="store">
						<div class="image">
							<img src="' . $mediaUrl . '{{image_store}}" />
						</div>
						<div class="info">
							<p>City: {{city}}</p>
							<p>Zip: {{zip}}</p>
							<p>Country: {{country}}</p>
							<p>Address: {{address}}</p>
						</div>
					</div>
					<div>
						Description: {{des}}
					</div>
					';

        $store_url = $this->_storeManager->getStore()->getBaseUrl(\Magento\Framework\UrlInterface::URL_TYPE_MEDIA);
        $store_url =  $store_url . 'codilar/storeLocator/';

        $baloon = str_replace(
            '{{photo}}',
            '<img src="' . $store_url . '{{photo}}">',
            $baloon
        );

        return $this->_jsonEncoder->encode(["baloon" => $baloon]);
    }
}
