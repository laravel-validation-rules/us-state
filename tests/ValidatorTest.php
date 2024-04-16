<?php

namespace LVR\State\Tests;

use Illuminate\Contracts\Validation\Rule;
use LVR\State\Abbr;
use LVR\State\Full;
use Validator;
use Exception;

class ValidatorTest extends TestCase
{
    protected $abbrs = [
        'usa' => ['AL', 'AK', 'AZ', 'AR', 'CA', 'CO', 'CT', 'DC', 'DE', 'FL', 'GA', 'HI',
            'ID', 'IL', 'IN', 'IA', 'KS', 'KY', 'LA', 'ME', 'MD', 'MA', 'MI', 'MN', 'MS',
            'MO', 'MT', 'NE', 'NV', 'NH', 'NJ', 'NM', 'NY', 'NC', 'ND', 'OH', 'OK', 'OR',
            'PA', 'RI', 'SC', 'SD', 'TN', 'TX', 'UT', 'VT', 'VA', 'WA', 'WV', 'WI', 'WY',
            'AS', 'FM', 'GU', 'MH', 'MP', 'PW', 'PR', 'VI'],
        'canada' => ['AB', 'BC', 'MB', 'NB', 'NL', 'NS', 'NT', 'NU', 'ON', 'PE', 'QC', 'SK', 'YT'],
        'mexico' => ['AGU', 'BCN', 'BCS', 'CAM', 'CHP', 'CHH', 'CMX', 'COA', 'COL', 'DUR', 'GUA',
            'GRO', 'HID', 'JAL', 'MIC', 'MOR', 'MEX', 'NAY', 'NLE', 'OAX', 'PUE', 'QUE', 'ROO',
            'SLP', 'SIN', 'SON', 'TAB', 'TAM', 'TLA', 'VER', 'YUC', 'ZAC'],
        'nigeria' => ['AB', 'AD', 'AK', 'AN', 'BA', 'BY', 'BE', 'BO', 'CR', 'DE', 'EB', 'ED', 'EK',
            'EN', 'FC', 'GO', 'IM', 'JI', 'KD', 'KN', 'KT', 'KE', 'KO', 'LA', 'NA', 'NI', 'OG', 'ON',
            'OS', 'OY', 'PL', 'RI', 'SO', 'TA', 'YO', 'ZA'], 
];

    protected $names = [
        'usa' => ['Alabama', 'Alaska', 'Arizona', 'Arkansas', 'California', 'Colorado', 'Connecticut', 'District Of Columbia', 'Delaware', 'Florida', 'Georgia', 'Hawaii', 'Idaho', 'Illinois', 'Indiana', 'Iowa', 'Kansas', 'Kentucky', 'Louisiana', 'Maine', 'Maryland', 'Massachusetts', 'Michigan', 'Minnesota', 'Mississippi', 'Missouri', 'Montana', 'Nebraska', 'Nevada', 'New Hampshire', 'New Jersey', 'New Mexico', 'New York', 'North Carolina', 'North Dakota', 'Ohio', 'Oklahoma', 'Oregon', 'Pennsylvania', 'Rhode Island', 'South Carolina', 'South Dakota', 'Tennessee', 'Texas', 'Utah', 'Vermont', 'Virginia', 'Washington', 'West Virginia', 'Wisconsin', 'Wyoming', 'American Samoa', 'Federated States Of Micronesia', 'Guam', 'Marshall Islands', 'Northern Mariana Islands', 'Pala', 'Puerto Rico', 'Virgin Islands'],
        'canada' => [ 'Alberta', 'British Columbia', 'Manitoba', 'New Brunswick', 'Newfoundland And Labrador', 'Nova Scotia', 'Northwest Territories', 'Nunavut', 'Ontario', 'Prince Edward Island', 'Quebec', 'Saskatchewan', 'Yukon'],
        'mexico' => [ 'Aguascalientes', 'Baja California', 'Baja California Sur', 'Campeche', 'Chiapas', 'Chihuahua', 'Coahuila', 'Colima', 'Mexico City', 'Durango', 'Guanajuato', 'Guerrero', 'Hidalgo', 'Jalisco', 'México', 'Michoacán', 'Morelos', 'Nayarit', 'Nuevo León', 'Oaxaca', 'Puebla', 'Querétaro', 'Quintana Roo', 'San Luis Potosí', 'Sinaloa', 'Sonora', 'Tabasco', 'Tamaulipas', 'Tlaxcala', 'Veracruz', 'Yucatán', 'Zacatecas'],
        'nigeria' => ['Abia', 'Adamawa', 'Akwa Ibom', 'Anambra', 'Bauchi', 'Bayelsa', 'Benue', 'Borno', 'Cross River', 'Delta', 'Ebonyi', 'Edo', 'Ekiti', 'Enugu', 'Federal Capital Territory', 'Gombe', 'Imo', 'Jigawa', 'Kaduna', 'Kano', 'Katsina', 'Kebbi', 'Kogi', 'Lagos', 'Nasarawa', 'Niger', 'Ogun', 'Ondo', 'Osun', 'Oyo', 'Plateau', 'Rivers', 'Sokoto', 'Taraba', 'Yobe', 'Zamfara']
    ];

