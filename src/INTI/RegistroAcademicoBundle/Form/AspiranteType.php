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
			->add('primerApellido',
				'text',
				array(
					'label'      => 'Primer apellido',
					'max_length' => 15
				))
			->add('segundoApellido',
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
					'label'       => 'Especialidad',
					'empty_value' => 'Escoja una especialidad',
					'class'       => 'RegistroAcademicoBundle:Especialidad',
					'property'    => 'nombre'
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
                        'class'       => 'telefono',
						'placeholder' => 'Por ejemplo: 23253526'
			)))
			->add('fechaNac',
				'birthday',
				array(
					'label'           => 'Fecha de nacimiento',
					'widget'          => 'single_text',
					'format'          => 'dd/MM/yyyy',
					'invalid_message' => 'La fecha debe tener el formato dd/mm/yyyy',
					'attr'            => array(
						'placeholder'      => 'Por ejemplo: 17/10/1990',
						'class'            => 'datepicker',
						'data-provide'     => 'datepicker',
						'data-date-format' => 'dd/mm/yyyy',
						'data-viewmode'    => 'years',
						'data-language'    => 'es'
			)))
			->add('lugarNac',
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
			->add('encargado', new EncargadoType(), array('label' => false));
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
