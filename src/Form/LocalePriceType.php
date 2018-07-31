<?php

namespace App\Form;

use App\Entity\LocaleCurrency;
use App\Entity\ProductLocalePrice;
use Doctrine\ORM\EntityRepository;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class LocalePriceType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('price')
            ->add('currency', EntityType::class, [
                'class' => LocaleCurrency::class,
                'query_builder' => function (EntityRepository $er) {
                    return $er->createQueryBuilder('lc')
                        ->orderBy('lc.locale', 'ASC');
                },
                'choice_label' => 'Locale',
                'property_path' => 'locale'
            ]);
    }


    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => ProductLocalePrice::class,
        ));
    }

}