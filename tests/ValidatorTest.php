<?php

namespace LVR\State\Tests;

use Exception;
use LVR\State\Validator as StateValidator;
use LVR\State\Parameters;
use Validator;

class ValidatorTest extends TestCase
{
    protected $abbrs = [
        'usa' => ['AL', 'AK', 'AZ', 'AR', 'CA', 'CO', 'CT', 'DC', 'DE', 'FL', 'GA', 'HI',
            'ID', 'IL', 'IN', 'IA', 'KS', 'KY', 'LA', 'ME', 'MD', 'MA', 'MI', 'MN', 'MS',
            'MO', 'MT', 'NE', 'NV', 'NH', 'NJ', 'NM', 'NY', 'NC', 'ND', 'OH', 'OK', 'OR',
            'PA', 'RI', 'SC', 'SD', 'TN', 'TX', 'UT', 'VT', 'VA', 'WA', 'WV', 'WI', 'WY',
            'AS', 'FM', 'GU', 'MH', 'MP', 'PW', 'PR', 'VI'],
        'canada' => ['AB', 'BC', 'MB', 'NB', 'NL', 'NS', 'NT', 'NU', 'ON', 'PE', 'QC', 'SK', 'YT'],
    ];

    protected $names = [
        'usa' => ['Alabama', 'Alaska', 'Arizona', 'Arkansas', 'California', 'Colorado', 'Connecticut', 'District Of Columbia', 'Delaware', 'Florida', 'Georgia', 'Hawaii', 'Idaho', 'Illinois', 'Indiana', 'Iowa', 'Kansas', 'Kentucky', 'Louisiana', 'Maine', 'Maryland', 'Massachusetts', 'Michigan', 'Minnesota', 'Mississippi', 'Missouri', 'Montana', 'Nebraska', 'Nevada', 'New Hampshire', 'New Jersey', 'New Mexico', 'New York', 'North Carolina', 'North Dakota', 'Ohio', 'Oklahoma', 'Oregon', 'Pennsylvania', 'Rhode Island', 'South Carolina', 'South Dakota', 'Tennessee', 'Texas', 'Utah', 'Vermont', 'Virginia', 'Washington', 'West Virginia', 'Wisconsin', 'Wyoming', 'American Samoa', 'Federated States Of Micronesia', 'Guam', 'Marshall Islands', 'Northern Mariana Islands', 'Pala', 'Puerto Rico', 'Virgin Islands'],
        'canada' => [ 'Alberta', 'British Columbia', 'Manitoba', 'New Brunswick', 'Newfoundland And Labrador', 'Nova Scotia', 'Northwest Territories', 'Nunavut', 'Ontario', 'Prince Edward Island', 'Quebec', 'Saskatchewan', 'Yukon',],
    ];

    public function testItCreatesAnInstanceOfStateValidator()
    {
        $obj = new StateValidator(new Parameters([]));
        $this->assertInstanceOf(StateValidator::class, $obj);
    }

    protected function validate($value, $rule = 'state')
    {
        return !(Validator::make(['attr' => $value], ['attr' => $rule])->fails());
    }

    public function testValidatorSimple()
    {
        $this->assertEquals(true, $this->validate('UT', 'state'));
        $this->assertEquals(true, $this->validate('ut', 'state'));
        $this->assertEquals(true, $this->validate('Utah', 'state'));
        $this->assertEquals(true, $this->validate('utah', 'state'));
    }

    public function testValidatorUsa()
    {
        $this->assertEquals(true, $this->validate('UT', 'state:usa'));
        $this->assertEquals(true, $this->validate('ut', 'state:usa'));
        $this->assertEquals(true, $this->validate('Utah', 'state:usa'));
        $this->assertEquals(true, $this->validate('utah', 'state:usa'));

        $this->assertEquals(false, $this->validate('BC', 'state:usa'));
        $this->assertEquals(false, $this->validate('bc', 'state:usa'));
        $this->assertEquals(false, $this->validate('British Columbia', 'state:usa'));
        $this->assertEquals(false, $this->validate('british columbia', 'state:usa'));
    }

    public function testValidatorCanada()
    {
        $this->assertEquals(true, $this->validateAbbrs('canada', 'state:canada'));
        $this->assertEquals(true, $this->validate('bc', 'state:canada'));
        $this->assertEquals(true, $this->validate('British Columbia', 'state:canada'));
        $this->assertEquals(true, $this->validate('british columbia', 'state:canada'));

        $this->assertEquals(false, $this->validateAbbrs('usa', 'state:canada'));
        $this->assertEquals(false, $this->validate('ut', 'state:canada'));
        $this->assertEquals(false, $this->validate('Utah', 'state:canada'));
        $this->assertEquals(false, $this->validate('utah', 'state:canada'));
    }

