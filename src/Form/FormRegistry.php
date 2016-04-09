<?php

namespace Isometriks\Bundle\LegacyFormBundle\Form;

use Symfony\Component\Form\Exception;
use Symfony\Component\Form\FormRegistryInterface;

/**
 * @author Craig Blanchette <craig.blanchette@gmail.com>
 * @author Kamil Kokot <kamil@kokot.me>
 */
final class FormRegistry implements FormRegistryInterface
{
    /**
     * @var FormRegistryInterface
     */
    private $decoratedFormRegistry;

    /**
     * @var array
     */
    private $aliases;

    /**
     * @param FormRegistryInterface $decoratedFormRegistry
     * @param array $aliases
     */
    public function __construct(FormRegistryInterface $decoratedFormRegistry, array $aliases)
    {
        $this->decoratedFormRegistry = $decoratedFormRegistry;
        $this->aliases = $aliases;
    }

    /**
     * {@inheritdoc}
     */
    public function getType($name)
    {
        return $this->decoratedFormRegistry->getType($this->normalizeName($name));
    }

    /**
     * {@inheritdoc}
     */
    public function hasType($name)
    {
        return $this->decoratedFormRegistry->hasType($this->normalizeName($name));
    }

    /**
     * {@inheritdoc}
     */
    public function getTypeGuesser()
    {
        return $this->decoratedFormRegistry->getTypeGuesser();
    }

    /**
     * {@inheritdoc}
     */
    public function getExtensions()
    {
        return $this->decoratedFormRegistry->getExtensions();
    }

    /**
     * @param string $name
     *
     * @return string
     */
    private function normalizeName($name)
    {
        if (isset($this->aliases[$name])) {
            return $this->aliases[$name];
        }

        return $name;
    }
}
