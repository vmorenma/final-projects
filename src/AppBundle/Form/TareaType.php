<?php

namespace AppBundle\Form;

use AppBundle\Entity\Tarea;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;

class TareaType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {

        $builder
            ->add('nombre',TextType::class)
            ->add('descripcion',TextareaType::class)
            ->add('coste', NumberType::class)
            ->add('startDate', DateType::class)
            ->add('endDate', DateType::class)
            ->add('assignado', ChoiceType::class, array(
            'choices'  => array(
                'Maybe' => null,
                'Yes' => true,
                'No' => false,
                )
            ))

        ;

    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(
            [
                'data_class'=> Tarea::class
            ]
        );
    }

    public function getName()
    {
        return 'app_bundle_tarea_type';
    }
}
