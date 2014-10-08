<?php

trait PostalCodeMatcherTrait
{
    /**
     * @var string
     */
    protected $postalCodes;

    /**
     * @var string
     */
    protected $excludedPostalCodes;

    /**
     *
     */
    protected function matchPostalCode($postalCode)
    {
        if (empty($this->postalCodes)) {
            return true;
        }
        if (substr($this->postalCodes, 0, 1) == '/' && substr($this->postalCodes, -1, 1) == '/') {
            return preg_match($this->postalCodes, $postalCode);
        }

        $postalCodeList = $this->buildPostalCodeList($this->postalCodes);
        $excludedPostalCodeList = $this->buildPostalCodeList($this->excludedPostalCodes);

        return in_array($postalCode, $postalCodeList) && !in_array($postalCode, $excludedPostalCodeList);
    }

    /**
     *
     */
    protected function buildPostalCodeList($postalCodes)
    {
        $postalCodeList = explode(',', $postalCodes);
        foreach ($postalCodeList as $index => $postalCodeItem) {
            if (strpos($postalCodeItem, ':') !== false) {
                $postalCodeRange = explode(':', $postalCodeItem);
                $postalCodeRange = range($postalCodeRange[0], $postalCodeRange[1]);
                array_merge($postalCodeList, $postalCodeRange);
                unset($postalCodeList[$index]);
            }
        }

        return $postalCodeList;
    }
}
