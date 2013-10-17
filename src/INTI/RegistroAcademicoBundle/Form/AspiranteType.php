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
                'entity',
                array(
                    'label'    => 'Especialidad',
                    'class'    => 'RegistroAcademicoBundle:Especialidad',
                    'property' => 'nombre'
                    )
            )
            ->add('direccion',
                'textarea',
                array(
                    'label' => 'Dirección'
                    )
            )
            ->add('telefono',
                'text',
                array(
                    'label' => 'Teléfono',
                    'attr' => array(
                        'placeholder' => 'Por ejemplo: 23253526'
                )))
            ->add('fechanac',
                'birthday',
                array(
                    'label'     => 'Fecha de nacimiento',
                    'widget'    => 'single_text',
                    'format' => 'dd/MM/yyyy',
                    'invalid_message' => 'La fecha debe tener el formato dd/mm/yyyy',
                    'attr'      => array(
                        'placeholder' => 'Por ejemplo: 17/10/1990',
                        'class' => 'date datepicker',
                        'data-date-format' => 'dd/mm//yyyy'
                )))
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
            ->add('encargado', new EncargadoType());
			->add('estado',
                'choice',
                array(
                    'label'   => 'Estado',
                    'choices' => array(
                        'P'   => 'Pendiente',
                        'A'   => 'Aprobado',
						'R'	  => 'Reprobado',
						'M'	  => 'Matriculado'
                        )
                    )
                )
    }

    /**
     * @param OptionsResolverInterface $resolver
     */
    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'INTI\RegistroAcademicoBundle\Entity\Aspirante',
            'cascade_validation' => true
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
