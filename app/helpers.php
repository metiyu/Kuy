<?php

if (!function_exists('convertCurrencyToInteger')) {
    /**
     * Convert formatted currency string to integer.
     *
     * @param string $currency
     * @return int
     */
    function convertCurrencyToInteger($currency)
    {
        // Remove 'Rp ' prefix
        $value = str_replace('Rp ', '', $currency);

        // Remove period (.) separators
        $value = str_replace('.', '', $value);

        // Convert to integer
        return (int) $value;
    }
}