    public function testValidatorUppercase()
    {
        $this->assertEquals(true, $this->validateAbbrs('usa', 'state:upper'));
        $this->assertEquals(true, $this->validateAbbrs('canada', 'state:upper'));
        $this->assertEquals(true, $this->validate('UTAH', 'state:upper'));
        $this->assertEquals(true, $this->validate('BRITISH COLUMBIA', 'state:upper'));

        $this->assertEquals(false, $this->validate('ut', 'state:upper'));
        $this->assertEquals(false, $this->validate('Utah', 'state:upper'));
        $this->assertEquals(false, $this->validate('utah', 'state:upper'));
        $this->assertEquals(false, $this->validate('bc', 'state:upper'));
        $this->assertEquals(false, $this->validate('British Columbia', 'state:upper'));
        $this->assertEquals(false, $this->validate('british columbia', 'state:upper'));
    }

    public function testValidatorLowercase()
    {
        $this->assertEquals(true, $this->validate('ut', 'state:lower'));
        $this->assertEquals(true, $this->validate('utah', 'state:lower'));
        $this->assertEquals(true, $this->validate('bc', 'state:lower'));
        $this->assertEquals(true, $this->validate('british columbia', 'state:lower'));

        $this->assertEquals(false, $this->validateAbbrs('usa', 'state:lower'));
        $this->assertEquals(false, $this->validateAbbrs('canada', 'state:lower'));
        $this->assertEquals(false, $this->validate('Utah', 'state:lower'));
        $this->assertEquals(false, $this->validate('UTAH', 'state:lower'));
        $this->assertEquals(false, $this->validate('British Columbia', 'state:lower'));
        $this->assertEquals(false, $this->validate('BRITISH COLUMBIA', 'state:lower'));
    }

    public function testValidatorTitlecase()
    {
        $this->assertEquals(true, $this->validateAbbrs('usa', 'state:title'));
        $this->assertEquals(true, $this->validateAbbrs('canada', 'state:title'));
        $this->assertEquals(true, $this->validateNames('usa', 'state:title'));
        $this->assertEquals(true, $this->validateNames('canada', 'state:title'));

        $this->assertEquals(false, $this->validate('ut', 'state:title'));
        $this->assertEquals(false, $this->validate('UTAH', 'state:title'));
        $this->assertEquals(false, $this->validate('utah', 'state:title'));
        $this->assertEquals(false, $this->validate('bc', 'state:title'));
        $this->assertEquals(false, $this->validate('BRITISH COLUMBIA', 'state:title'));
        $this->assertEquals(false, $this->validate('british columbia', 'state:title'));
    }


    public function testValidatorUppercaseAbreviatedUsaStates()
    {
        $this->assertEquals(true, $this->validateAbbrs('usa', 'state:upper,abbr,usa'));

        $this->assertEquals(false, $this->validateAbbrs('canada', 'state:upper,abbr,usa'));
        $this->assertEquals(false, $this->validate('BC', 'state:upper,abbr,usa'));
        $this->assertEquals(false, $this->validate('Utah', 'state:upper,abbr,usa'));
        $this->assertEquals(false, $this->validate('British Columbia', 'state:upper,abbr,usa'));
        $this->assertEquals(false, $this->validate('ut', 'state:upper,abbr,usa'));
        $this->assertEquals(false, $this->validate('UTAH', 'state:upper,abbr,usa'));
        $this->assertEquals(false, $this->validate('utah', 'state:upper,abbr,usa'));
        $this->assertEquals(false, $this->validate('bc', 'state:upper,abbr,usa'));
        $this->assertEquals(false, $this->validate('BRITISH COLUMBIA', 'state:upper,abbr,usa'));
        $this->assertEquals(false, $this->validate('british columbia', 'state:upper,abbr,usa'));
    }

    public function testValidatorUppercaseAbreviatedCanadaStates()
    {
        $this->assertEquals(true, $this->validateAbbrs('canada', 'state:upper,abbr,canada'));

        $this->assertEquals(false, $this->validateAbbrs('usa', 'state:upper,abbr,canada'));
        $this->assertEquals(false, $this->validate('Utah', 'state:upper,abbr,canada'));
        $this->assertEquals(false, $this->validate('British Columbia', 'state:upper,abbr,canada'));
        $this->assertEquals(false, $this->validate('ut', 'state:upper,abbr,canada'));
        $this->assertEquals(false, $this->validate('UTAH', 'state:upper,abbr,canada'));
        $this->assertEquals(false, $this->validate('utah', 'state:upper,abbr,canada'));
        $this->assertEquals(false, $this->validate('bc', 'state:upper,abbr,canada'));
        $this->assertEquals(false, $this->validate('BRITISH COLUMBIA', 'state:upper,abbr,canada'));
        $this->assertEquals(false, $this->validate('british columbia', 'state:upper,abbr,canada'));
    }

    public function testValidatorWithEmpty()
    {
        $this->assertEquals(false, $this->validate(null, 'required|state'));
        $this->assertEquals(false, $this->validate('', 'required|state'));
        $this->assertEquals(false, $this->validate([], 'required|state'));
        $this->assertEquals(false, $this->validate(false, 'required|state'));

        $this->assertEquals(true, $this->validate(null, 'state'));
        $this->assertEquals(true, $this->validate('', 'state'));
        $this->assertEquals(true, $this->validate([], 'state'));
        $this->assertEquals(false, $this->validate(false, 'state'));
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
