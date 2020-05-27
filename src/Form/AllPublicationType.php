<?php

namespace App\Form;

use App\Entity\Allpublications;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\HiddenType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class AllPublicationType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $date=new \DateTime('now');
        $year=$date->format('Y');

        $builder
            ->add('title')
            ->add('type',ChoiceType::class,[
                'choices'=>[
                    'journal'=>'journal',
                    'conference'=>'conference',
                    'book'=>'book',
                    'chapter'=>'chapter',
                ]
            ])
            ->add('name')
            ->add('volume')
            ->add('year',IntegerType::class,[
                'attr'=>[
                    'max'=>$year,
                    'min'=>1900,
                ]
            ])
            ->add('url')
            ->add('idPublication',HiddenType::class,[
                'mapped'=>false
            ])
            ->add('edit',SubmitType::class)
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Allpublications::class,
        ]);
    }
}
