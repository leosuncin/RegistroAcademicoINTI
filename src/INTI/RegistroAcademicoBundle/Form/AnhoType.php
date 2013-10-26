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
			->add('numPeriodo','hidden',array(
				'attr'=>array(
				'value' => '1',
				'style'=>'display:none;visibility:hidden'
			)))
			->add('anhoCorriente','choice',array(
				'label' => 'Año a abrir',
				'choices' => array(
					''.$anhoActual => ''.$anhoActual,
				)))
			->add('estaAbierto','hidden',array(
				'attr'=>array('class'=>'btn btn-primary',
				'style'=>'display:none;visibility:hidden',
							'value'=>'2')
				))
			/*->add('continuar','submit', array(
			'label' => 'Abrir Año Escolar',
			'attr'=>array('class'=>'btn btn-primary',
			'value'=>'2')))*/
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
