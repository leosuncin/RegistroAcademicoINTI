<?php

namespace INTI\RegistroAcademicoBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class PeriodoType extends AbstractType
{
    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
	{
		$anhoActualm2=Date('Y')-2;
		$anhoActualm1=Date('Y')-1;
		$anhoActual=Date('Y');
		$anhoActualp1=Date('Y')+1;
		$anhoActualp2=Date('Y')+2;
        $builder
			->add('numPeriodo','choice',array(
				'label' => 'Numero de Periodo',
				'choices' => array(
					'1' => 'Primer Periodo',
					'2' => 'Segundo Periodo',
					'3' => 'Tercer Periodo',
					'4' => 'Cuarto Periodo',
					'5' => 'Quinto Periodo'
				)))
				->add('anhoCorriente','choice',array(
					'label' => 'Año de Periodo',
					'choices' => array(
						''.$anhoActualm2=>''.$anhoActualm2,
						''.$anhoActualm1=>''.$anhoActualm1,
						''.$anhoActual=>''.$anhoActual,
						''.$anhoActualp1=>''.$anhoActualp1,
						''.$anhoActualp2=>''.$anhoActualp2


					)
				))
			
			->add('estaAbierto','choice',array(
				'label' => 'Estado del Periodo',
				'choices' => array('1' => 'Periodo Abierto', '2' => 'Periodo Cerrado')))
        ;
    }
    
    /**
     * @param OptionsResolverInterface $resolver
     */
    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'INTI\RegistroAcademicoBundle\Entity\Periodo'
        ));
    }

    /**
     * @return string
     */
    public function getName()
    {
        return 'inti_registroacademicobundle_periodo';
    }
}
