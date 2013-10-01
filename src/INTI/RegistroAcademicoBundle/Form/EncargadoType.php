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
            ->add('nombre', 'text', array('label' => 'Nombre completo'))
            ->add('parentesco', 'text', array('label' => 'Parentesco'))
            ->add('dui', 'text', array('label' => 'DUI'))
            ->add('telefono', 'text', array('label' => 'Teléfono'));
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
