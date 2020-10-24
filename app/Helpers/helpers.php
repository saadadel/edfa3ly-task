<?php

function currencySymbole($currency)
{
    $fmt = new NumberFormatter( "en-US@currency=$currency", NumberFormatter::CURRENCY );
    return $fmt->getSymbol(NumberFormatter::CURRENCY_SYMBOL);
}