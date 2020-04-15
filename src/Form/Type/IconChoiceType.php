<?php


namespace App\Form\Type;


use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\AbstractTypeExtension;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\FormInterface;
use Symfony\Component\Form\FormView;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\OptionsResolver\OptionsResolver;

class IconChoiceType extends AbstractType
{
    /**
     * #param FormBuilderInterface $builder
     * #param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder->setAttribute('icon', $options['icon']);
    }
    /**
     * #param FormView $view
     * #param FormInterface $form
     * #param array $options
     */
    public function buildView(FormView $view, FormInterface $form, array $options)
    {
        $view->vars['icon'] = $options['icon'];
    }
    /**
     * #param OptionsResolver $resolver
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(['icon' => null]);
        $resolver->setDefined(['icon']);
    }
    /**
     * Returns the name of the type being extended.
     *
     * #return string The name of the type being extended
     */
    public function getExtendedType()
    {
        return ChoiceType::class; // Extend the button field type
    }
}