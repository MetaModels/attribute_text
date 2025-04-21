<?php

/**
 * This file is part of MetaModels/attribute_text.
 *
 * (c) 2012-2021 The MetaModels team.
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 *
 * This project is provided in good faith and hope to be usable by anyone.
 *
 * @package    MetaModels/attribute_text
 * @author     Christian Schiffler <c.schiffler@cyberspectrum.de>
 * @author     Andreas Isaak <info@andreas-isaak.de>
 * @author     Christopher Boelter <christopher@boelter.eu>
 * @author     Ingolf Steinhardt <info@e-spin.de>
 * @author     David Molineus <david.molineus@netzmacht.de>
 * @copyright  2012-2021 The MetaModels team.
 * @license    https://github.com/MetaModels/attribute_text/blob/master/LICENSE LGPL-3.0-or-later
 * @filesource
 */

namespace MetaModels\AttributeTextBundle\Attribute;

use MetaModels\Attribute\BaseSimple;

/**
 * This is the MetaModelAttribute class for handling text fields.
 */
class Text extends BaseSimple
{
    /**
     * {@inheritDoc}
     *
     * @deprecated Do not use.
     */
    public function getSQLDataType()
    {
        // @codingStandardsIgnoreStart
        @trigger_error(
            'Class "' . __CLASS__ . '" is a managed attribute you should not call "' . __METHOD__ . '".',
            E_USER_DEPRECATED
        );
        // @codingStandardsIgnoreEnd

        return 'varchar(255) NULL';
    }

    /**
     * {@inheritdoc}
     */
    public function getAttributeSettingNames()
    {
        return array_merge(
            parent::getAttributeSettingNames(),
            [
                'isunique',
                'searchable',
                'filterable',
                'mandatory',
                'allowHtml',
                'preserveTags',
                'decodeEntities',
                'trailingSlash',
                'spaceToUnderscore',
                'rgxp'
            ]
        );
    }

    /**
     * {@inheritdoc}
     */
    public function getFieldDefinition($arrOverrides = [])
    {
        $arrFieldDef              = parent::getFieldDefinition($arrOverrides);
        $arrFieldDef['inputType'] = 'text';

        if ($arrOverrides['rgxp']) {
            $arrFieldDef['eval']['rgxp']      = $arrOverrides['rgxp'];
            $arrFieldDef['eval']['maxlength'] = '255';
        }

        return $arrFieldDef;
    }

    /**
     * {@inheritDoc}
     *
     * This is needed for compatibility with MySQL strict mode.
     */
    public function serializeData($value)
    {
        assert(\is_string($value) || $value === null);
        return $value === '' ? null : $value;
    }
}
