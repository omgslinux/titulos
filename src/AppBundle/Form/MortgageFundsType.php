<?php

namespace AppBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
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
            ->add('numrecords', IntegerType::class, array('label' => 'Número de registros' ))
            ->add('openfund', CheckboxType::class, array(
                'required' => false,
                'label' => 'Fondo abierto'))
            ->add('loansfirstpage', IntegerType::class, array('label' => 'Primera página de préstamos'))
            ->add('loanslastpage', IntegerType::class, array('label' => 'Última página de prestamos'))
            ->add('fundpages', IntegerType::class, array('label' => 'Número de páginas del fondo'))
            ->add('legible', CheckboxType::class, array(
                'required' => false,
                'label' => '¿Es legible el listado de préstamos?'))
            ->add('digitalizable', CheckboxType::class, array(
                'required' => false,
                'label' => '¿El listado es de texto?'))
            ->add('brochure', CheckboxType::class, array(
                'required' => false,
                'label' => '¿Hay folleto?'))
            ->add('liqdate', DateType::class, array(
                'widget' => 'single_text',
                'label' => 'Fecha de liquidación',
                'years' => range(1980, date('Y'))))
            ->add('extdate', DateType::class, array(
                'widget' => 'single_text',
                'label' => 'Fecha de extinción',
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