    protected function validate($value, Rule $rule)
    {
        return !(Validator::make(['attr' => $value], ['attr' => $rule])->fails());
    }

    public function testWithInvalidCountry()
    {
        $this->expectException(Exception::class);
        $this->validate("UT", new Abbr("ZZ"));
    }

    public function testValidatorSimple()
    {
        $this->assertEquals(true, $this->validate('UT', new Abbr));
        $this->assertEquals(true, $this->validate('ut', new Abbr));
        $this->assertEquals(true, $this->validate('Utah', new Full));
        $this->assertEquals(true, $this->validate('utah', new Full));
    }

    public function testValidatorUsa()
    {
        $this->assertEquals(true, $this->validate('UT', new Abbr("US")));
        $this->assertEquals(true, $this->validate('ut', new Abbr("US")));
        $this->assertEquals(true, $this->validate('Utah', new Full("US")));
        $this->assertEquals(true, $this->validate('utah', new Full("US")));

        $this->assertEquals(false, $this->validate('BC', new Abbr("US")));
        $this->assertEquals(false, $this->validate('bc', new Abbr("US")));
        $this->assertEquals(false, $this->validate('British Columbia', new Full("US")));
        $this->assertEquals(false, $this->validate('british columbia', new Full("US")));
    }

    public function testValidatorCanada()
    {
        $this->assertEquals(true, $this->validateAbbrs('canada', new Abbr("CA")));
        $this->assertEquals(true, $this->validate('bc', new Abbr("CA")));
        $this->assertEquals(true, $this->validate('British Columbia', new Full("CA")));
        $this->assertEquals(true, $this->validate('british columbia', new Full("CA")));

        $this->assertEquals(false, $this->validateAbbrs('usa', new Abbr("CA")));
        $this->assertEquals(false, $this->validate('ut', new Abbr("CA")));
        $this->assertEquals(false, $this->validate('Utah', new Full("CA")));
        $this->assertEquals(false, $this->validate('utah', new Full("CA")));
    }

    public function testValidatorMexico()
    {
        $this->assertEquals(true, $this->validateAbbrs('mexico', new Abbr("MX")));
        $this->assertEquals(true, $this->validate('son', new Abbr("MX")));
        $this->assertEquals(true, $this->validate('Sonora', new Full("MX")));
        $this->assertEquals(true, $this->validate('sonora', new Full("MX")));

        $this->assertEquals(false, $this->validateAbbrs('usa', new Abbr("MX")));
        $this->assertEquals(false, $this->validate('ut', new Abbr("MX")));
        $this->assertEquals(false, $this->validate('Utah', new Full("MX")));
        $this->assertEquals(false, $this->validate('utah', new Full("MX")));
    }

    public function testValidatorNigeria()
    {
        $this->assertEquals(true, $this->validateAbbrs('nigeria', new Abbr("NG")));
        $this->assertEquals(true, $this->validate('la', new Abbr("NG")));
        $this->assertEquals(true, $this->validate('Lagos', new Full("NG")));
        $this->assertEquals(true, $this->validate('lagos', new Full("NG")));

        $this->assertEquals(false, $this->validateAbbrs('usa', new Abbr("NG")));
        $this->assertEquals(false, $this->validate('ut', new Abbr("NG")));
        $this->assertEquals(false, $this->validate('Utah', new Full("NG")));
        $this->assertEquals(false, $this->validate('utah', new Full("NG")));
    }
    protected function validateAbbrs($country, $rule)
    {
        $x = true;
        foreach ($this->abbrs[$country] as $state) {
            $x = $x && $this->validate($state, $rule);
        }
        return $x;
    }

    protected function validateNames($country, $rule)
    {
        $x = true;
        foreach ($this->names[$country] as $state) {
            $y = $this->validate($state, $rule);
            if (!$y) {
                echo $state . PHP_EOL;
            }
            $x = $x && $y;
        }
        return $x;
    }
}
