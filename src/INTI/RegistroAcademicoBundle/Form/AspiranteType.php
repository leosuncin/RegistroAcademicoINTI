<?php

namespace INTI\RegistroAcademicoBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class AspiranteType extends AbstractType
{
    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('foto', 'hidden')
            ->add('primerapellido',
                'text',
                array(
                    'label' => 'Primer apellido'
                    )
            )
            ->add('segundoapellido',
                'text',
                array(
                    'label' => 'Segundo apellido'
                    )
            )
            ->add('nombres',
                'text',
                array(
                    'label' => 'Nombres'
                    )
            )
            ->add('especialidad',
                'choice',
                array(
                    'label'       => 'Especialidad',
                    'choices'     => array(
                        'ELT'     => 'Electrotecnia',
                        'ELCA'    => 'Electrónica',
                        'AUTO'    => 'Automotores',
                        'MECA'    => 'Mecánica general',
                        'DS'      => 'Desarrollo de software',
                        'COMP'    => 'Mantenimiento de computadora'
                        ),
                    'empty_value' => 'Escoja una especialidad'
                    )
            )
            ->add('direccion',
                'textarea',
                array(
                    'label' => 'Dirección'
                    )
            )
            ->add('telefono',
                'number',
                array('label' => 'Teléfono')
                )
            ->add('fechanac', 
                'birthday',
                array(
                    'label'     => 'Fecha de nacimiento',
                    'attr'      => array(
                        'class' => 'controls-row input-mini'
                        )
                    )
                )
            ->add('lugarnac', 'text', array('label' => 'Lugar de nacimiento'))
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
            ->add('encargado',
                'entity',
                array(
                    'class'    => 'RegistroAcademicoBundle:Encargado',
                    'property' => 'nombre'
                    )
                );
    }

    /**
     * @param OptionsResolverInterface $resolver
     */
    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'INTI\RegistroAcademicoBundle\Entity\Aspirante'
        ));
    }

    /**
     * @return string
     */
    public function getName()
    {
        return 'aspirantetype';
    }
}