<?php

namespace UCI\Boson\PortalBundle\Form;

//use UCI\Boson\PortalBundle\Classes\OptionsArray;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class TileType extends AbstractType
{
    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('selected', null, array(
                'required' => false
            ))
//            ->add('backgroung', 'choice', array(
//                'choices' => OptionsArray::backgrounds(),
//                'expanded' => true,
//                'attr' => array(
//                    'class' => 'select2'
//                )
//            ))
//            ->add('size', 'choice', array(
//                'choices' => OptionsArray::sizes(),
//                'attr' => array(
//                    'class' => 'select2'
//                )
//            ))
            ->add('backgroung')
            ->add('size')
            ->add('contents', null, array(
//                'attr' => array(
//                    'class' => 'select2'
//                ),
//                'expanded' => false,
//                'by_reference' => false
            ))
            ->add('dataEffect', null,array())
            ->add('tileGroup', null, array(
                'attr' => array(
                    'class' => 'select2'
                )
            ))
            ->add('funcionalidad', null, array(
                'attr' => array(
                    'class' => 'select2'
                )
            ));
    }

    /**
     * @param OptionsResolverInterface $resolver
     */
    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'UCI\Boson\PortalBundle\Entity\Tile',
            'csrf_protection' => false
        ));
    }

    /**
     * @return string
     */
    public function getName()
    {
        return 'futbol_PortalBundle_tile';
    }
}
