<?php

namespace App\Form;

use App\Entity\Journal;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class JournalType  extends AbstractType
{

    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('title',TextType::class)
            ->add('ejr',TextType::class)
            ->add('publisher',TextType::class)
            ->add('openaccess',TextType::class)
            ->add('printissn',TextType::class)
            ->add('eissn',TextType::class)
            ->add('rank',TextType::class)
            ->add('link',TextType::class)
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {

        $resolver->setDefaults([
            'data_class' => Journal::class,
        ]);
    }

}
