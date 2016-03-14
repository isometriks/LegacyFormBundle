<?php

namespace Isometriks\Bundle\LegacyFormBundle\Form;

use Symfony\Component\Form\FormRegistryInterface;

class FormRegistry implements FormRegistryInterface
{
    private $inner;

    public function __construct(FormRegistryInterface $inner, array $legacyMap)
    {
        $this->inner = $inner;
        $this->legacyMap = $legacyMap;
    }

    public function getExtensions()
    {
        $this->inner->getExtensions();
    }

    public function getType($name)
    {
        if (strpos($name, '\\') === FALSE) {
            $name = $this->legacyMap[$name];
        }

        return $this->inner->getType($name);
    }

    public function getTypeGuesser()
    {
        $this->inner->getTypeGuesser();
    }

    public function hasType($name)
    {
        return isset($this->legacyMap[$name]) || $this->inner->hasType($name);
    }
}
