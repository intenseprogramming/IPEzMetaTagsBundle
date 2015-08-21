<?php
/**
 * @category  PHP
 * @package   intense-programming
 * @version   1
 * @date      03/08/2015 18:43
 * @author    Konrad, Steve <skonrad@wingmail.net>
 * @copyright 2015 Intense-Programming
 */

namespace IntenseProgramming\EzMetaTagsBundle\DependencyInjection;

use Symfony\Component\Config\Resource\FileResource;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\Config\FileLocator;
use Symfony\Component\DependencyInjection\Extension\PrependExtensionInterface;
use Symfony\Component\HttpKernel\DependencyInjection\Extension;
use Symfony\Component\DependencyInjection\Loader;
use Symfony\Component\Yaml\Yaml;

/**
 * Class IntenseProgrammingEzMetaTagsExtension.
 *
 * @package   IntenseProgramming\EzMetaTagsBundle\DependencyInjection
 * @author    Konrad, Steve <skonrad@wingmail.net>
 * @copyright 2015 Intense-Programming
 */
class IntenseProgrammingEzMetaTagsExtension extends Extension implements PrependExtensionInterface
{

    /**
     * {@inheritDoc}
     */
    public function load(array $configs, ContainerBuilder $container)
    {
        $configuration = new Configuration();
        $config = $this->processConfiguration($configuration, $configs);

        foreach ($config['system'] as $scope => $section) {
            foreach ($section as $type => $value) {
                $name = 'intense.programming.tags.' . $scope . '.' . $type;
                $container->setParameter($name, $value);
            }
        }

        $loader = new Loader\YamlFileLoader($container, new FileLocator(__DIR__ . '/../Resources/config'));

        $loader->load('fieldtype.yml');
        $loader->load('storage_engine.yml');
    }

    /**
     * Allow an extension to prepend the extension configurations.
     *
     * @param ContainerBuilder $container
     */
    public function prepend(ContainerBuilder $container)
    {
        $configFile = __DIR__ . '/../Resources/config/design.yml';
        $config = Yaml::parse(file_get_contents($configFile));
        $container->prependExtensionConfig('ezpublish', $config);
        $container->addResource(new FileResource($configFile));

        $configFile = __DIR__ . '/../Resources/config/default.yml';
        $config = Yaml::parse(file_get_contents($configFile));
        $container->prependExtensionConfig('intense_programming_ez_meta_tags', $config);
        $container->addResource(new FileResource($configFile));
    }

}
