<?php

namespace Isometriks\Bundle\LegacyFormBundle\Tests\Form\Type;

use Symfony\Component\Form\AbstractType;

class CustomTextType extends AbstractType
{
    public function getBlockPrefix()
    {
        return 'custom_text';
    }
}