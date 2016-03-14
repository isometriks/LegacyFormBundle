<?php

namespace Isometriks\Bundle\LegacyFormBundle\Form;

use Symfony\Component\Form\FormRegistry as BaseFormRegistry;
use Symfony\Component\Form\ResolvedFormTypeFactoryInterface;

class FormRegistry extends BaseFormRegistry
{
    private $legacyMap;

    public function __construct(array $extensions, ResolvedFormTypeFactoryInterface $resolvedTypeFactory, array $legacyMap)
    {
        parent::__construct($extensions, $resolvedTypeFactory);

        $this->legacyMap = $legacyMap;
    }

    public function getType($name)
    {
        if (strpos($name, '\\') === FALSE) {
            $name = $this->legacyMap[$name];
        }

        return parent::getType($name);
    }

    public function hasType($name)
    {
        return isset($this->legacyMap[$name]) || parent::hasType($name);
    }
}
