<?php

/**
 * This file is part of MetaModels/attribute_text.
 *
 * (c) 2012-2024 The MetaModels team.
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 *
 * This project is provided in good faith and hope to be usable by anyone.
 *
 * @package    MetaModels/attribute_text
 * @author     Ingolf Steinhardt <info@e-spin.de>
 * @copyright  2012-2024 The MetaModels team.
 * @license    https://github.com/MetaModels/attribute_text/blob/master/LICENSE LGPL-3.0-or-later
 * @filesource
 */

namespace MetaModels\AttributeTextBundle\DependencyInjection\CompilerPass;

use Symfony\Component\DependencyInjection\Compiler\CompilerPassInterface;
use Symfony\Component\DependencyInjection\ContainerBuilder;

/**
 * This pass adds the tagged factories to the MetaModels factories.
 */
class RegisterAttributeInFilterPass implements CompilerPassInterface
{
    public function process(ContainerBuilder $container): void
    {
        if ($container->hasDefinition('metamodels.filter_setting_factory.simplelookup')) {
            $container
                ->getDefinition('metamodels.filter_setting_factory.simplelookup')
                ->addMethodCall('addKnownAttributeType', ['text']);
        }

        if ($container->hasDefinition('metamodels.filter_setting_factory.select')) {
            $container
                ->getDefinition('metamodels.filter_setting_factory.select')
                ->addMethodCall('addKnownAttributeType', ['text']);
        }
    }
}
