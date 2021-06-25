<?php

namespace App\Form;

use App\Entity\User;

use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\NotBlank;

class UserNewType extends UserType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        parent::buildForm($builder, $options);
        $field = $builder->get('newPassword');
        $options = $field->getOptions();
        $options['required'] = true;
        $options['constraints'] = [
            new NotBlank([
                'groups' => ['Create'],
            ])
        ];

        $builder->add('newPassword', PasswordType::class, $options);
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => User::class,
            'validation_groups' => ['Default', 'Create'],
        ]);
    }
}
