<?php

namespace INTI\RegistroAcademicoBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class EmpleadoType extends AbstractType
{
    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('fotografia', 'hidden')
            ->add('nombres',
                'text',
                array(
                    'label' => 'Nombres'
                ))
            ->add('apellidos',
                'text',
                array(
                    'label' => 'Apellidos'
                ))
            ->add('sexo',
                'choice',
                array(
                    'label'   => 'Sexo',
                    'choices' => array(
                        'M'   => 'Masculino',
                        'F'   => 'Femenino'
                        )
                ))
            ->add('puesto',
                'choice',
                array(
                    'label'       => 'Puesto',
                    'choices'     => array(
                        'director'            => 'Director',
                        'subdirector'         => 'Subdirector',
                        'encargado_reg_acad'  => 'Encargado de registro academico',
                        'encargado_serv_soc'  => 'Encargado del servicio social',
                        'encargado_prac_prof' => 'Encargado de practica profesional',
                        'secretaria_reg_acad' => 'Secretaria de registro academico'
                        ),
                    'empty_value' => 'Asigne un puesto'
                ))
            ->add('dui',
                'text',
                array(
                    'label' => 'DUI',
                    'attr' => array(
                        'placeholder' => 'Por ejemplo: 12345678-9'
                )))
            ->add('isss',
                'text',
                array(
                    'label' => 'ISSS',
                'attr' => array(
                    'placeholder' => 'Por ejemplo: 123456789'
                )))
            ->add('nit',
                'text',
                array(
                    'label' => 'NIT',
                    'attr' => array(
                        'placeholder' => 'Por ejemplo: 1234-010190-123-6'
                )))
            ->add('nup',
                'text',
                array(
                    'label' => 'NUP',
                    'attr' => array(
                        'placeholder' => 'Por ejemplo: 1234123412341234'
                )))
            ->add('usuario', new UsuarioType());
    }

    /**
     * @param OptionsResolverInterface $resolver
     */
    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class'         => 'INTI\RegistroAcademicoBundle\Entity\Empleado',
            'cascade_validation' => true,
            'trim'               => true
        ));
    }

    /**
     * @return string
     */
    public function getName()
    {
        return 'empleadotype';
    }
}
