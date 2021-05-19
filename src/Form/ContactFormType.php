<?php


namespace App\Form;

use App\DTO\ContactDT0;

use Symfony\Component\Form\AbstractType;

use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\NotBlank;
use Symfony\Component\Validator\Constraints\Regex;

class ContactFormType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {

        $builder
            ->add('firstName',TextType::class,[

//                'icon' => 'fa-bug',
            ])
            ->add('lastName',TextType::class, [
                    'required'=>'required',
                    'attr'=>[
                        'oninvalid'=>"setCustomValidity('Please fill this field')",
                        'oninput'=>"setCustomValidity('')",
                    ],

                ])
            ->add('email',TextType::class,[
                'required'=>true,
                'attr'=>[
                    'oninvalid'=>"setCustomValidity('Please fill this field')",
                    'oninput'=>"setCustomValidity('')",
                ],
            ])
            ->add('pays',TextType::class,[
                'required'=>'required',
                'attr'=>[
                    'oninvalid'=>"setCustomValidity('Please fill this field')",
                    'oninput'=>"setCustomValidity('')",
                ],
            ])
            ->add('subject',TextType::class, [
                'required'=>'false',
                'attr'=>['value'=>"Title"]

            ])
            ->add('message',TextareaType::class, [
                'required'=>'false',
                'attr'=>['value'=>"Title"]

            ])
            ->add('send', SubmitType::class, [
                'label' => 'Envoyer',
                'attr'  => array('class'=> 'form-control btn btn-primary btn-sm  col-md-12 btn btn-sm submitSearchForm')
            ])
        ;
    }


    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => ContactDT0::class,
        ]);
    }
}
