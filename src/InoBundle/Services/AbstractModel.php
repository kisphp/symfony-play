<?php

namespace InoBundle\Services;

use Doctrine\ORM\EntityManager;

abstract class AbstractModel
{
    const REPOSITORY = 'overwrite this in your concrete class';

    /**
     * @var EntityManager
     */
    protected $em;

    /**
     * @param EntityManager $em
     */
    public function __construct(EntityManager $em)
    {
        $this->em = $em;
    }

    /**
     * @param $entity
     * @return mixed
     */
    public function save($entity)
    {
        $this->em->persist($entity);
        $this->em->flush();

        return $entity;
    }

    /**
     * @param $entity
     * @return bool
     */
    public function delete($entity)
    {
        $this->em->remove($entity);
        $this->em->flush();

        return true;
    }

    /**
     * @param int $id
     *
     * @return null|object
     */
    public function find($id)
    {
        return $this->getRepository()->find($id);
    }

    /**
     * @return \Doctrine\ORM\EntityRepository
     */
    protected function getRepository()
    {
        return $this->em->getRepository(static::REPOSITORY);
    }
}