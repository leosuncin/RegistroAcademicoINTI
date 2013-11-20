<?php

namespace INTI\RegistroAcademicoBundle\Entity\Repository;

use Doctrine\ORM\EntityRepository;
use INTI\RegistroAcademicoBundle\Entity\Especialidad;
use INTI\RegistroAcademicoBundle\Entity\Empleado;

/**
 * AspiranteRepository
 *
 * This class was generated by the Doctrine ORM. Add your own custom
 * repository methods below.
 */
class AspiranteRepository extends EntityRepository {

    /**
     * Buscar aspirantes por apellido
     * 
     * @param string $apellido
     * @return \INTI\RegistroAcademicoBundle\Entity\Aspirante
     */
    public function findByApellidos($apellido) {
        $query = $this->getEntityManager()
                ->createQuery("SELECT ap FROM RegistroAcademicoBundle:Aspirante ap WHERE ap.primerApellido LIKE :apellido OR ap.segundoApellido LIKE :apellido")
                ->setParameter(':apellido', $apellido);
        return $query->getResult();
    }

    /**
     * Buscar aspirantes por especialidad
     * 
     * @param \INTI\RegistroAcademicoBundle\Entity\Especialidad $especialidad
     * @return \INTI\RegistroAcademicoBundle\Entity\Aspirante
     */
    public function findByEspecialidad(Especialidad $especialidad) {
        $query = $this->getEntityManager()
                ->createQuery("SELECT ap "
                        . "FROM RegistroAcademicoBundle:Aspirante ap "
                        . "WHERE ap.especialidad = :especialidad")
                ->setParameter(':especialidad', $especialidad->getCodigo());
        return $query->getResult();
    }

    /**
     * Buscar aspirantes que esten bajo la responsabilidad del empleado
     * 
     * @param \INTI\RegistroAcademicoBundle\Entity\Empleado $empleado
     * @return \INTI\RegistroAcademicoBundle\Entity\Aspirante
     */
    public function findByResponsable(Empleado $empleado) {
        if ($empleado->getPuesto() == 'secretaria_reg_acad') {
            $query = $this->getEntityManager()
                    ->createQuery("SELECT ap "
                            . "FROM RegistroAcademicoBundle:Aspirante ap WHERE ap.especialidad IN "
                            . "(SELECT emp.responsabilidad FROM RegistroAcademicoBundle:Empleado emp "
                            . "WHERE emp.dui = :dui)")
                    ->setParameter(':dui', $empleado->getDui());
            return $query->getResult();
        } else {
            return $this->findAll();
        }
    }

}
