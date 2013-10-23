<?php

namespace INTI\RegistroAcademicoBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class EspecialidadType extends AbstractType
{
    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
			->add('codigo','text',array(
				'label'=>'Codigo',
				'attr' => array(
					'data-toggle'=> 'tooltip',
					'title'=>'Escriba bien el codigo')
			))
            ->add('nombre','text',array('label'=>'Nombre',
				'attr' => array(
					'data-toggle'=> 'tooltip',
					'title'=>'Escriba bien el nombre')));
			

    }

    /**
     * @param OptionsResolverInterface $resolver
     */
    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'INTI\RegistroAcademicoBundle\Entity\Especialidad'
        ));
    }

    /**
     * @return string
     */
    public function getName()
    {
        return 'especialidadtype';
    }
}
