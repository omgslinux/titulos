<?php

namespace AppBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\OptionsResolver\OptionsResolver;
use AppBundle\Entity\MortgageFunds;

class MortgageFundsType extends AbstractType
{
    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('numrecords')
            ->add('paginicio')
            ->add('pagfin')
            ->add('legible')
            ->add('folleto')
            ->add('digitalizable')
            ->add('liqdate', DateType::class, array(
    'years' => range(1980, date('Y'))))
            ->add('extdate', DateType::class, array(
    'years' => range(1980, date('Y'))))
        ;
    }

    /**
     * @param OptionsResolver $resolver
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'AppBundle\Entity\MortgageFunds'
        ));
    }
}
