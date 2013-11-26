<?php

namespace INTI\RegistroAcademicoBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class CodigoEspecialidadType extends AbstractType
{
		/**
		 * @param FormBuilderInterface $builder
		 * @param array $options
		 */
		public function buildForm(FormBuilderInterface $builder, array $options)
		{
			$builder
				->add('especialidad',
					'entity',
					array(
						'label'    => 'Especialidad',
						'class'    => 'RegistroAcademicoBundle:Especialidad',
						'property' => 'nombre'
				))
				->add('anho',
						'number',
						array(
							'label'      => 'Año',
							'max_length' => 1
					))
				->add('seccion',
						'text',
						array(
							'label'      => 'Sección',
							'max_length' => 1
					))
				->add('codigo',
						'text',
						array(
							'label'      => 'Código',
							'max_length' => 5
					));
		}

		/**
		 * @param OptionsResolverInterface $resolver
		 */
		public function setDefaultOptions(OptionsResolverInterface $resolver)
		{
			$resolver->setDefaults(array(
				'data_class'         => 'INTI\RegistroAcademicoBundle\Entity\CodigoEspecialidad',
				'cascade_validation' => true
			));
		}

		/**
		 * @return string
		 */
		public function getName()
		{
			return 'codigoespecialidadtype';
		}
}
