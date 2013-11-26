<?php

namespace INTI\RegistroAcademicoBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class PracticaProfesionalType extends AbstractType
{
		/**
	* @param FormBuilderInterface $builder
	* @param array $options
	*/
	public function buildForm(FormBuilderInterface $builder, array $options)
	{
		$builder
			->add('horario',
				'choice',
				array(
					'label'  => 'Horario',
					'choices' => array(
						'M'    => 'Matutino',
						'V'    => 'Vespertino'
				)))
			->add('inicio',
				'date',
				array(
					 'input'		  => 'datetime',	 
					'label'           => 'Fecha de inicio',
					'widget'          => 'single_text',
					'format'          => 'dd/MM/yyyy',
					'invalid_message' => 'La fecha debe tener mel formato dd/mm/yyyy',
					'attr'            => array(
					'placeholder'     => 'Por ejemplo: 17/10/1990',
<<<<<<< HEAD
						'class'            => 'date1',
=======
						'class'            => 'datepicker',
>>>>>>> acd3f7253eca0bccb2de9f319529bb496d61d83a
						'data-provide'     => 'datepicker',
						'data-date-format' => 'dd/mm//yyyy',
						'data-language'    => 'es'
				)))
			->add('fin',
				'date',
				array(
					'input'			  => 'datetime',		
					'label'           => 'Fecha en que finalizo',
					'widget'          => 'single_text',
					'format'          => 'dd/MM/yyyy',
					'invalid_message' => 'La fecha debe tener mel formato dd/mm/yyyy',
					'attr'            => array(
					'placeholder'     => 'Por ejemplo: 17/11/1990',
<<<<<<< HEAD
						'class'            => 'date2',
=======
						'class'            => 'datepicker',
>>>>>>> acd3f7253eca0bccb2de9f319529bb496d61d83a
						'required'         => false,
						'data-provide'     => 'datepicker',
						'data-date-format' => 'dd/mm//yyyy',
						'data-language'    => 'es'
				)))
			->add('evaluacion',
				'text',
				array(
					'label'           => 'Evaluación',
<<<<<<< HEAD

=======
>>>>>>> acd3f7253eca0bccb2de9f319529bb496d61d83a
					'read_only'       => true,
					'invalid_message' => 'Ingrese un numero decimal valido',
					'attr'			  =>	
					array(
						'placeholder' => 'por ejemplo: 10.00'
				)))

			->add('alumno','entity',
				array(
					'class'			=>	'RegistroAcademicoBundle:Alumno',
					'empty_value' 	=> 	'Escoja un alumno',
					'property'		=>	'nie',
					'label'			=>	'Alumno (NIE)',
					
					))
			->add('empresa','entity',
				array(
					'class'			=>	'RegistroAcademicoBundle:Empresa',
					'property'		=>	'nombre',
					'label'			=>	'Empresa'
					))
			;
	}

	/**
	* @param OptionsResolverInterface $resolver
	*/
	public function setDefaultOptions(OptionsResolverInterface $resolver)
	{
		$resolver->setDefaults(array(
			'data_class' => 'INTI\RegistroAcademicoBundle\Entity\PracticaProfesional'
		));
	}

	/**
	* @return string
	*/
	public function getName()
	{
		return 'practicaprofesionaltype';
	}
}
