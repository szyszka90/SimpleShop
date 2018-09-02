<?php

namespace App\Service;

class LocaleInformation
{
    const INTERNATIONAL_CURRENCY_SYMBOL = 'int_curr_symbol';

    /**
     * @var string
     */
    private $locale;

    public function __construct(string $locale)
    {
        $this->locale = $locale;
        setlocale(LC_ALL, $locale);
    }

    public function getLocaleInformation(string $field)
    {
        $localeInformation = localeconv();

        return trim($localeInformation[$field]);
    }
}