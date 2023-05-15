<?php
namespace Codilar\StoreLocator\Api\Data;

interface StoreInterface
{
    const NAME = 'name';
    const ADDRESS = 'address';

    const CITY = 'city';
    const STATE = 'state';

    const COUNTRY = 'country';

    const PHONE = 'phone';
    const EMAIL = 'email';

    const IS_ACTIVE = 'is_active';



    public function getId();
    public function getName();

    public function getAddress();

    public function getCity();

    public function getState();
    public function getCountry();

    public function getPhone();

    public function getEmail();

    public function isActive();


    public function setId($id);
    public function setName($name);

    public function setAddress($address);

    public function setCity($city);

    public function setState($state);
    public function setCountry($country);

    public function setPhone($phone);

    public function setEmail($email);

    public function setIsActive($isActive);

}
