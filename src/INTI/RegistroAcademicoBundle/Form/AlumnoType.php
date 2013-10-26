<?php

namespace INTI\RegistroAcademicoBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class AlumnoType extends AbstractType
{
    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('nie',
                'text',
                array(
                    'label' => 'NIE'
                    )
            )
			->add('condicion',
				'choice',
                array(
                    'label'   => 'Condicion de Ingreso',
                    'choices' => array(
                        'CC'   => 'Condicionado Conducta',
                        'CM'   => 'Condicionado Materia',
						'RE'   => 'Repetidor',
						'RI'   => 'Reingreso',
						'NI'   => 'Nuevo Ingreso'
                      )
                )
			)
            ->add('aspirante', new AspiranteType());
    }

    /**
     * @param OptionsResolverInterface $resolver
     */
    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'INTI\RegistroAcademicoBundle\Entity\Alumno',
            'cascade_validation' => true
        ));
    }

    /**
     * @return string
     */
    public function getName()
    {
        return 'alumnotype';
    }
}
