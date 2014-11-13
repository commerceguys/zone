<?php

namespace CommerceGuys\Zone\Model;

/**
 * Matches a postal code against inclusive and exclusive rules.
 */
trait PostalCodeMatcherTrait
{
    /**
     * The included postal codes.
     *
     * Can be a regular expression ("/(35|38)[0-9]{3}/") or a comma-separated
     * list of postal codes, including ranges ("98, 100:200, 250").
     *
     * @var string
     */
    protected $includedPostalCodes;

    /**
     * The excluded postal codes.
     *
     * Can be a regular expression ("/(35|38)[0-9]{3}/") or a comma-separated
     * list of postal codes, including ranges ("98, 100:200, 250").
     *
     * @var string
     */
    protected $excludedPostalCodes;

    /**
     * Gets the included postal codes.
     *
     * @return string The included postal codes.
     */
    public function getIncludedPostalCodes()
    {
        return $this->includedPostalCodes;
    }

    /**
     * Sets the included postal codes.
     *
     * @param string $includedPostalCodes The included postal codes.
     */
    public function setIncludedPostalCodes($includedPostalCodes)
    {
        $this->includedPostalCodes = $includedPostalCodes;

        return $this;
    }

    /**
     * Gets the excluded postal codes.
     *
     * @return string The excluded postal codes.
     */
    public function getExcludedPostalCodes()
    {
        return $this->excludedPostalCodes;
    }

    /**
     * Sets the excluded postal codes.
     *
     * @param string $excludedPostalCodes The excluded postal codes.
     */
    public function setExcludedPostalCodes($excludedPostalCodes)
    {
        $this->excludedPostalCodes = $excludedPostalCodes;

        return $this;
    }

    /**
     * Checks whether the provided postal code matches the configured rules.
     *
     * @param string $postalCode The postal code.
     *
     * @return bool True if the provided postal code matches the configured
     *              rules, false otherwise.
     */
    protected function matchPostalCode($postalCode)
    {
        if (empty($this->includedPostalCodes)) {
            $matchIncluded = true;
        } elseif (substr($this->includedPostalCodes, 0, 1) == '/' && substr($this->includedPostalCodes, -1, 1) == '/') {
            $matchIncluded = preg_match($this->includedPostalCodes, $postalCode);
        } else {
            $includedPostalCodeList = $this->buildPostalCodeList($this->includedPostalCodes);
            $matchIncluded = in_array($postalCode, $includedPostalCodeList);
        }

        if (empty($this->excludedPostalCodes)) {
            $matchExcluded = false;
        } elseif (substr($this->excludedPostalCodes, 0, 1) == '/' && substr($this->excludedPostalCodes, -1, 1) == '/') {
            $matchExcluded = preg_match($this->excludedPostalCodes, $postalCode);
        } else {
            $excludedPostalCodeList = $this->buildPostalCodeList($this->excludedPostalCodes);
            $matchExcluded = in_array($postalCode, $excludedPostalCodeList);
        }

        return $matchIncluded && !$matchExcluded;
    }

    /**
     * Builds a list of postal codes from the provided string.
     *
     * Expands any ranges into full values (e.g. "1:3" becomes "1, 2, 3").
     *
     * @param string $postalCodes The postal codes.
     *
     * @return array The list of postal codes.
     */
    protected function buildPostalCodeList($postalCodes)
    {
        $postalCodeList = explode(',', $postalCodes);
        foreach ($postalCodeList as $index => &$postalCodeItem) {
            $postalCodeItem = trim($postalCodeItem);
            if (strpos($postalCodeItem, ':') !== false) {
                $postalCodeRange = explode(':', $postalCodeItem);
                if (is_numeric($postalCodeRange[0]) && is_numeric($postalCodeRange[1])) {
                    $postalCodeRange = range($postalCodeRange[0], $postalCodeRange[1]);
                    $postalCodeList = array_merge($postalCodeList, $postalCodeRange);
                }
                unset($postalCodeList[$index]);
            }
        }

        return $postalCodeList;
    }
}
