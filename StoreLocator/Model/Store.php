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
     * {@inheritdoc}
     */
    public function getIdentities()
    {
        return [self::CACHE_TAG . '_' . $this->getId()];
    }

    /**
     * {@inheritdoc}
     */
    public function getName()
    {
        return $this->getData(self::NAME);
    }

    /**
     * {@inheritdoc}
     */
    public function getAddress()
    {
        return $this->getData(self::ADDRESS);
    }

    /**
     * {@inheritdoc}
     */
    public function getCity()
    {
        return $this->getData(self::CITY);
    }

    /**
     * {@inheritdoc}
     */
    public function getState()
    {
        return $this->getData(self::STATE);
    }

    /**
     * {@inheritdoc}
     */
    public function getCountry()
    {
        $country = $this->countryFactory->create()->load($this->getData(self::COUNTRY));
        return $country->getName();
    }

    /**
     * {@inheritdoc}
     */
    public function getPhone()
    {
        return $this->getData(self::PHONE);
    }

    /**
     * {@inheritdoc}
     */
    public function getEmail()
    {
        return $this->getData(self::EMAIL);
    }

    /**
     * {@inheritdoc}
     */
    public function isActive()
    {
        return $this->getData(self::IS_ACTIVE);
    }

    /**
     * {@inheritdoc}
     */
    public function getCategoryName()
    {
        $category = $this->categoryRepository->get($this->getData('category_id'));
        return $category->getName();
    }

    /**
     * {@inheritdoc}
     */
    public function setName($name)
    {
        $this->setData(self::NAME, $name);
    }

    /**
     * {@inheritdoc}
     */
    public function setAddress($address)
    {
        $this->setData(self::ADDRESS, $address);
    }

    /**
     * {@inheritdoc}
     */
    public function setCity($city)
    {
        $this->setData(self::CITY, $city);
    }

    /**
     * {@inheritdoc}
     */
    public function setState($state)
    {
        $this->setData(self::STATE, $state);
    }

    /**
     * {@inheritdoc}
     */
    public function setCountry($country)
    {
        $this->setData(self::COUNTRY, $country);
    }

    /**
     * {@inheritdoc}
     */
    public function setPhone($phone)
    {
        $this->setData(self::PHONE, $phone);
    }

    /**
     * {@inheritdoc}
     */
    public function setEmail($email)
    {
        $this->setData(self::EMAIL, $email);
    }
    /**
     * {@inheritdoc}
     */
    public function setIsActive($isActive)
    {
        $this->setData(self::IS_ACTIVE, $isActive);
    }
}


