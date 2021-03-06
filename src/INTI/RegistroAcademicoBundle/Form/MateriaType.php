<?php

namespace INTI\RegistroAcademicoBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class MateriaType extends AbstractType
{
	/**
	 * @param FormBuilderInterface $builder
	 * @param array $options
	 */
	public function buildForm(FormBuilderInterface $builder, array $options)
	{
		$builder
			->add('codigo',
				'text',
				array(
					'label'		 => 'Codigo de la materia en SIRAI',
					'max_length' => 5
				))
			->add('nombre',
				'text',
				array(
					'label'      => 'Nombre de la materia',
					'max_length' => 60
				))
			->add('profesor',
				'text',
                array(
                    'label'      => 'Profesor encargado',
                    'max_length' => 80
			))
		;
	}

	/**
	 * @param OptionsResolverInterface $resolver
	 */
	public function setDefaultOptions(OptionsResolverInterface $resolver)
	{
		$resolver->setDefaults(array(
			'data_class'         => 'INTI\RegistroAcademicoBundle\Entity\Materia',
			'cascade_validation' => true
		));
	}

	/**
	 * @return string
	 */
	public function getName()
	{
		return 'materiatype';
	}
}
