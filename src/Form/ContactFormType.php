<?php


namespace App\Form;

use App\DTO\ContactDT0;

use Proxies\__CG__\Sulu\Bundle\ContactBundle\Entity\EmailType;
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
            ->add('email',\Symfony\Component\Form\Extension\Core\Type\EmailType::class,[
                'required'=>true,
                'attr'=>[
                    'oninvalid'=>"setCustomValidity('Please enter a valid Email')",
                    'oninput'=>"setCustomValidity('')",
                ],
            ])
            ->add('pays',TextType::class,[
                'required'=>'required',
                'label'=>'Country',
                'attr'=>[
                    'oninvalid'=>"setCustomValidity('Please fill this field')",
                    'oninput'=>"setCustomValidity('')",
                ],
            ])
            ->add('subject',TextType::class, [
                'required'=>'true',
                'attr'=>[
                    'oninvalid'=>"setCustomValidity('Please fill this field')",
                    'oninput'=>"setCustomValidity('')",
                ],

            ])
            ->add('message',TextareaType::class, [
                'required'=>'true',
                'attr'=>[
                    'oninvalid'=>"setCustomValidity('Please enter your Message')",
                    'oninput'=>"setCustomValidity('')",
                ],


            ])
            ->add('send', SubmitType::class, [
                'label' => 'Send',
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
