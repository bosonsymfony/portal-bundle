<?php

namespace UCI\Boson\PortalBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class ImageSetType extends AbstractType
{
    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('paths')
//            ->add('files','file',array(
//                'label' => 'Imagenes',
//                'attr' => array(
//                    'accept' => 'image/*',
//                    'multiple' => true,
//                )
//            ))
            ->add('tile');
    }
    
    /**
     * @param OptionsResolverInterface $resolver
     */
    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'UCI\Boson\PortalBundle\Entity\ImageSet'
        ));
    }

    /**
     * @return string
     */
    public function getName()
    {
        return 'futbol_PortalBundle_imageset';
    }
}
