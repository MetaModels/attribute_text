<?php

/**
 * This file is part of MetaModels/attribute_text.
 *
 * (c) 2012-2017 The MetaModels team.
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 *
 * This project is provided in good faith and hope to be usable by anyone.
 *
 * @package    MetaModels
 * @subpackage AttributeText
 * @author     Christian Schiffler <c.schiffler@cyberspectrum.de>
 * @author     Christopher Boelter <christopher@boelter.eu>
 * @author     Ingolf Steinhardt <info@e-spin.de>
 * @copyright  2012-2017 The MetaModels team.
 * @license    https://github.com/MetaModels/attribute_text/blob/master/LICENSE LGPL-3.0
 * @filesource
 */

namespace MetaModels\Attribute\Text;

use Doctrine\DBAL\Driver\Connection;
use MetaModels\Attribute\AbstractAttributeTypeFactory;
use MetaModels\Helper\TableManipulator;

/**
 * Attribute type factory for text attributes.
 */
class AttributeTypeFactory extends AbstractAttributeTypeFactory
{
    /**
     * The connection.
     *
     * @var Connection
     */
    private $connection;

    /**
     * The table manipulator.
     *
     * @var TableManipulator
     */
    private $tableManipulator;

    /**
     * {@inheritDoc}
     *
     * @param Connection       $connection       The database connection.
     * @param TableManipulator $tableManipulator The table manipulator.
     */
    public function __construct(Connection $connection, TableManipulator $tableManipulator)
    {
        parent::__construct();
        $this->connection       = $connection;
        $this->tableManipulator = $tableManipulator;

        $this->typeName  = 'text';
        $this->typeIcon  = 'bundles/metamodelsattributetextbundle/text.png';
        $this->typeClass = 'MetaModels\Attribute\Text\Text';
    }

    /**
     * {@inheritdoc}
     */
    public function createInstance($information, $metaModel)
    {
        return new $this->typeClass(
            $metaModel,
            $information,
            $this->connection,
            $this->tableManipulator
        );
    }
}
