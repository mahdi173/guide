<?php


namespace App\Form;

use App\DTO\GraphicDataDTO;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\ColorType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class GraphicDataType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('type',ChoiceType::class,[
                'choices'=>[
                    'bar'=>'bar',
                    'pie'=>'pie',
                    'line'=>'line',
                ],

            ])
            ->add('graphicTitle',TextType::class, [
                    'required'=>'require'
                ])
            ->add('titleX',TextType::class,[
                'required'=>'required'
            ])
            ->add('titleY',TextType::class,[
                'required'=>'required'
            ])
            ->add('dataX',TextareaType::class,[
                'required'=>'required',
                'attr'=>[
                    'cols'=>'8','rows'=>'8'
                ],
            ])
            ->add('dataY',TextareaType::class,[
                'attr'=>[
                    'cols'=>'8','rows'=>'8'
                ],
                'required'=>'required'
            ])
            ->add('createGraph',SubmitType::class,[
                'attr'=>['class'=>"btn btn-primary"]
            ])
            ->add('color',ColorType::class,[
                'attr'=>['class'=>""]
            ])
            ->add('showValues',CheckboxType::class,[
                'required'=>false,
              //  'attr'=>['checked'=>"checked","value"=>"1"]
            ])
            ->add('showGrid',CheckboxType::class,[
                'required'=>false,
               // 'attr'=>['checked'=>"checked","value"=>"1"]
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => GraphicDataDTO::class,
        ]);
    }
}