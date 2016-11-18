<?php

namespace AppBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\FormType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\MoneyType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class FundManagersType extends AbstractType
{
    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('shortname', TextType::class, array ('label' => 'Nombre corto'))
            ->add('longname', TextType::class, array ('label' => 'Nombre completo'))
            ->add('regdate', DateType::class, array(
                'widget' => 'single_text',
                'years' => range(1980, date('Y')),
                'label' => 'Fecha de registro',
                ))
            ->add('nif', TextType::class, array ('label' => 'NIF'))
            ->add('address', TextType::class, array ('label' => 'Domicilio'))
            ->add('capitalsocial', MoneyType::class, array('label' => 'Capital social'))
            ->add('description', TextareaType::class, array(
                'attr' => array( 'cols' => 80),
                'label' => 'Descripción'))
        ;
    }

    /**
     * @param OptionsResolver $resolver
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'AppBundle\Entity\FundManagers'
        ));
    }
}
