<?php
namespace Codilar\StoreLocator\Block;

use Codilar\StoreLocator\Helper\Config as ConfigHelper;
use Codilar\StoreLocator\Model\ResourceModel\Store\CollectionFactory as StoreCollectionFactory;
use Magento\Framework\Json\Helper\Data as DataHelper;

class LocationStoresList extends \Magento\Framework\View\Element\Template
{
    private StoreCollectionFactory $storeCollectionFactory;
    private $dataHelper;
    private ConfigHelper $configHelper;
    private \Magento\Framework\Json\EncoderInterface $_jsonEncoder;

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

    public function getStoreLocator()
    {
        $locations = $this->storeCollectionFactory->create();
        $locationsArray = [];
        foreach ($locations as $location) {
            if ($location->getIsActive() == 1) {
                $location->load($location->getId());
                $locationsArray[] = $location;
            }
        }

        return $locationsArray;
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
        $locations = $this->getStoreLocator();
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
        $url = $this->_storeManager->getStore()->getUrl('store-locator/store/view/');
        $baloon = 	'<h2><div class="locator-title"><a href="' . $url . 'key/{{store_id}}">{{name}}</a></div></h2>
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
        $store_url =  $store_url . 'Codilar/storeLocator/';

        $baloon = str_replace(
            '{{photo}}',
            '<img src="' . $store_url . '{{photo}}">',
            $baloon
        );

        return $this->_jsonEncoder->encode(["baloon" => $baloon]);
    }
}
