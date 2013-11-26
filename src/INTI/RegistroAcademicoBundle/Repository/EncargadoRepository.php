<?php

namespace INTI\RegistroAcademicoBundle\Repository;

use Doctrine\ORM\EntityRepository;

/**
 * EncargadoRepository
 *
 * This class was generated by the Doctrine ORM. Add your own custom
 * repository methods below.
 */
class EncargadoRepository extends EntityRepository {

    /**
     * Buscar numeros de DUI que empiecen por el parametro
     * 
     * @param string $dui
     * @return array
     */
    public function findDUI($dui) {
        $query = $this->getEntityManager()
                ->createQuery('SELECT e.dui FROM RegistroAcademicoBundle:Encargado e WHERE e.dui LIKE :dui')
                ->setParameter(':dui', $dui . '%');
        return $query->getArrayResult();
    }

    /**
     * Busca todos los DUI de los encargados
     * 
     * @return array
     */
    public function findAllDUI() {
        return $this->getEntityManager()
                ->createQuery('SELECT e.dui FROM RegistroAcademicoBundle:Encargado e')
                ->getArrayResult();
    }
}