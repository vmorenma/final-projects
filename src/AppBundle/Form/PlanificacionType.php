<?php

namespace AppBundle\Form;

use AppBundle\Entity\Planificacion;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\TextType;

class PlanificacionType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('nombre',TextType::class)
            ->add('descripcion',TextType::class)
            ->add('categoria', TextType::class)
        ;

    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(
            [
                'data_class'=> Planificacion::class
            ]
        );
    }

    public function getName()
    {
        return 'app_bundle_planificacion_type';
    }
}
