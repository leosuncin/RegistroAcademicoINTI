<?php

namespace INTI\RegistroAcademicoBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class ServicioSocialType extends AbstractType
{
        /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('horasRealizadas')
            ->add('alumno','entity',array(
                    'class'         =>  'RegistroAcademicoBundle:Alumno',
                    'empty_value'   =>  'Escoja un alumno',
                    'property'      =>  'nie',
                    'label'         =>  'Alumno (NIE)',
                    
                    ));
    }
    
    /**
     * @param OptionsResolverInterface $resolver
     */
    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'INTI\RegistroAcademicoBundle\Entity\ServicioSocial'
        ));
    }

    /**
     * @return string
     */
    public function getName()
    {
        return 'serviciosocialtype';
    }
}
