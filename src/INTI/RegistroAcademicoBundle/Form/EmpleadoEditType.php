<?php

namespace INTI\RegistroAcademicoBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class EmpleadoEditType extends AbstractType
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
                    )
            )
            ->add('apellidos',
                'text',
                array(
                    'label' => 'Apellidos'
                    )
            )
            ->add('sexo',
                'choice',
                array(
                    'label'   => 'Sexo',
                    'choices' => array(
                        'M'   => 'Masculino',
                        'F'   => 'Femenino'
                        )
                    )
                )
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
                    )
            )
            ->add('dui',
                'text',
                array(
                    'label'     => 'DUI',
                    'read_only' => true
                    )
            )
            ->add('isss',
                'text',
                array(
                    'label' => 'ISSS'
                    )
            )
            ->add('nit',
                'text',
                array('label' => 'NIT')
                )
            ->add('nup', 'text', array('label' => 'NUP'));
    }

    /**
     * @param OptionsResolverInterface $resolver
     */
    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class'         => 'INTI\RegistroAcademicoBundle\Entity\Empleado',
            'trim'               => true
        ));
    }

    /**
     * @return string
     */
    public function getName()
    {
        return 'empleadoedittype';
    }
}
