<?php

namespace AppBundle\Form;

use AppBundle\Entity\Mensaje;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;

class MensajeType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('contenido',TextareaType::class)
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(
            [
                'data_class'=> Mensaje::class
            ]
        );
    }

    public function getBlockPrefix()
    {
        return 'app_bundle_mensaje_type';
    }
}
