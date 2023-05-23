<?php
namespace Codilar\StoreLocator\Model;

use Codilar\StoreLocator\Api\Data\StoreInterface;
use Codilar\StoreLocator\Model\ResourceModel\Store as ResourceModel;
use Magento\Directory\Model\CountryFactory;
use Magento\Framework\Data\Collection\AbstractDb;
use Magento\Framework\DataObject\IdentityInterface;
use Magento\Framework\Model\AbstractModel;
use Magento\Framework\Model\Context;
use Magento\Framework\Model\ResourceModel\AbstractResource;
use Magento\Framework\Registry;

class Store extends AbstractModel implements StoreInterface, IdentityInterface
{
    const TYPE_DEALER = 1;
    const TYPE_SUBSIDIARY = 2;

    const STATUS_ACTIVE = 1;
    const STATUS_INACTIVE = 0;

    const CACHE_TAG = 'storelocator_store';

    private $countryFactory;

    public function __construct(
        Context          $context,
        Registry         $registry,
        CountryFactory   $countryFactory,
        AbstractResource $resource = null,
        AbstractDb       $resourceCollection = null,
        array            $data = []
    ) {
        $this->countryFactory = $countryFactory;
        $this->_cacheTag = 'storelocator_store';
        $this->_eventPrefix = 'storelocator_store';
        parent::__construct($context, $registry, $resource, $resourceCollection, $data);
    }

    protected function _construct()
    {
        $this->_init(ResourceModel::class);
    }

    /**
     *
     */
    public function getIdentities()
    {
        return [self::CACHE_TAG . '_' . $this->getId()];
    }

    /**
     *
     */
    public function getName()
    {
        return $this->getData(self::NAME);
    }

    /**
     *
     */
    public function getAddress()
    {
        return $this->getData(self::ADDRESS);
    }

    /**
     *
     */
    public function getCity()
    {
        return $this->getData(self::CITY);
    }

    /**
     *
     */
    public function getState()
    {
        return $this->getData(self::STATE);
    }

    /**
     *
     */
    public function getCountry()
    {
        $country = $this->countryFactory->create()->load($this->getData(self::COUNTRY));
        return $country->getName();
    }

    /**
     *
     */
    public function getPhone()
    {
        return $this->getData(self::PHONE);
    }

    /**
     *
     */
    public function getEmail()
    {
        return $this->getData(self::EMAIL);
    }

    /**
     *
     */
    public function isActive()
    {
        return $this->getData(self::IS_ACTIVE);
    }

    /**
     *
     */
    public function getCategoryName()
    {
        $category = $this->categoryRepository->get($this->getData('category_id'));
        return $category->getName();
    }

    /**
     *
     */
    public function setName($name)
    {
        $this->setData(self::NAME, $name);
    }

    /**
     *
     */
    public function setAddress($address)
    {
        $this->setData(self::ADDRESS, $address);
    }

    /**
     *
     */
    public function setCity($city)
    {
        $this->setData(self::CITY, $city);
    }

    /**
     *
     */
    public function setState($state)
    {
        $this->setData(self::STATE, $state);
    }

    /**
     *
     */
    public function setCountry($country)
    {
        $this->setData(self::COUNTRY, $country);
    }

    /**
     *
     */
    public function setPhone($phone)
    {
        $this->setData(self::PHONE, $phone);
    }

    /**
     *
     */
    public function setEmail($email)
    {
        $this->setData(self::EMAIL, $email);
    }
    /**
     *
     */
    public function setIsActive($isActive)
    {
        $this->setData(self::IS_ACTIVE, $isActive);
    }
}
