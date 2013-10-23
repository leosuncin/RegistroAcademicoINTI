<?php

namespace INTI\RegistroAcademicoBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class UsuarioType extends AbstractType
{
    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('username', 'text', array(
                'label' => 'Nombre de usuario', 
                'attr' => array(
                    'placeholder' => 'Por ejemplo: secretaria_direccion',
                    'help_block' => 'Escriba el nombre del usuario sin espacios'
                    )))
            ->add('password', 'password', array(
                'label' => 'Contraseña del usuario',
                'attr' => array(
                    'placeholder' => 'Escriba una contraseña segura',
                    'help_block' => 'Utilice mayusculas, minusculas, numeros y otros caracteres intercalados'
                    )))
            ->add('enabled', 'checkbox', array('label' => 'Habilitar el usuario'));
    }

    /**
     * @param OptionsResolverInterface $resolver
     */
    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'INTI\RegistroAcademicoBundle\Entity\Usuario'
        ));
    }

    /**
     * @return string
     */
    public function getName()
    {
        return 'usuariotype';
    }
}
