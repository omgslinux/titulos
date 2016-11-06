<?php

namespace AppBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use AppBundle\Entity\FundLaws;
use AppBundle\Entity\Laws;

class FundLawsType extends AbstractType
{
    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('law', EntityType::class, array(
                'class' => 'AppBundle:Laws',
                'label' => 'Ley'
                ))
            ->add('notes', TextareaType::class, array(
                'label' => 'Observaciones',
                'attr' => array(
                    'cols' => 100,
                    'rows' => 10
                    )
                ))
        ;
    }

    /**
     * @param OptionsResolver $resolver
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'AppBundle\Entity\FundLaws'
        ));
    }
}
