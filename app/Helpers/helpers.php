<?php

// use NumberFormatter;

if (! function_exists('thousand_separator')) {
    /**
     * Format number dengan pemisah ribuan sesuai locale
     *
     * @param float|int $number
     * @param int $decimals
     * @param string|null $locale
     * @return string
     */
    function thousand_separator($number, $decimals = 0, $locale = null)
    {
        $locale = $locale ?? app()->getLocale(); // pakai locale default Laravel
        $formatter = new NumberFormatter($locale, NumberFormatter::DECIMAL);
        $formatter->setAttribute(NumberFormatter::FRACTION_DIGITS, $decimals);

        return $formatter->format($number);
    }
}

if (! function_exists('currency_format')) {
    /**
     * Format number ke currency sesuai locale & kode mata uang
     *
     * @param float|int $number
     * @param string $currencyCode (IDR, USD, EUR, dll)
     * @param string|null $locale
     * @return string
     */
    function currency_format($number, $currencyCode = 'IDR', $locale = null)
    {
        $locale = $locale ?? app()->getLocale(); // default pakai locale aplikasi
        $formatter = new NumberFormatter($locale, NumberFormatter::CURRENCY);

        return $formatter->formatCurrency($number, $currencyCode);
    }
}

