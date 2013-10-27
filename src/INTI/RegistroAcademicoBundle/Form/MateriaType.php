<?php

namespace INTI\RegistroAcademicoBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;
use INTI\RegistroAcademicoBundle\Form\ProfesorType;

class MateriaType extends AbstractType
{
	/**
	 * @param FormBuilderInterface $builder
	 * @param array $options
	 */
	public function buildForm(FormBuilderInterface $builder, array $options)
	{
		$builder
			->add('nombre',
				'text',
				array(
					'label'      => 'Nombre de la materia',
					'max_length' => 60
				))
			->add('profesor',
				new ProfesorType(),
				array('label' => null)
			)
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
