<?php

return [
    /***
     * This code prevents the duplication of records for the same entity (accountable, reference)
     * while considering the transaction type (deposit or withdrawal).
     * Set this "false" if you went to disable it.
     * You have to config it before migration.
     **/
    "prevent_duplication" => true,
    "currency_precision" => 2
];
