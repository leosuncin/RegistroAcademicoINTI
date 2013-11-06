<?php

namespace INTI\RegistroAcademicoBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;
use INTI\RegistroAcademicoBundle\Form\AspiranteType;
use INTI\RegistroAcademicoBundle\Form\CodigoEspecialidadType;

class AlumnoType extends AbstractType
{
	/**
	 * @param FormBuilderInterface $builder
	 * @param array $options
	 */
	public function buildForm(FormBuilderInterface $builder, array $options)
	{
		$builder
			->add('condicion',
				'choice',
				array(
					'label'   => 'Condición de ingreso',
					'choices' => array(
						'CC' => 'Condicionado Conducta',
						'CM' => 'Condicionado Materia',
						'R'  => 'Repetidor',
						'RI' => 'Reingreso',
						'NI' => 'Nuevo Ingreso'
				)))
			->add('nie',
				new AspiranteType(),
				array(
					'label' => false
				))
		->add('codigoEspecialidad',
			'entity',
			array(
				'label'    => 'Código de especialidad',
				'class'    => 'RegistroAcademicoBundle:CodigoEspecialidad',
				'property' => 'codigo'
			));
	}

	/**
	* @param OptionsResolverInterface $resolver
	*/
	public function setDefaultOptions(OptionsResolverInterface $resolver)
	{
		$resolver->setDefaults(array(
				'data_class' => 'INTI\RegistroAcademicoBundle\Entity\Alumno',
				'cascade_validation' => true
		));
	}

	/**
	* @return string
	*/
	public function getName()
	{
		return 'alumnotype';
	}
}
