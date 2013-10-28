<?php

namespace INTI\RegistroAcademicoBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class NotaType extends AbstractType
{
	/**
	 * @param FormBuilderInterface $builder
	 * @param array $options
	 */
	public function buildForm(FormBuilderInterface $builder, array $options)
	{
            $builder
                ->add('valor',
                    'number',
                    array(
                        'label'     => null,
                        'precision' => 2,
                        'invalid_message' => 'Digite un número decimal valido',
                        'attr'  => array(
                            'min' => 0,
                            'max' => 10
                    )))
            ;
	}

	/**
	 * @param OptionsResolverInterface $resolver
	 */
	public function setDefaultOptions(OptionsResolverInterface $resolver)
	{
            $resolver->setDefaults(array(
                'data_class' => 'INTI\RegistroAcademicoBundle\Entity\Nota'
            ));
	}

	/**
	 * @return string
	 */
	public function getName()
	{
            return 'notatype';
	}
}
