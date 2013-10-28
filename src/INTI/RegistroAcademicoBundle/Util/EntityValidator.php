<?php

namespace INTI\RegistroAcademicoBundle\Util;

use Symfony\Component\Validator\ExecutionContextInterface;
use INTI\RegistroAcademicoBundle\Entity\Nota;

class EntityValidator
{
	public static function isNotaValida(Nota $nota, ExecutionContextInterface $context)
	{
		if($this->valor < 0.00)
            $context->addViolationAt('valor', '');
	}
}