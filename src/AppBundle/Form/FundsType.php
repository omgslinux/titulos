<?php

namespace AppBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\FormType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\MoneyType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use AppBundle\Entity\FundManagers;

class FundsType extends AbstractType
{
    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('fundname',TextType::class, array('label' => 'Nombre corto del fondo') )
            ->add('fundlongname', TextType::class, array ('label' => 'Nombre completo del fondo'))
            ->add('fundmanager', EntityType::class, array (
                'class' => 'AppBundle:FundManagers',
                'label' => 'Entidad gestora'))
            ->add('fundtype', EntityType::class, array (
                'class' => 'AppBundle:FundTypes',
                'label' => 'Tipo de fondo'))
            ->add('nif')
            ->add('constdate', DateType::class, array(
                'widget' => 'single_text',
                'years' => range(1980, date('Y')),
                'label' => 'Fecha de constitución',
                ))
            ->add('amount', MoneyType::class, array('label' => 'Importe del fondo'))
            ->add('cnmvpdf', TextType::class, array('label' => 'Cadena URL a PDF (entre {})'))
            ->add('notes', TextareaType::class, array(
                'attr' => array( 'cols' => 80),
                'label' => 'Observaciones'))
        ;
    }

    /**
     * @param OptionsResolver $resolver
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'AppBundle\Entity\Funds'
        ));
    }
}
