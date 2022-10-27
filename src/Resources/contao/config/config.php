<?php
/**
 * This file is part of Contao EstateManager.
 *
 * @link      https://www.contao-estatemanager.com/
 * @source    https://github.com/contao-estatemanager
 * @copyright Copyright (c) 2019  Oveleon GbR (https://www.oveleon.de)
 * @license   https://www.contao-estatemanager.com/lizenzbedingungen.html
 */

// ESTATEMANAGER
$GLOBALS['TL_ESTATEMANAGER_ADDONS'][] = array('ContaoEstateManager\GoogleAutocomplete', 'AddonManager');

use ContaoEstateManager\GoogleAutocomplete\AddonManager;
use ContaoEstateManager\GoogleAutocomplete\Filter;
use ContaoEstateManager\GoogleAutocomplete\FilterLocationGoogle;
use ContaoEstateManager\GoogleAutocomplete\FilterRadiusGoogle;

if(AddonManager::valid()) {
    // Add real estate filter items
    $GLOBALS['TL_RFI']['locationGoogle'] = FilterLocationGoogle::class;
    $GLOBALS['TL_RFI']['radiusGoogle']   = FilterRadiusGoogle::class;

    // Hooks
    $GLOBALS['TL_HOOKS']['getTypeParameter'][]         = array(Filter::class, 'setLocationParameter');
    $GLOBALS['TL_HOOKS']['getParameterByGroups'][]     = array(Filter::class, 'setLocationParameter');
    $GLOBALS['TL_HOOKS']['getParameterByTypes'][]      = array(Filter::class, 'setLocationParameter');
    $GLOBALS['TL_HOOKS']['getTypeParameterByGroups'][] = array(Filter::class, 'setLocationParameter');
    $GLOBALS['TL_HOOKS']['addRealEstateSorting'][]     = array(Filter::class, 'addRealEstateSorting');
    $GLOBALS['TL_HOOKS']['prepareFilterData'][]        = array(Filter::class, 'resetLocationFilter');
}
