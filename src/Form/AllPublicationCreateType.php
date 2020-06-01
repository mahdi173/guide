<?php

namespace App\Form;

use App\Entity\Allpublications;
use DoctrineExtensions\Query\Mysql\Year;
use Oro\ORM\Query\AST\Platform\Functions\Postgresql\Dayofyear;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\CollectionType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\DateTime;

class AllPublicationCreateType extends AbstractType
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
            ->add('name',TextType::class,[
                'label'=>'',
            ])
            ->add('authors',TextareaType::class)
            ->add('volume')
            ->add('year',IntegerType::class,[
                'attr'=>[
                    'max'=>$year,
                    'min'=>1900,
                ]
            ])
            ->add('url')
            ->add('save',SubmitType::class)


        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Allpublications::class,
        ]);
    }
}
