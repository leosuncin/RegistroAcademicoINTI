<?php

namespace INTI\RegistroAcademicoBundle\Form\DataTransform;

use Symfony\Component\Form\DataTransformerInterface;
use Symfony\Component\Form\Exception\TransformationFailedException;
use Doctrine\Common\Persistence\ObjectManager;
use INTI\RegistroAcademicoBundle\Entity\Alumno;

class AlumnoToTextTransformer implements DataTransformerInterface
{
	/**
     * @var ObjectManager
     */
    private $om;

    /**
     * @param ObjectManager $om
     */
    public function __construct(ObjectManager $om)
    {
        $this->om = $om;
    }

    /**
     * Transforms an object (alumno) to a string (nie).
     *
     * @param  Alumno|null $alumno
     * @return string
     */
    public function transform($alumno)
    {
        if (null === $alumno) {
            return "";
        }

        return $alumno->getNie();
    }

    /**
     * Transforms a string (nie) to an object (alumno).
     *
     * @param  string $nie
     *
     * @return Alumno|null
     *
     * @throws TransformationFailedException if object (alumno) is not found.
     */
    public function reverseTransform($nie)
    {
        if (!$nie) {
            return null;
        }

        $alumno = $this->om
            ->getRepository('RegistroAcademicoBundle:Alumno')
            ->findOneBy(array('nie' => $nie))
        ;

        if (null === $alumno) {
            throw new TransformationFailedException(sprintf('An alumno with nie "%s" does not exist!', $nie));
        }

        return $alumno;
    }
}