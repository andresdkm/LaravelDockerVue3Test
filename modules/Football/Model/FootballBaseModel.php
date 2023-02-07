<?php

namespace Modules\Football\Model;

use Illuminate\Support\Facades\Log;

abstract class FootballBaseModel
{
    public function decode(array $data)
    {
        foreach ($data as $key => $val) {
            if (property_exists($this, $key)) {
                $this->$key = $val;
            } else {
                $key = $this->convertName($key);
                if (property_exists($this, $key)) {
                    $this->$key = $val;
                }
            }
        }
    }

    public function toArray(){
        return $this->parseToArray($this);
    }

    private function parseToArray($data)
    {
        if (is_array($data) || is_object($data)) {
            $result = [];
            foreach ($data as $key => $value) {
                $result[$key] = (is_array($value) || is_object($value)) ? $this->parseToArray($value) : $value;
            }
            return $result;
        }
        return $data;
    }

    private function convertName($string): string
    {
        return strtolower(preg_replace(['/([a-z\d])([A-Z])/', '/([^_])([A-Z][a-z])/'], '$1_$2', $string));
    }
}
