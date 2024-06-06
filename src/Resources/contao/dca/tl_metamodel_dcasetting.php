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
 * @author     Stefan Heimes <stefan_heimes@hotmail.com>
 * @author     Andreas Isaak <info@andreas-isaak.de>
 * @author     Christopher Boelter <christopher@boelter.eu>
 * @author     Ingolf Steinhardt <info@e-spin.de>
 * @copyright  2012-2024 The MetaModels team.
 * @license    https://github.com/MetaModels/attribute_text/blob/master/LICENSE LGPL-3.0-or-later
 * @filesource
 */

use Contao\System;
use MetaModels\ContaoFrontendEditingBundle\MetaModelsContaoFrontendEditingBundle;

$GLOBALS['TL_DCA']['tl_metamodel_dcasetting']['metasubselectpalettes']['attr_id']['text'] = [
    'presentation' => [
        'tl_class',
        'be_template',
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
    'label'       => 'rgxp.label',
    'description' => 'rgxp.description',
    'exclude'     => true,
    'inputType'   => 'select',
    'reference'   => [
        'digit'       => 'rgxp_options.digit',
        'natural'     => 'rgxp_options.natural',
        'alpha'       => 'rgxp_options.alpha',
        'alnum'       => 'rgxp_options.alnum',
        'extnd'       => 'rgxp_options.extnd',
        'date'        => 'rgxp_options.date',
        'time'        => 'rgxp_options.time',
        'datim'       => 'rgxp_options.datim',
        'friendly'    => 'rgxp_options.friendly',
        'email'       => 'rgxp_options.email',
        'emails'      => 'rgxp_options.emails',
        'url'         => 'rgxp_options.url',
        'alias'       => 'rgxp_options.alias',
        'folderalias' => 'rgxp_options.folderalias',
        'phone'       => 'rgxp_options.phone',
        'prcnt'       => 'rgxp_options.prcnt',
        'locale'      => 'rgxp_options.locale',
        'language'    => 'rgxp_options.language',
        'fieldname'   => 'rgxp_options.fieldname',
    ],
    'eval'        => [
        'tl_class'           => 'clr w50',
        'includeBlankOption' => true,
        'helpwizard'         => true
    ],
    'explanation' => 'rgxp',
    'sql'         => 'varchar(10) NOT NULL default \'\'',
];

$GLOBALS['TL_DCA']['tl_metamodel_dcasetting']['fields']['readonly']['eval']['tl_class'] = 'w50 cbx m12';

// Load configuration for the frontend editing.
if (\in_array(
    MetaModelsContaoFrontendEditingBundle::class,
    System::getContainer()->getParameter('kernel.bundles'),
    true
)) {
    $GLOBALS['TL_DCA']['tl_metamodel_dcasetting']['metasubselectpalettes']['attr_id']['text']['presentation'][] =
        'fe_template';
}
