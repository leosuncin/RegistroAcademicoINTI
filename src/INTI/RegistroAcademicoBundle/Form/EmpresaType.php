<?php

namespace INTI\RegistroAcademicoBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class EmpresaType extends AbstractType
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
					'label'      => 'Nombre',
					'max_length' => 100
				))
			->add('contacto',
				'text',
				array(
					'label'      => 'Nombre del contacto',
					'max_length' => 80
				))
			->add('telefono', 'text', array(
				'label'      => 'Teléfono',
				'max_length' => 8,
				'attr'       => array(
					'placeholder' => 'Por ejemplo: 23253526'
				)))
			->add(
				'direccion',
				'textarea',
				array(
					'label' => 'Dirección'
				))
			->add(
				'email',
				'email',
				array(
					'label' => 'Dirección de correo',
					'max_length' => 40,
					'attr' => array(
						'placeholder' => 'Por ejemplo: nombre@empresa.com'
				)))
			;
	}

	/**
	 * @param OptionsResolverInterface $resolver
	 */
	public function setDefaultOptions(OptionsResolverInterface $resolver)
	{
		$resolver->setDefaults(array(
			'data_class' => 'INTI\RegistroAcademicoBundle\Entity\Empresa'
		));
	}

	/**
	 * @return string
	 */
	public function getName()
	{
		return 'empresatype';
	}
}
