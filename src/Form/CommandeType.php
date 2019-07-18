<?php

namespace App\Form;

use App\Entity\Commande;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\DateTimeType;

class CommandeType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('date', DateTimeType::class,[
                'format' => 'dd/MM/yyyy',
                'widget' => 'single_text'
            ])
            ->add('ville')
            ->add('pays')
            ->add('rue')
            ->add('codePostal')
            ->add('idClient')
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Commande::class,
            'csrf_protection'   => false,
            'allow_extra_fields' => true
        ]);
    }
}
