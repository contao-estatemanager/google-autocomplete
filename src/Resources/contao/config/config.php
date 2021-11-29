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

if(ContaoEstateManager\GoogleAutocomplete\AddonManager::valid()) {
    // Add real estate filter items
    $GLOBALS['CEM_RFI']['locationGoogle'] = 'ContaoEstateManager\GoogleAutocomplete\FilterLocationGoogle';
    $GLOBALS['CEM_RFI']['radiusGoogle']   = 'ContaoEstateManager\GoogleAutocomplete\FilterRadiusGoogle';

    // Hooks
    $GLOBALS['TL_HOOKS']['getTypeParameter'][]         = array('ContaoEstateManager\GoogleAutocomplete\Filter', 'setLocationParameter');
    $GLOBALS['TL_HOOKS']['getParameterByGroups'][]     = array('ContaoEstateManager\GoogleAutocomplete\Filter', 'setLocationParameter');
    $GLOBALS['TL_HOOKS']['getParameterByTypes'][]      = array('ContaoEstateManager\GoogleAutocomplete\Filter', 'setLocationParameter');
    $GLOBALS['TL_HOOKS']['getTypeParameterByGroups'][] = array('ContaoEstateManager\GoogleAutocomplete\Filter', 'setLocationParameter');
    $GLOBALS['TL_HOOKS']['addRealEstateSorting'][]     = array('ContaoEstateManager\GoogleAutocomplete\Filter', 'addRealEstateSorting');
    $GLOBALS['TL_HOOKS']['prepareFilterData'][]        = array('ContaoEstateManager\GoogleAutocomplete\Filter', 'resetLocationFilter');
}
