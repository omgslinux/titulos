<?php

namespace AppBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use AppBundle\Entity\FundBankTasks;

class FundBankTasksType extends AbstractType
{
    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('taskdate', DateType::class, array(
                'widget' => 'single_text',
                'label' => 'Fecha',
                ))
            ->add('user', EntityType::class, array (
                'class' => 'AppBundle:Users',
                'label' => 'Usuario'
                ))
            ->add('shortdescription', TextType::class, array('label' => 'Descripción breve'))
            ->add('longdescription', TextareaType::class, array(
                'attr' => array('cols' => 80),
                'label' => 'Descripción larga'
            ))
            ->add('finished', CheckboxType::class, array(
                'required' => false,
                'label' => 'Finalizada'
            ))
        ;
    }

    /**
     * @param OptionsResolver $resolver
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'AppBundle\Entity\FundBankTasks'
        ));
    }
}
