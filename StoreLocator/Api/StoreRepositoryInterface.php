<?php
namespace Codilar\StoreLocator\Api;

use \Codilar\StoreLocator\Api\Data\StoreInterface;


interface StoreRepositoryInterface
{

    public function get($id);
    public function save(StoreInterface $model);
    public function delete(StoreInterface $model);
    public function deleteById($id);
}
