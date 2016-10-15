<?php

namespace AppBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class SecuritiesType extends AbstractType
{
    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('fundId')
            ->add('credito')
            ->add('loantypeId')
            ->add('bankId')
            ->add('date', 'datetime')
            ->add('duration')
            ->add('municipioId')
            ->add('loanamount')
            ->add('registration')
            ->add('volume')
            ->add('book')
            ->add('folio')
            ->add('building')
            ->add('page')
        ;
    }
    
    /**
     * @param OptionsResolver $resolver
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'AppBundle\Entity\Securities'
        ));
    }
}
