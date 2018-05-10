<?php

/*
 * This file is part of the Behat MinkExtension.
 * (c) Konstantin Kudryashov <ever.zet@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Behat\MinkExtension\ServiceContainer\Driver;

use Symfony\Component\Config\Definition\Builder\ArrayNodeDefinition;

class CrossBrowserTestingFactory extends Selenium2Factory
{
    /**
     * {@inheritdoc}
     */
    public function getDriverName()
    {
        return 'cross_browser_testing';
    }

    /**
     * {@inheritdoc}
     */
    public function configure(ArrayNodeDefinition $builder)
    {
        $builder
            ->children()
                ->scalarNode('user')->defaultValue(getenv('CROSSBROWSERTESTING_USERNAME'))->end()
                ->scalarNode('key')->defaultValue(getenv('CROSSBROWSERTESTING_ACCESS_KEY'))->end()
                ->scalarNode('server')->defaultValue('crossbrowsertesting.com')->end()            
                ->scalarNode('browser')->defaultValue('chrome')->end()
                ->append($this->getCapabilitiesNode())
            ->end()
        ;
    }

    /**
     * {@inheritdoc}
     */
    public function buildDriver(array $config)
    {
        $config['wd_host'] = sprintf('https://%s:%s@%s/wd/hub', $config['user'], $config['key'], $config['server']);
        return parent::buildDriver($config);
    }

    protected function getCapabilitiesNode()
    {
        $node = parent::getCapabilitiesNode();
        $node
            ->children()
                ->scalarNode('name')->end()
                ->scalarNode('build')->end()            
                ->booleanNode('record_video')->end()
                ->booleanNode('record_network')->end()
                ->scalarNode('max_duration')->end()
                ->scalarNode('os_api_name')->end()
                ->scalarNode('browser_api_name')->end()
                ->scalarNode('resolution')->end()
            ->end()
        ;
        return $node;
    }
}


