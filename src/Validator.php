<?php

namespace LVR\State;

use Illuminate\Support\Str;

class Validator
{
    protected $params;

    protected $states = [
        "usa" => [
            ["abbr" => 'AL', "name" => 'Alabama'],
            ["abbr" => 'AK', "name" => 'Alaska'],
            ["abbr" => 'AZ', "name" => 'Arizona'],
            ["abbr" => 'AR', "name" => 'Arkansas'],
            ["abbr" => 'CA', "name" => 'California'],
            ["abbr" => 'CO', "name" => 'Colorado'],
            ["abbr" => 'CT', "name" => 'Connecticut'],
            ["abbr" => 'DC', "name" => 'District Of Columbia'],
            ["abbr" => 'DE', "name" => 'Delaware'],
            ["abbr" => 'FL', "name" => 'Florida'],
            ["abbr" => 'GA', "name" => 'Georgia'],
            ["abbr" => 'HI', "name" => 'Hawaii'],
            ["abbr" => 'ID', "name" => 'Idaho'],
            ["abbr" => 'IL', "name" => 'Illinois'],
            ["abbr" => 'IN', "name" => 'Indiana'],
            ["abbr" => 'IA', "name" => 'Iowa'],
            ["abbr" => 'KS', "name" => 'Kansas'],
            ["abbr" => 'KY', "name" => 'Kentucky'],
            ["abbr" => 'LA', "name" => 'Louisiana'],
            ["abbr" => 'ME', "name" => 'Maine'],
            ["abbr" => 'MD', "name" => 'Maryland'],
            ["abbr" => 'MA', "name" => 'Massachusetts'],
            ["abbr" => 'MI', "name" => 'Michigan'],
            ["abbr" => 'MN', "name" => 'Minnesota'],
            ["abbr" => 'MS', "name" => 'Mississippi'],
            ["abbr" => 'MO', "name" => 'Missouri'],
            ["abbr" => 'MT', "name" => 'Montana'],
            ["abbr" => 'NE', "name" => 'Nebraska'],
            ["abbr" => 'NV', "name" => 'Nevada'],
            ["abbr" => 'NH', "name" => 'New Hampshire'],
            ["abbr" => 'NJ', "name" => 'New Jersey'],
            ["abbr" => 'NM', "name" => 'New Mexico'],
            ["abbr" => 'NY', "name" => 'New York'],
            ["abbr" => 'NC', "name" => 'North Carolina'],
            ["abbr" => 'ND', "name" => 'North Dakota'],
            ["abbr" => 'OH', "name" => 'Ohio'],
            ["abbr" => 'OK', "name" => 'Oklahoma'],
            ["abbr" => 'OR', "name" => 'Oregon'],
            ["abbr" => 'PA', "name" => 'Pennsylvania'],
            ["abbr" => 'RI', "name" => 'Rhode Island'],
            ["abbr" => 'SC', "name" => 'South Carolina'],
            ["abbr" => 'SD', "name" => 'South Dakota'],
            ["abbr" => 'TN', "name" => 'Tennessee'],
            ["abbr" => 'TX', "name" => 'Texas'],
            ["abbr" => 'UT', "name" => 'Utah'],
            ["abbr" => 'VT', "name" => 'Vermont'],
            ["abbr" => 'VA', "name" => 'Virginia'],
            ["abbr" => 'WA', "name" => 'Washington'],
            ["abbr" => 'WV', "name" => 'West Virginia'],
            ["abbr" => 'WI', "name" => 'Wisconsin'],
            ["abbr" => 'WY', "name" => 'Wyoming'],
            ["abbr" => 'AS', "name" => 'American Samoa'],
            ["abbr" => 'FM', "name" => 'Federated States Of Micronesia'],
            ["abbr" => 'GU', "name" => 'Guam'],
            ["abbr" => 'MH', "name" => 'Marshall Islands'],
            ["abbr" => 'MP', "name" => 'Northern Mariana Islands'],
            ["abbr" => 'PW', "name" => 'Pala'],
            ["abbr" => 'PR', "name" => 'Puerto Rico'],
            ["abbr" => 'VI', "name" => 'Virgin Islands']
        ],
        "canada" => [
            ["abbr" => 'AB', "name" => 'Alberta'],
            ["abbr" => 'BC', "name" => 'British Columbia'],
            ["abbr" => 'MB', "name" => 'Manitoba'],
            ["abbr" => 'NB', "name" => 'New Brunswick'],
            ["abbr" => 'NL', "name" => 'Newfoundland And Labrador'],
            ["abbr" => 'NS', "name" => 'Nova Scotia'],
            ["abbr" => 'NT', "name" => 'Northwest Territories'],
            ["abbr" => 'NU', "name" => 'Nunavut'],
            ["abbr" => 'ON', "name" => 'Ontario'],
            ["abbr" => 'PE', "name" => 'Prince Edward Island'],
            ["abbr" => 'QC', "name" => 'Quebec'],
            ["abbr" => 'SK', "name" => 'Saskatchewan'],
            ["abbr" => 'YT', "name" => 'Yukon'],
        ],
    ];

    public function __construct(Parameters $params)
    {
        $this->params = $params;
    }

    public function validate($value)
    {
        return $value === null || $value === [] || (
            is_string($value) &&
            Str::length($value) > 0 &&
            $this->validateCountry($value) &&
            $this->validateCase($value) &&
            $this->validateType($value)
        );
    }

    protected function validateCountry($value)
    {
        $country = $this->params->getCountry();
        return $this->isAbbr($value, $country) || $this->isFull($value, $country);
    }

    protected function validateCase($value)
    {
        switch ($this->params->getCase()) {
            case 'lower':
                return $value === Str::lower($value);

            case 'upper':
                return $value === Str::upper($value);

            case 'title':
                return $this->isAbbr($value) ? $value === Str::upper($value) : $value === Str::title($value);

            default:
                return true;
        }
    }

    protected function validateType($value)
    {
        switch ($this->params->getType()) {
            case 'abbr':
                return $this->isAbbr($value);
            case 'full':
                return $this->isFull($value);
            default:
                return true;
        }
    }

    protected function isFull($value, $country = null)
    {
        return in_array(Str::title($value), $this->getStateNames($country));
    }

    protected function isAbbr($value, $country = null)
    {
        return in_array(Str::upper($value), $this->getStateAbbreviations($country));
    }

    protected function getStateAbbreviations($country = null)
    {
        $x = [];
        foreach ($this->states as $c => $states) {
            if ($country === null || $c === $country) {
                foreach ($states as $state) {
                    $x[] = $state['abbr'];
                }
            }
        }
        return $x;
    }

    protected function getStateNames($country = null)
    {
        $x = [];
        foreach ($this->states as $c => $states) {
            if ($country === null || $c === $country) {
                foreach ($states as $state) {
                    $x[] = $state['name'];
                }
            }
        }
        return $x;
    }
}
