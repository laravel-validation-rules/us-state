<?php

namespace LVR\State;

class Parameters
{
    protected $country = null;
    protected $case = null;
    protected $type = null;

    public function __construct($params)
    {
        $params = array_map('strtolower', $params);
        $this->country = $this->pullCountry($params);
        $this->case = $this->pullCase($params);
        $this->type = $this->pullType($params);
    }

    protected function pullCountry($params)
    {
        $z = null;
        $x = [
            "usa" => ["us", "usa"],
            "canada" => ["ca", "canada"],
        ];

        foreach ($x as $key => $possibilities) {
            foreach ($possibilities as $value) {
                $z = in_array($value, $params) ? $key : $z; 
            }
        }

        return $z;
    }

    protected function pullCase($params)
    {
        $z = null;
        $x = ["upper", "lower", "title"];

        foreach ($x as $value) {
            $z = in_array($value, $params) ? $value : $z;
        }

        return $z;
    }

    protected function pullType($params)
    {
        $z = null;
        $x = [
            "abbr" => ["abbr", "abbrev", "abbreviation"],
            "full" => ["full", "long", "whole"],
        ];

        foreach ($x as $key => $possibilities) {
            foreach ($possibilities as $value) {
                $z = in_array($value, $params) ? $key : $z;
            }
        }

        return $z;
    }

    public function getCountry()
    {
        return $this->country;
    }

    public function getCase()
    {
        return $this->case;
    }

    public function getType()
    {
        return $this->type;
    }
}
