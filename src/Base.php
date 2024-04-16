<?php

namespace LVR\State;

use Illuminate\Contracts\Validation\Rule;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;

abstract class Base implements Rule
{
    protected $country;
    protected $subject;

    function __construct(string $country = null)
    {
        $v = Validator::make([
            "country" => $country,
        ], [

            "country" => "nullable|string|in:US,CA,MX,BR,NG",
        ]);

        if ($v->fails()) {
            throw new \Exception($v->errors()->first(), 1);
        }

        $this->country = $country;
        $this->subject = $this->getSubject($this->country);
    }
   
    protected function isFull($value, string $country = null): bool
    {
        return in_array(Str::title($value), $this->getStateNames($country));
    }

    protected function isAbbr($value, string $country = null): bool
    {
        return in_array(Str::upper($value), $this->getStateAbbreviations($country));
    }

    protected $states = [
        "US" => [
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
        "CA" => [
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
		"MX" => [
            ["abbr" => "AGU", "name" => "Aguascalientes"],
            ["abbr" => "BCN", "name" => "Baja California"],
            ["abbr" => "BCS", "name" => "Baja California Sur"],
            ["abbr" => "CAM", "name" => "Campeche"],
            ["abbr" => "CHP", "name" => "Chiapas"],
            ["abbr" => "CHH", "name" => "Chihuahua"],
            ["abbr" => "CMX", "name" => "Ciudad de México"],
            ["abbr" => "COA", "name" => "Coahuila de Zaragoza"],
            ["abbr" => "COL", "name" => "Colima"],
            ["abbr" => "DUR", "name" => "Durango"],
            ["abbr" => "GUA", "name" => "Guanajuato"],
            ["abbr" => "GRO", "name" => "Guerrero"],
            ["abbr" => "HID", "name" => "Hidalgo"],
            ["abbr" => "JAL", "name" => "Jalisco"],
            ["abbr" => "MIC", "name" => "Michoacán de Ocampo"],
            ["abbr" => "MOR", "name" => "Morelos"],
            ["abbr" => "MEX", "name" => "México"],
            ["abbr" => "NAY", "name" => "Nayarit"],
            ["abbr" => "NLE", "name" => "Nuevo León"],
            ["abbr" => "OAX", "name" => "Oaxaca"],
            ["abbr" => "PUE", "name" => "Puebla"],
            ["abbr" => "QUE", "name" => "Querétaro"],
            ["abbr" => "ROO", "name" => "Quintana Roo"],
            ["abbr" => "SLP", "name" => "San Luis Potosí"],
            ["abbr" => "SIN", "name" => "Sinaloa"],
            ["abbr" => "SON", "name" => "Sonora"],
            ["abbr" => "TAB", "name" => "Tabasco"],
            ["abbr" => "TAM", "name" => "Tamaulipas"],
            ["abbr" => "TLA", "name" => "Tlaxcala"],
            ["abbr" => "VER", "name" => "Veracruz de Ignacio de la Llave"],
            ["abbr" => "YUC", "name" => "Yucatán"],
            ["abbr" => "ZAC", "name" => "Zacatecas"],
        ],    
        "BR" => [
            ["abbr" => 'AC', "name" => 'Acre'],
	    ["abbr" => 'AL', "name" => 'Alagoas'],
	    ["abbr" => 'AP', "name" => 'Amapá'],
	    ["abbr" => 'AM', "name" => 'Amazonas'],
	    ["abbr" => 'BA', "name" => 'Bahia'],
	    ["abbr" => 'CE', "name" => 'Ceará'],
	    ["abbr" => 'DF', "name" => 'Distrito Federal'],
	    ["abbr" => 'ES', "name" => 'Espírito Santo'],
	    ["abbr" => 'GO', "name" => 'Goiás'],
	    ["abbr" => 'MA', "name" => 'Maranhão'],
	    ["abbr" => 'MT', "name" => 'Mato Grosso'],
	    ["abbr" => 'MS', "name" => 'Mato Grosso do Sul'],
	    ["abbr" => 'MG', "name" => 'Minas Gerais'],
	    ["abbr" => 'PA', "name" => 'Pará'],
	    ["abbr" => 'PB', "name" => 'Paraíba'],
	    ["abbr" => 'PR', "name" => 'Paraná'],
	    ["abbr" => 'PE', "name" => 'Pernambuco'],
	    ["abbr" => 'PI', "name" => 'Piauí'],
	    ["abbr" => 'RR', "name" => 'Roraima'],
	    ["abbr" => 'RO', "name" => 'Rondônia'],
	    ["abbr" => 'RJ', "name" => 'Rio de Janeiro'],
	    ["abbr" => 'RN', "name" => 'Rio Grande do Norte'],
	    ["abbr" => 'RS', "name" => 'Rio Grande do Sul'],
	    ["abbr" => 'SC', "name" => 'Santa Catarina'],
	    ["abbr" => 'SP', "name" => 'São Paulo'],
	    ["abbr" => 'SE', "name" => 'Sergipe'],
	    ["abbr" => 'TO', "name" => 'Tocantins'],
        ],
        "NG" => [
            ["abbr" => "AB", "name" => "Abia"],
            ["abbr" => "AD", "name" => "Adamawa"],
            ["abbr" => "AK", "name" => "Akwa Ibom"],
            ["abbr" => "AN", "name" => "Anambra"],
            ["abbr" => "BA", "name" => "Bauchi"],
            ["abbr" => "BY", "name" => "Bayelsa"],
            ["abbr" => "BE", "name" => "Benue"],
            ["abbr" => "BO", "name" => "Borno"],
            ["abbr" => "CR", "name" => "Cross River"],
            ["abbr" => "DE", "name" => "Delta"],
            ["abbr" => "EB", "name" => "Ebonyi"],
            ["abbr" => "ED", "name" => "Edo"],
            ["abbr" => "EK", "name" => "Ekiti"],
            ["abbr" => "EN", "name" => "Enugu"],
            ["abbr" => "FC", "name" => "Federal Capital Territory"],
            ["abbr" => "GO", "name" => "Gombe"],
            ["abbr" => "IM", "name" => "Imo"],
            ["abbr" => "JI", "name" => "Jigawa"],
            ["abbr" => "KD", "name" => "Kaduna"],
            ["abbr" => "KN", "name" => "Kano"],
            ["abbr" => "KT", "name" => "Katsina"],
            ["abbr" => "KE", "name" => "Kebbi"],
            ["abbr" => "KO", "name" => "Kogi"],
            ["abbr" => "LA", "name" => "Lagos"],
            ["abbr" => "NA", "name" => "Nasarawa"],
            ["abbr" => "NI", "name" => "Niger"],
            ["abbr" => "OG", "name" => "Ogun"],
            ["abbr" => "ON", "name" => "Ondo"],
            ["abbr" => "OS", "name" => "Osun"],
            ["abbr" => "OY", "name" => "Oyo"],
            ["abbr" => "PL", "name" => "Plateau"],
            ["abbr" => "RI", "name" => "Rivers"],
            ["abbr" => "SO", "name" => "Sokoto"],
            ["abbr" => "TA", "name" => "Taraba"],
            ["abbr" => "YO", "name" => "Yobe"],
            ["abbr" => "ZA", "name" => "Zamfara"],
        
        ]
    ];

    protected function getSubject(string $country = null): string
    {
        switch($country)
        {
            case "US":
            case "MX":
            case "BR":
            case "NG":
                return "State";
            case "CA":
                return "Province";
            default:
                return "State or Province";
        }
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

    /**
     * Determine if the validation rule passes.
     *
     * @param  string $attribute
     * @param  mixed  $value
     * @return bool
     */
    abstract public function passes($attribute, $value);

    /**
     * Get the validation error message.
     *
     * @return string
     */
    abstract public function message();
}
