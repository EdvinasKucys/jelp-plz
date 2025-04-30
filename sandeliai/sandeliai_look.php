<?php

// sukuriame užklausų klasių objektus
$sandelisObj = new Warehouse();

$formErrors = null;
$data = array();

// nustatome privalomus laukus
$required = array('pavadinimas', 'adresas');

// maksimalūs leidžiami laukų ilgiai
$maxLengths = array (
	'pavadinimas' => 100,
    'adresas' => 200,
);

// paspaustas išsaugojimo mygtukas
if(!empty($_POST['submit'])) {
	// nustatome laukų validatorių tipus

    common::redirect("index.php?module={$module}&action=list");

} else {
	// tikriname, ar nurodytas elemento id. Jeigu taip, išrenkame elemento duomenis ir jais užpildome formos laukus.
	$data = $sandelisObj->getWarehousedProducts($id);
}

// įtraukiame šabloną
include "templates/{$module}/{$module}_look.tpl.php";

?>