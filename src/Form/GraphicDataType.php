<?php


namespace App\Form;

use App\DTO\GraphicDataDTO;
use App\Form\Type\IconChoiceType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\ColorType;
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
        $choices = $this->getFontAwesome();
        $builder
            ->add('type',ChoiceType::class,[
                'choices'=>[
                    'Bar'=>'bar',
                    'Pie'=>'pie',
                    'Line'=>'line',
                ],
//                'icon' => 'fa-bug',

                'attr' => array('class' => "fa" )
            ])
            ->add('graphicTitle',TextType::class, [
                    'required'=>'required'
                ])
            ->add('titleX',TextType::class,[
                'required'=>'required'
            ])
            ->add('titleY',TextType::class,[
                'required'=>'required'
            ])
            ->add('dataX',TextareaType::class,[
                'required'=>'required',
                'label'=>'X axis',
                'attr'=>[
                    'cols'=>'8','rows'=>'8','class'=>"dataX"
                ],
            ])
            ->add('dataY',TextareaType::class,[
                'label'=>'Y axis',
                'attr'=>[
                    'cols'=>'8','rows'=>'8','class'=>"dataY"
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
            ->add('showGrid',CheckboxType::class,[
                'required'=>false,
//                'icon' => 'fa-bug',
               // 'attr'=>['checked'=>"checked","value"=>"1"]
            ])
        ;
    }

    public function getFontAwesome()
    {

//        $webroot = $this->get('kernel')->getRootDir() . '/../web';
//        $pattern = '/\.(fa-(?:\w+(?:-)?)+):before\s+{\s*content:\s*"\\\\(.+)";\s+}/';
//        $subject = file_get_contents($webroot . '/assets/vendor/font-awesome/css/font-awesome.css');
//        preg_match_all($pattern, $subject, $matches, PREG_SET_ORDER);
//        foreach ($matches as $match) {
//            $icons[$match[1]] = '&#x' . $match[2] . ';';
//        }
//
//        return $icons;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => GraphicDataDTO::class,
        ]);
    }
}