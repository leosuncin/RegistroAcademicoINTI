<?php

namespace INTI\RegistroAcademicoBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;
use INTI\RegistroAcademicoBundle\Form\DataTransform\AlumnoToTextTransformer;

class PracticaProfesionalType extends AbstractType
{
		/**
	* @param FormBuilderInterface $builder
	* @param array $options
	*/
	public function buildForm(FormBuilderInterface $builder, array $options)
	{
		$entityManager = $options['em'];
		$transformer = new AlumnoToTextTransformer($entityManager);
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
					'label'           => 'Fecha de inicio',
					'widget'          => 'single_text',
					'format'          => 'dd/MM/yyyy',
					'invalid_message' => 'La fecha debe tener mel formato dd/mm/yyyy',
					'attr'            => array(
					'placeholder'     => 'Por ejemplo: 17/10/1990',
						'class'            => 'datepicker',
						'data-provide'     => 'datepicker',
						'data-date-format' => 'dd/mm/yyyy',
						'data-language'    => 'es'
				)))
			->add('fin',
				'date',
				array(
					'label'           => 'Fecha en que finalizo',
					'widget'          => 'single_text',
					'format'          => 'dd/MM/yyyy',
					'invalid_message' => 'La fecha debe tener mel formato dd/mm/yyyy',
					'attr'            => array(
					'placeholder'     => 'Por ejemplo: 17/11/1990',
						'class'            => 'datepicker',
						'required'         => false,
						'data-provide'     => 'datepicker',
						'data-date-format' => 'dd/mm/yyyy',
						'data-language'    => 'es'
				)))
			->add('evaluacion',
				'text',
				array(
					'label'           => 'Evaluación',
					'read_only'       => true,
					'invalid_message' => 'Ingrese un numero decimal valido',
					'attr'			  => array(
						'placeholder' => 'por ejemplo: 10.00'
				)))

			->add($builder
				->create('alumno', 'text', array('label' => 'Alumno (NIE)'))
                ->addModelTransformer($transformer))
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
		$resolver->setRequired(array(
            'em',
        ));
        $resolver->setAllowedTypes(array(
            'em' => 'Doctrine\Common\Persistence\ObjectManager',
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
