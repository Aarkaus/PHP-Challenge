<?php 

// src/AppBundle/Form/Task/BillingInputsType.php
namespace AppBundle\Form\Task;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class BillingInputsType extends AbstractType
{
	public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('estimated', 'number')
            ->add('duplicates', 'percent')
			->add('versions', 'percent')
            ->add('CalculateCost', 'submit', array('label' => 'Calculate Cost'))
        ;
    }
    
	/**
     * @param OptionsResolver $resolver
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'AppBundle\Entity\BillingInputs',
        ));
    }
	
	public function getName()
    {
        return 'app_Billing_Inputs';
    }
}
?>