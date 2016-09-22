<?php

namespace Isometriks\Bundle\LegacyFormBundle\Form\Extension;

use Symfony\Component\DependencyInjection\ContainerInterface;
use Symfony\Component\Form\FormExtensionInterface;

class DependencyInjectionExtension implements FormExtensionInterface
{
    private $decoratedFormExtension;
    private $container;
    private $typeExtensionServiceIds;

    public function __construct(FormExtensionInterface $decoratedFormExtension, ContainerInterface $container, $typeExtensionServiceIds)
    {
        $this->decoratedFormExtension = $decoratedFormExtension;
        $this->container = $container;
        $this->typeExtensionServiceIds = $typeExtensionServiceIds;
    }

    public function getType($name)
    {
        return $this->decoratedFormExtension->getType($name);
    }

    public function getTypeExtensions($name)
    {
        $extensions = array();

        if (isset($this->typeExtensionServiceIds[$name])) {
            foreach ($this->typeExtensionServiceIds[$name] as $serviceId) {
                $extensions[] = $extension = $this->container->get($serviceId);

                // Normally would validate here but we are skipping that getExtendedType === $name\
            }
        }

        return $extensions;
    }

    public function getTypeGuesser()
    {
        return $this->decoratedFormExtension->getTypeGuesser();
    }

    public function hasType($name)
    {
        return $this->decoratedFormExtension->hasType($name);
    }

    public function hasTypeExtensions($name)
    {
        return $this->decoratedFormExtension->hasTypeExtensions($name);
    }
}