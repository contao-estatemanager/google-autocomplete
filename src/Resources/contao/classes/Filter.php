<?php
/**
 * This file is part of Contao EstateManager.
 *
 * @link      https://www.contao-estatemanager.com/
 * @source    https://github.com/contao-estatemanager/reference
 * @copyright Copyright (c) 2019  Oveleon GbR (https://www.oveleon.de)
 * @license   https://www.contao-estatemanager.com/lizenzbedingungen.html
 */

namespace ContaoEstateManager\GoogleAutocomplete;

use Contao\Controller;
use ContaoEstateManager\Translator;

class Filter extends Controller
{

    /**
     * Table
     * @var string
     */
    protected $strTable = 'tl_real_estate';

    /**
     * Set google location filter parameters
     *
     * @param $arrColumns
     * @param $arrValues
     * @param $arrOptions
     * @param $mode
     * @param $addFragments
     * @param $objModule
     * @param $context
     */
    public function setLocationParameter(&$arrColumns, &$arrValues, &$arrOptions, $mode, $addFragments, $objModule, $context): void
    {
        if (!$addFragments)
        {
            return;
        }

        $t = $this->strTable;

        if (
            ($_SESSION['FILTER_DATA']['radius-google'] ?? null) &&
            ($_SESSION['FILTER_DATA']['latitude'] ?? null) &&
            ($_SESSION['FILTER_DATA']['longitude'] ?? null)
        )
        {
            $arrColumns[] = "(6371*acos(cos(radians(?))*cos(radians($t.breitengrad))*cos(radians($t.laengengrad)-radians(?))+sin(radians(?))*sin(radians($t.breitengrad)))) <= ?";
            $arrValues[] = $_SESSION['FILTER_DATA']['latitude'];
            $arrValues[] = $_SESSION['FILTER_DATA']['longitude'];
            $arrValues[] = $_SESSION['FILTER_DATA']['latitude'];
            $arrValues[] = $_SESSION['FILTER_DATA']['radius-google'];
        }
        else
        {
            if ($_SESSION['FILTER_DATA']['city'] ?? null)
            {
                $arrColumns[] = "$t.ort=?";
                $arrValues[] = $_SESSION['FILTER_DATA']['city'];
            }

            if ($_SESSION['FILTER_DATA']['postal'] ?? null)
            {
                $arrColumns[] = "$t.plz=?";
                $arrValues[] = $_SESSION['FILTER_DATA']['postal'];
            }

            if ($_SESSION['FILTER_DATA']['district'] ?? null)
            {
                $arrColumns[] = "$t.regionalerZusatz=?";
                $arrValues[] = $_SESSION['FILTER_DATA']['district'];
            }
        }

        if (isset($objModule) && $objModule->type === 'realEstateResultList' && $objModule->googleFilterAddSorting && ($_SESSION['SORTING'] ?? null) === 'location')
        {
            if ($objModule->googleFilterLat && $objModule->googleFilterLng)
            {
                $arrOptions['order'] = "(6371*acos(cos(radians($objModule->googleFilterLat))*cos(radians($t.breitengrad))*cos(radians($t.laengengrad)-radians($objModule->googleFilterLng))+sin(radians($objModule->googleFilterLat))*sin(radians($t.breitengrad)))) ASC";
            }
        }
    }

    /**
     * Add real estate location sorting option.
     *
     * @param $arrOptions
     * @param $objModule
     */
    public function addRealEstateSorting(&$arrOptions, $objModule): void
    {
        if ($objModule->googleFilterAddSorting)
        {
            $arrOptions['location'] = Translator::translateFilter('location');
        }
    }

    /**
     * Add real estate location sorting option.
     *
     * @param $arrSubmitted
     * @param $arrLabels
     * @param $context
     */
    public function resetLocationFilter($arrSubmitted, $arrLabels, $context): void
    {
        if ($_SESSION['FILTER_DATA']['location-google'] === '')
        {
            unset($_SESSION['FILTER_DATA']['country-short']);
            unset($_SESSION['FILTER_DATA']['city']);
            unset($_SESSION['FILTER_DATA']['postal']);
            unset($_SESSION['FILTER_DATA']['district']);
            unset($_SESSION['FILTER_DATA']['latitude']);
            unset($_SESSION['FILTER_DATA']['longitude']);

            unset($_POST['country-short']);
            unset($_POST['city']);
            unset($_POST['postal']);
            unset($_POST['district']);
            unset($_POST['latitude']);
            unset($_POST['longitude']);
        }
    }
}
