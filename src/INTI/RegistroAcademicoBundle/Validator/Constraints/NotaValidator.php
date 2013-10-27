<?php

namespace INTI\RegistroAcademicoBundle\Validator\Constraints;

use Symfony\Component\Validator\Constraint;
use Symfony\Component\Validator\ConstraintValidator;

class NotaValidator extends ConstraintValidator
{
  public function validate($value, Constraint $constraint)
  {
    if($value < 0.00 || $value > 10.00)
      $this->context->addViolation($constraint->message, array('nota' => $value));
  }
}
