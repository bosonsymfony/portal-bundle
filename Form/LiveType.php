<?php

namespace UCI\Boson\PortalBundle\Form;

use UCI\Boson\PortalBundle\Classes\OptionsArray;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class LiveType extends AbstractType
{
    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
//            ->add('dataEffect','choice',array(
//                'choices' => OptionsArray::effects(),
//                'label' => 'Live effect'
//            ))
//            ->add('dataEasing','choice',array(
//                'choices' => OptionsArray::easings(),
//                'label' => 'Live easing'
//            ))
            ->add('dataEffect')
            ->add('dataEasing');
    }

    /**
     * @param OptionsResolverInterface $resolver
     */
    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'UCI\Boson\PortalBundle\Entity\Live'
        ));
    }

    /**
     * @return string
     */
    public function getName()
    {
        return 'futbol_PortalBundle_live';
    }
}
