<?php
// File: app/helpers.php
if (!function_exists('generateUniqueNumber')) {
    function generateUniqueNumber($modelName, $prefix, $columnName)
    {
        if (strpos($modelName, 'App\\') === 0) {
            $model = $modelName;
        } else {
            $model = "App\\" . $modelName; // Assuming all models are within the App namespace
        }

        $latestInvoice = $model::latest()->first();
        if ($latestInvoice) {
            $invoiceNumber = preg_replace('/^' . preg_quote($prefix, '/') . '/', '', $latestInvoice->$columnName);
            $invoiceNumber++;
        } else {
            $invoiceNumber = 1;
        }

        if ($invoiceNumber < 10) {
            $invoiceNumber = $prefix . "000" . $invoiceNumber;
        } elseif ($invoiceNumber < 100) {
            $invoiceNumber = $prefix . "00" . $invoiceNumber;
        } elseif ($invoiceNumber < 1000) {
            $invoiceNumber = $prefix . "0" . $invoiceNumber;
        } else {
            $invoiceNumber = $prefix . $invoiceNumber;
        }

        return $invoiceNumber;
    }

}

