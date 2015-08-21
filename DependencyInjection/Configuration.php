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

use Symfony\Component\Config\Definition\Builder\TreeBuilder;
use Symfony\Component\Config\Definition\ConfigurationInterface;

/**
 * Class Configuration.
 *
 * @package   IntenseProgramming\EzMetaTagsBundle\DependencyInjection
 * @author    Konrad, Steve <skonrad@wingmail.net>
 * @copyright 2015 Intense-Programming
 */
class Configuration implements ConfigurationInterface
{

    /**
     * {@inheritDoc}
     */
    public function getConfigTreeBuilder()
    {
        $treeBuilder = new TreeBuilder();
        $treeBuilder->root('intense_programming_ez_meta_tags')
            ->children()
                ->arrayNode('system')
                    ->useAttributeAsKey('name')
                    ->prototype('array', 'asd')
                        ->performNoDeepMerging()
                        ->children()
                            ->scalarNode('template')
                            ->end()
                            ->scalarNode('image_alias')
                            ->end();

        return $treeBuilder;
    }

}
