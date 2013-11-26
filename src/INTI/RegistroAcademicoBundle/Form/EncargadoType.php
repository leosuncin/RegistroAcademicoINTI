<?php

namespace INTI\RegistroAcademicoBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class EncargadoType extends AbstractType
{
	/**
	 * @param FormBuilderInterface $builder
	 * @param array $options
	 */
	public function buildForm(FormBuilderInterface $builder, array $options)
	{
		$builder
			->add('dui', 'text', array(
				'label'      => 'DUI',
				'max_length' => 10,
				'attr'       => array(
					'class'        => 'dui',
					'placeholder'  => 'Por ejemplo: 12345678-9',
					'data-provide' => 'typeahead'
				)))
			->add('nombre', 'text', array('label' => 'Nombre completo'))
			->add('parentesco', 'text', array('label' => 'Parentesco'))
			->add('telefono', 'text', array(
				'label'      => 'Teléfono',
				'max_length' => 8,
				'attr'       => array(
					'class'       => 'telefono',
					'placeholder' => 'Por ejemplo: 23253526'
				)));
	}

	/**
	 * @param OptionsResolverInterface $resolver
	 */
	public function setDefaultOptions(OptionsResolverInterface $resolver)
	{
		$resolver->setDefaults(array(
			'data_class' => 'INTI\RegistroAcademicoBundle\Entity\Encargado'
		));
	}

	/**
	 * @return string
	 */
	public function getName()
	{
		return 'encargadotype';
	}
}
