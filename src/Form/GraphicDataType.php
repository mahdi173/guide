<?php


namespace App\Form;

use App\DTO\GraphicDataDTO;
use App\Form\Type\IconChoiceType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\ColorType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\NotBlank;
use Symfony\Component\Validator\Constraints\Regex;

class GraphicDataType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {

        $builder
            ->add('type',ChoiceType::class,[
                'choices'=>[
                    'Bar'=>'bar',
                    'Pie'=>'pie',
                    'Line'=>'line',
//                    'Doughnut'=>'doughnut',
                    'Radar'=>'radar',
                    'Horizontal Bar'=>'horizontalBar',
                ],
//                'icon' => 'fa-bug',
            ])
            ->add('graphicTitle',TextType::class, [
                    'required'=>'required',
                    'attr'=>[
                        'oninvalid'=>"setCustomValidity('Please fill this field')",
                        'oninput'=>"setCustomValidity('')",
                    ],

                ])
            ->add('titleX',TextType::class,[
                'required'=>true,
                'attr'=>[
                    'oninvalid'=>"setCustomValidity('Please fill this field')",
                    'oninput'=>"setCustomValidity('')",
                ],
            ])
            ->add('titleY',TextType::class,[
                'required'=>'required',
                'attr'=>[
                    'oninvalid'=>"setCustomValidity('Please fill this field')",
                    'oninput'=>"setCustomValidity('')",
                ],
            ])
            ->add('labelY',TextType::class, [
                'required'=>'false',
                'attr'=>['value'=>"Title"]

            ])
            ->add('dataX',TextareaType::class,[
                'required'=>'required',

                'label'=>'X axis',
                'attr'=>[
                    'cols'=>'8','rows'=>'8','class'=>"dataX",
                    'oninvalid'=>"setCustomValidity('Please fill this field')",
                    'oninput'=>"setCustomValidity('')",
                ],
            ])
            ->add('dataY',TextareaType::class,[
                'label'=>'Y axis',
                'attr'=>[
                    'cols'=>'8','rows'=>'8','class'=>"dataY",
                     'oninvalid'=>"setCustomValidity('Please fill this field')",
                    'oninput'=>"setCustomValidity('')",
                ],
                'required'=>'required'
            ])
            ->add('createGraph',SubmitType::class,[
                'attr'=>['class'=>"btn btn-primary createGraph"]
            ])
            ->add('color',ColorType::class,[
                'attr'=>['class'=>""]
            ])
            ->add('showValues',CheckboxType::class,[
                'required'=>false,
              //  'attr'=>['checked'=>"checked","value"=>"1"]
            ])
//            ->add('showGrid',CheckboxType::class,[
//                'required'=>false,
//                'attr'=>['class'=>"showGrid"]
//            ])
            ->add('showGrid',ChoiceType::class,[
                'choices'=>[
                    'None'=>'none',
                    'Horizental'=>'horizental',
                    'Vertical'=>'vertical',
                    'Both'=>'both',
                ],
                  'attr'=>['class'=>"showGrrid"]
            ])
            ->add('border',CheckboxType::class,[
                'required'=>false,
                'attr'=>['class'=>"border"]
            ])
            ->add('roundCorners',CheckboxType::class,[
                'required'=>false,
                'attr'=>['class'=>"roundCorner"]
            ])
            ->add('width',IntegerType::class,[
                'required'=>false,
                'attr'=>['value'=>"700",'min'  => 0]
            ])
            ->add('height',IntegerType::class,[
                'required'=>false,
                'attr'=>['value'=>"500",'min'  => 0]
            ])
            ->add('titleColor',ColorType::class,[
                'attr'=>['class'=>""]
            ])
            ->add('gridColor',ColorType::class,[
                'attr'=>['class'=>""]
            ])
            ->add('graphBackgroundColor',ColorType::class,[
                'attr'=>['class'=>"",'value'=>"#ffffff"]
            ])
            ->add('titleXAndY',CheckboxType::class,[
                'required'=>false,
                //  'attr'=>['checked'=>"checked","value"=>"1"]
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