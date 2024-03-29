<?php
/**
 * This file is part of Contao EstateManager.
 *
 * @link      https://www.contao-estatemanager.com/
 * @source    https://github.com/contao-estatemanager/googlemaps
 * @copyright Copyright (c) 2019  Oveleon GbR (https://www.oveleon.de)
 * @license   https://www.contao-estatemanager.com/lizenzbedingungen.html
 */

namespace ContaoEstateManager\GoogleAutocomplete;


use ContaoEstateManager\FilterModel;
use ContaoEstateManager\FilterSession;
use ContaoEstateManager\FilterWidget;

/**
 * Class FilterLocationGoogle
 *
 * @author Fabian Ekert <fabian@oveleon.de>
 * @author Daniele Sciannimanica <https://github.com/doishub>
 */
class FilterLocationGoogle extends FilterWidget
{

    /**
     * Submit user input
     *
     * @var boolean
     */
    protected $blnSubmitInput = true;

    /**
     * Template
     *
     * @var string
     */
    protected $strTemplate = 'filter_location_google';

    /**
     * The CSS class prefix
     *
     * @var string
     */
    protected $strPrefix = 'widget widget-location-google';

    /**
     * Initialize the object
     *
     * @param array       $arrAttributes Attributes array
     * @param FilterModel $objFilter     Parent filter model
     */
    public function __construct($arrAttributes, $objFilter=null)
    {
        parent::__construct($arrAttributes, $objFilter);
    }

    /**
     * Add specific attributes
     *
     * @param string $strKey   The attribute key
     * @param mixed  $varValue The attribute value
     */
    public function __set($strKey, $varValue)
    {
        switch ($strKey)
        {
            case 'name':
                $this->strName = 'location-google';
                break;

            case 'mandatory':
                if ($varValue)
                {
                    $this->arrAttributes['required'] = 'required';
                }
                else
                {
                    unset($this->arrAttributes['required']);
                }
                parent::__set($strKey, $varValue);
                break;

            case 'placeholder':
                break;

            default:
                parent::__set($strKey, $varValue);
                break;
        }
    }

    /**
     * Parse the template file and return it as string
     *
     * @param array $arrAttributes An optional attributes array
     *
     * @return string The template markup
     */
    public function parse($arrAttributes=null): string
    {
        $this->value = $_SESSION['FILTER_DATA']['location-google'] ?? null;
        $this->valueCountry = $_SESSION['FILTER_DATA']['country-short'] ?? null;
        $this->valueCity = $_SESSION['FILTER_DATA']['city'] ?? null;
        $this->valuePostal = $_SESSION['FILTER_DATA']['postal'] ?? null;
        $this->valueDistrict = $_SESSION['FILTER_DATA']['district'] ?? null;
        $this->valueLatitude = $_SESSION['FILTER_DATA']['latitude'] ?? null;
        $this->valueLongitude = $_SESSION['FILTER_DATA']['longitude'] ?? null;

        $types = $this->googleAutocompleteType === 'regions' ? '('.$this->googleAutocompleteType.')' : $this->googleAutocompleteType;

        $objFilterSession = FilterSession::getInstance();

        $this->config = '{"initInstant":true,"types":"'.$types.'","defaultRadius":'.$this->googleDefaultRadius.',"forceRadius":'.($this->googleForceRadius ? 1 : 0).',"defaultCountry":"'.$objFilterSession->getRootLanguage().'"}';

        return parent::parse($arrAttributes);
    }

    /**
     * Rudimentary generate method
     */
    public function generate() {}
}
