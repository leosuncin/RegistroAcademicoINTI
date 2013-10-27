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
				->add('codigo',
						'text',
						array(
							'label'      => 'Código',
							'max_length' => 5
					))
				->add('anho',
						'choice',
						array(
							'label'   => 'Año',
							'choices' => array(
								'1' => 'Primero',
								'2' => 'Segundo',
								'3' => 'Tercero',
								'4' => 'Cuarto'
					)))
				->add('seccion',
						'choice',
						array(
							'label'   => 'Sección',
							'choices' => array(
								'A' => 'Masculino',
								'B' => 'B',
								'C' => 'C',
								'D' => 'D',
								'E' => 'E'
					)))
				->add('especialidad',
						'entity',
            array(
              'label'    => 'Especialidad',
              'class'    => 'RegistroAcademicoBundle:Especialidad',
              'property' => 'nombre'
					));
		}

		/**
		 * @param OptionsResolverInterface $resolver
		 */
		public function setDefaultOptions(OptionsResolverInterface $resolver)
		{
			$resolver->setDefaults(array(
				'data_class'         => 'INTI\RegistroAcademicoBundle\Entity\CodigoEspecialdad',
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
