<?php
/**
 * The MetaModels extension allows the creation of multiple collections of custom items,
 * each with its own unique set of selectable attributes, with attribute extendability.
 * The Front-End modules allow you to build powerful listing and filtering of the
 * data in each collection.
 *
 * PHP version 5
 *
 * @package    MetaModels
 * @subpackage AttributeText
 * @author     Christopher Boelter <christopher@boelter.eu>
 * @copyright  The MetaModels team.
 * @license    LGPL.
 * @filesource
 */

use MetaModels\Attribute\Events\CreateAttributeFactoryEvent;
use MetaModels\Attribute\Text\AttributeTypeFactory;
use MetaModels\MetaModelsEvents;
use MetaModels\Events\MetaModelsBootEvent;
use MetaModels\DcGeneral\Events\Table\InputScreens\BackendSubscriber;

return array
(
    MetaModelsEvents::SUBSYSTEM_BOOT_BACKEND => array(
        function (MetaModelsBootEvent $event) {
            new BackendSubscriber($event->getServiceContainer());
        }
    ),
    MetaModelsEvents::ATTRIBUTE_FACTORY_CREATE => array(
        function (CreateAttributeFactoryEvent $event) {
            $factory = $event->getFactory();
            $factory->addTypeFactory(new AttributeTypeFactory());
        }
    )
);
