<?php

namespace INTI\RegistroAcademicoBundle\Validator\Constraints;

use Symfony\Component\Validator\Constraint;

/**
 * @Annotation
 */
class Nota extends Constraint
{

	public $message = 'La nota "nota" no es valida';
}
