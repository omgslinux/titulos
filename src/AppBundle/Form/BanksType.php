<?php

namespace AppBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;

class BanksType extends AbstractType
{
    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('acronym', TextType::class, array(
                'label' => 'Abreviatura'
            ))
            ->add('becode', TextType::class, array(
                'label' => 'Código BE'
            ))
            ->add('category', EntityType::class, array(
                'class' => 'AppBundle:BankCategory',
                'label' => 'Categoría',
            ))
            ->add('shortname', TextType::class, array(
                'label' => 'Nombre corto'
            ))
            ->add('longname', TextType::class, array(
                'label' => 'Nombre largo',
                'required' => false
            ))
            ->add('address', TextType::class, array(
                'label' => 'Dirección',
                'required' => false
            ))
            ->add('city', TextType::class, array(
                'label' => 'Ciudad',
                'required' => false
            ))
        ;
    }

    /**
     * @param OptionsResolver $resolver
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'AppBundle\Entity\Banks'
        ));
    }
}
