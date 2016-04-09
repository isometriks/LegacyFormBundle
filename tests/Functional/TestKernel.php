<?php

namespace Isometriks\Bundle\LegacyFormBundle\Tests\Functional;

use Isometriks\Bundle\LegacyFormBundle\IsometriksLegacyFormBundle;
use Symfony\Bundle\FrameworkBundle\FrameworkBundle;
use Symfony\Bundle\FrameworkBundle\Kernel\MicroKernelTrait;
use Symfony\Component\Config\Loader\LoaderInterface;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\Filesystem\Filesystem;
use Symfony\Component\HttpKernel\Kernel;
use Symfony\Component\Routing\RouteCollectionBuilder;

/**
 * @author Kamil Kokot <kamil@kokot.me>
 */
final class TestKernel extends Kernel
{
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
        $loader->load(function (ContainerBuilder $container) use ($loader) {
            $container->loadFromExtension('framework', [
                'secret' => 'Rick Astley',
                'form' => null,
            ]);
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
