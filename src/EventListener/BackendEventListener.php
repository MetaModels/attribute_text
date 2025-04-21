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
 * @author     Christian Schiffler <c.schiffler@cyberspectrum.de>
 * @author     Christopher Boelter <christopher@boelter.eu>
 * @author     Ingolf Steinhardt <info@e-spin.de>
 * @author     David Molineus <david.molineus@netzmacht.de>
 * @copyright  2012-2024 The MetaModels team.
 * @license    https://github.com/MetaModels/attribute_text/blob/master/LICENSE LGPL-3.0-or-later
 * @filesource
 */

namespace MetaModels\AttributeTextBundle\EventListener;

use ContaoCommunityAlliance\DcGeneral\Contao\View\Contao2BackendView\Event\GetPropertyOptionsEvent;
use ContaoCommunityAlliance\DcGeneral\DataDefinition\ContainerInterface;

/**
 * Handles event operations on tl_metamodel_dcasetting.
 */
class BackendEventListener
{
    /**
     * Retrieve the options for the attributes.
     *
     * @param GetPropertyOptionsEvent $event The event.
     *
     * @return void
     */
    public function getRgxpOptions(GetPropertyOptionsEvent $event)
    {
        $dataDefinition = $event->getEnvironment()->getDataDefinition();
        assert($dataDefinition instanceof ContainerInterface);

        if (
            ($dataDefinition->getName() !== 'tl_metamodel_dcasetting')
            || ($event->getPropertyName() !== 'rgxp')
        ) {
            return;
        }

        $options = [
            'digit'       => 'digit',
            'natural'     => 'natural',
            'alpha'       => 'alpha',
            'alnum'       => 'alnum',
            'extnd'       => 'extnd',
            'date'        => 'date',
            'time'        => 'time',
            'datim'       => 'datim',
            'friendly'    => 'friendly',
            'email'       => 'email',
            'emails'      => 'emails',
            'url'         => 'url',
            'alias'       => 'alias',
            'folderalias' => 'folderalias',
            'phone'       => 'phone',
            'prcnt'       => 'prcnt',
            'locale'      => 'locale',
            'language'    => 'language',
            'google+'     => 'google+',
            'fieldname'   => 'fieldname'
        ];

        $event->setOptions($options);
    }
}
