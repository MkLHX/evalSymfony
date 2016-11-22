<?php

namespace MediaBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class AlbumType extends AbstractType
{
    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder->add('titreAlbum')
            ->add('artiste')
            ->add('genre',ChoiceType::class,array(
                'choices' => array(
                    'hiphop'=>'Hiphop',
                    'soul'=>'Soul',
                    'rock'=>'Rock',
                ),
            ))
            ->add('support',ChoiceType::class,array(
                'choices' => array(
                    'vinyl'=>'Vinyl',
                    'cd'=>'CD',
                    'cassette'=>'Cassette',
                ),
            ));
    }
    
    /**
     * {@inheritdoc}
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'MediaBundle\Entity\Album'
        ));
    }

    /**
     * {@inheritdoc}
     */
    public function getBlockPrefix()
    {
        return 'mediabundle_album';
    }


}
