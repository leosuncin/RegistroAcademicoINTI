<?php

namespace INTI\RegistroAcademicoBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;
use INTI\RegistroAcademicoBundle\Form\EncargadoType;

class AspiranteType extends AbstractType
{
	/**
	 * @param FormBuilderInterface $builder
	 * @param array $options
	 */
	public function buildForm(FormBuilderInterface $builder, array $options)
	{
		$builder
			->add('foto', 'hidden')
			->add('primerapellido',
				'text',
				array(
					'label'      => 'Primer apellido',
					'max_length' => 15
				))
			->add('segundoapellido',
				'text',
				array(
					'label'      => 'Segundo apellido',
					'max_length' => 15
			))
			->add('nombres',
				'text',
				array(
					'label'      => 'Nombres',
					'max_length' => 50
			))
			->add('especialidad',
				'entity',
				array(
					'label'    => 'Especialidad',
					'class'    => 'RegistroAcademicoBundle:Especialidad',
					'property' => 'nombre'
			))
			->add('direccion',
				'textarea',
				array(
					'label'      => 'Dirección',
					'max_length' => 100
			))
			->add('telefono',
				'text',
				array(
					'label'      => 'Teléfono',
					'max_length' => 8,
					'attr'       => array(
						'placeholder' => 'Por ejemplo: 23253526'
			)))
			->add('fechanac',
				'birthday',
				array(
					'label'     => 'Fecha de nacimiento',
					'widget'    => 'single_text',
					'format' => 'dd/MM/yyyy',
					'invalid_message' => 'La fecha debe tener el formato dd/mm/yyyy',
					'attr'      => array(
						'placeholder' => 'Por ejemplo: 17/10/1990',
						'class' => 'date',
						'data-provide' => 'datepicker',
						'data-date-format' => 'dd/mm/yyyy',
						'data-viewmode' => 'years',
						'data-language' => 'es'
			)))
			->add('lugarnac',
				'text',
				array(
					'label'      => 'Lugar de nacimiento',
					'max_length' => 40
				))
			->add('sexo',
				'choice',
				array(
					'label'   => 'Sexo',
					'choices' => array(
						'M' => 'Masculino',
						'F' => 'Femenino'
				)))
			->add('estado',
					'choice',
					array(
						'label'   => 'Estado de la aplicación',
						'choices' => array(
							'P' => 'Pendiente',
							'A' => 'Aprobado',
							'R' => 'Reprobado',
							'M' => 'Matriculado'
				)))
			->add('encargado', new EncargadoType());
	}

	/**
	 * @param OptionsResolverInterface $resolver
	 */
	public function setDefaultOptions(OptionsResolverInterface $resolver)
	{
		$resolver->setDefaults(array(
			'data_class' => 'INTI\RegistroAcademicoBundle\Entity\Aspirante',
			'cascade_validation' => true
		));
	}

	/**
	 * @return string
	 */
	public function getName()
	{
		return 'aspirantetype';
	}
}
