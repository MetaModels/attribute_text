<?php

/**
 * This file is part of MetaModels/attribute_text.
 *
 * (c) 2012-2019 The MetaModels team.
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 *
 * This project is provided in good faith and hope to be usable by anyone.
 *
 * @package    MetaModels/attribute_text
 * @author     Christian Schiffler <c.schiffler@cyberspectrum.de>
 * @author     Stefan Heimes <stefan_heimes@hotmail.com>
 * @author     Andreas Isaak <info@andreas-isaak.de>
 * @author     Christopher Boelter <christopher@boelter.eu>
 * @author     Ingolf Steinhardt <info@e-spin.de>
 * @copyright  2012-2019 The MetaModels team.
 * @license    https://github.com/MetaModels/attribute_text/blob/master/LICENSE LGPL-3.0-or-later
 * @filesource
 */

$GLOBALS['TL_DCA']['tl_metamodel_dcasetting']['metasubselectpalettes']['attr_id']['text'] = [
    'presentation' => [
        'tl_class',
    ],
    'functions'    => [
        'mandatory',
        'allowHtml',
        'preserveTags',
        'decodeEntities',
        'trailingSlash',
        'spaceToUnderscore',
        'rgxp',
    ],
    'overview'     => [
        'filterable',
        'searchable',
    ]
];

$GLOBALS['TL_DCA']['tl_metamodel_dcasetting']['fields']['rgxp'] = [
    'label'     => &$GLOBALS['TL_LANG']['tl_metamodel_dcasetting']['rgxp'],
    'exclude'   => true,
    'inputType' => 'select',
    'sql'       => 'varchar(10) NOT NULL default \'\'',
    'eval'      => [
        'tl_class'           => 'clr',
        'includeBlankOption' => true
    ]
];
