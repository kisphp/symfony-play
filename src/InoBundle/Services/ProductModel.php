<?php

namespace InoBundle\Services;

use InoBundle\Entity\Product;

class ProductModel extends AbstractModel
{
    const REPOSITORY = 'InoBundle:Product';

    /**
     * @return array
     */
    public function getAllProducts()
    {
        return $this->getRepository()
            ->findAll()
        ;
    }

    /**
     * @param int $id
     *
     * @return Product
     */
    public function getByIdOrEmpty($id)
    {
        $entity = $this->find($id);

        if (!$entity) {
            return new Product();
        }

        return $entity;
    }
}