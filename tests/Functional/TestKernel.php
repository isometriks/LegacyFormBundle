<?php

namespace Isometriks\Bundle\LegacyFormBundle\Tests\Functional;

use Closure;
use Isometriks\Bundle\LegacyFormBundle\IsometriksLegacyFormBundle;
use Symfony\Bundle\FrameworkBundle\FrameworkBundle;
use Symfony\Component\Config\Loader\LoaderInterface;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\Filesystem\Filesystem;
use Symfony\Component\HttpKernel\Kernel;

/**
 * @author Kamil Kokot <kamil@kokot.me>
 */
final class TestKernel extends Kernel
{
    /**
     * @var Closure
     */
    private $initializer;

    /**
     * @param callable|null $initializer
     */
    public function __construct(callable $initializer = null)
    {
        $this->initializer = $initializer ?: function (ContainerBuilder $container, LoaderInterface $loader) {};

        parent::__construct('test', false);
    }

    /**
     * {@inheritdoc}
     */
    public function registerBundles()
    {
        return [
            new FrameworkBundle(),

            new IsometriksLegacyFormBundle(),
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function registerContainerConfiguration(LoaderInterface $loader)
    {
        $initializer = $this->initializer;

        $loader->load(function (ContainerBuilder $container) use ($loader, $initializer) {
            $container->loadFromExtension('framework', [
                'secret' => 'Rick Astley',
                'form' => null,
            ]);

            $initializer($container, $loader);
        });
    }

    /**
     * {@inheritdoc}
     */
    public function getCacheDir()
    {
        return $this->getBuildDir() . '/cache/';
    }

    /**
     * {@inheritdoc}
     */
    public function getLogDir()
    {
        return $this->getBuildDir() . '/logs/';
    }

    /**
     * {@inheritdoc}
     */
    public function shutdown()
    {
        parent::shutdown();

        if (file_exists($this->getBuildDir())) {
            (new Filesystem())->remove($this->getBuildDir());
        }
    }

    /**
     * @return string
     */
    private function getBuildDir()
    {
        return $this->rootDir . '/build/'. $this->environment;
    }
}
