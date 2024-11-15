<?php
require "src/currency.php";

$currency = new Currency();

$currencies = $currency->getCurrencies();

require "resources/currency-converter.php";