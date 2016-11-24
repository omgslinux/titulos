<?php

namespace AppBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\UrlType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;

class LawsType extends AbstractType
{
    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('lawtype', EntityType::class, array(
                'class' => 'AppBundle:LawType',
                'label' => 'Tipo de ley',
            ))
            ->add('number', IntegerType::class, array ('label' => 'Número de la ley'))
            ->add('lawdate', DateType::class, array(
                'widget' => 'single_text',
                'label' => 'Fecha de la ley',
                'years' => range(1980, date('Y'))))
            ->add('releasedate', DateType::class, array(
                'widget' => 'single_text',
                'label' => 'Fecha de publicación',
                'years' => range(1980, date('Y'))))
            ->add('legalsincedate', DateType::class, array(
                'widget' => 'single_text',
                'label' => 'Fecha de entrada en vigor',
                'years' => range(1980, date('Y'))))
            ->add('shortname', TextType::class, array('label' => 'Descripción corta'))
            ->add('longname', TextType::class, array('label' => 'Descripción larga'))
            ->add('notes', TextType::class, array('label' => 'Observaciones'))
            ->add('boe', UrlType::class, array('label' => 'URL BOE'))
            ->add('contents', TextareaType::class, array('label' => 'Contenido',
                'attr' => array('cols' => 80, 'rows' => 15)
            ))
            ->add('analysis', TextareaType::class, array(
                'label' => 'Análisis',
                'attr' => array('cols' => 80, 'rows' => 15)
            ))
        ;
    }

    /**
     * @param OptionsResolver $resolver
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'AppBundle\Entity\Laws'
        ));
    }
}
