<?php

namespace Isometriks\Bundle\LegacyFormBundle\Form;

use Symfony\Component\Form\FormRegistry as BaseFormRegistry;
use Symfony\Component\Form\ResolvedFormTypeFactoryInterface;

/**
 * @author Craig Blanchette <craig.blanchette@gmail.com>
 */
class FormRegistry extends BaseFormRegistry
{
    /**
     * @var array
     */
    private $legacyMap;

    /**
     * {@inheritdoc}
     *
     * @param array $legacyMap
     */
    public function __construct(array $extensions, ResolvedFormTypeFactoryInterface $resolvedTypeFactory, array $legacyMap)
    {
        parent::__construct($extensions, $resolvedTypeFactory);

        $this->legacyMap = $legacyMap;
    }

    /**
     * {@inheritdoc}
     */
    public function getType($name)
    {
        if (isset($this->legacyMap[$name])) {
            $name = $this->legacyMap[$name];
        }

        return parent::getType($name);
    }
}
