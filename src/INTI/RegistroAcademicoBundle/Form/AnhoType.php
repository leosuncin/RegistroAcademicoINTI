<?php

namespace INTI\RegistroAcademicoBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class AnhoType extends AbstractType
{
    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
	{
		//$anhoActualm2=Date('Y')-2;
		//$anhoActualm1=Date('Y')-1;
		$anhoActual=Date('Y');
		//$anhoActualp1=Date('Y')+1;
		//$anhoActualp2=Date('Y')+2;
        $builder
			->add('numPeriodo','choice',array(
				'label' => 'Año a abrir',
				'choices' => array(
					''.$anhoActual => ''.$anhoActual,
				)))
			->add('continuar','submit', array(
			'label' => 'Abrir Año Escolar',
			'attr'=>array('class'=>'btn btn-primary')))
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
