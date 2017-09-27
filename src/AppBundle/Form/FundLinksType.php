<?php

namespace AppBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\UrlType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use AppBundle\Entity\FundLinks;

class FundLinksType extends AbstractType
{
    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('linktype', EntityType::class, array(
                'class' => 'AppBundle:FundLinkTypes',
                'label' => 'Tipo de enlace'
                ))
            ->add('description', TextareaType::class, array(
                'label' => 'Descripción',
                'attr' => array(
                    'cols' => 80
                )
            ))
            ->add('URL', UrlType::class, array(
                'label' => 'URL'
            ))
        ;
    }

    /**
     * @param OptionsResolver $resolver
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'AppBundle\Entity\FundLinks'
        ));
    }
}
