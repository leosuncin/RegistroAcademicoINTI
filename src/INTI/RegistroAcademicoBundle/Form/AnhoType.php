<?php

namespace INTI\RegistroAcademicoBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class AnhoType extends AbstractType
{
	/**
	 * @param FormBuilderInterface $builder
	 * @param array $options
	 */
	public function buildForm(FormBuilderInterface $builder, array $options)
	{
		$builder
			->add('anho',
				'integer',
				array(
					'label' => 'Año corriente'
				))
			->add(
			)
			->add('inicio',
				'date',
				array(
					'label'           => 'Fecha de inicio',
					'widget'          => 'single_text',
					'format'          => 'dd/MM/yyyy',
					'invalid_message' => 'La fecha debe tener mel formato dd/mm/yyyy',
					'attr'            => array(
						'placeholder'      => 'Por ejemplo: 02/02/2010',
						'class'            => 'date',
						'data-provide'     => 'datepicker',
						'data-date-format' => 'dd/mm/yyyy',
						'data-language'    => 'es'
			)))
			->add(
				'fin',
				'date',
				array(
					'label'           => 'Fecha de cierre',
					'widget'          => 'single_text',
					'format'          => 'dd/MM/yyyy',
					'invalid_message' => 'La fecha debe tener mel formato dd/mm/yyyy',
					'attr'            => array(
					'placeholder'          => 'Por ejemplo: 17/11/1990',
						'class'            => 'date',
						'required'         => false,
						'data-provide'     => 'datepicker',
						'data-date-format' => 'dd/mm/yyyy',
						'data-language'    => 'es'
			)));
	}

	/**
	* @param OptionsResolverInterface $resolver
	*/
	public function setDefaultOptions(OptionsResolverInterface $resolver)
	{
		$resolver->setDefaults(array(
			'data_class' => 'INTI\RegistroAcademicoBundle\Entity\Anho'
		));
	}

	/**
	* @return string
	*/
	public function getName()
	{
		return 'anhotype';
	}
}
