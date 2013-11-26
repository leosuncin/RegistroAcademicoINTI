<?php

namespace INTI\RegistroAcademicoBundle\Repository;

use Doctrine\ORM\EntityRepository;
use INTI\RegistroAcademicoBundle\Entity\Usuario;

/**
 * Description of EmpleadoRepository
 *
 * @author infocentro
 */
class EmpleadoRepository extends EntityRepository {

    /**
     * 
     * @param \INTI\RegistroAcademicoBundle\Entity\Usuario $usuario
     * @return \INTI\RegistroAcademicoBundle\Entity\Empleado
     */
    public function findByUsuario(Usuario $usuario) {
        $query = $this
                ->getEntityManager()
                ->createQuery('SELECT e FROM RegistroAcademicoBundle:Empleado e WHERE e.usuario = :usuario')
                ->setParameter(':usuario', $usuario->getUsername());
        return $query->getResult();
    }

}
