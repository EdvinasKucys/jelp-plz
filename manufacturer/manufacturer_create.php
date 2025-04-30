<?php

// sukuriame užklausų klasių objektus
$gamintojasObj = new Manufacturer();

$formErrors = null;
$data = array();

// nustatome privalomus laukus
$required = array('pavadinimas', 'salis', 'kontaktai');

// maksimalūs leidžiami laukų ilgiai
$maxLengths = array (
	'pavadinimas' => 200,
    'salis' => 50,
    'kontaktai'=> 255,
);

// paspaustas išsaugojimo mygtukas
if(!empty($_POST['submit'])) {
	// nustatome laukų validatorių tipus
	$validations = array (
		'pavadinimas' => 'anything',
		'salis' => 'anything',
        'kontaktai'=> 'anything',
    );

	// sukuriame validatoriaus objektą
	$validator = new validator($validations, $required, $maxLengths);

	// laukai įvesti be klaidų
	if($validator->validate($_POST)) {
		// atnaujiname duomenis
		$gamintojasObj->insertManufacturer($_POST);

		// nukreipiame į modelių puslapį
		common::redirect("index.php?module={$module}&action=list");
		die();
	} else {
		// gauname klaidų pranešimą
		$formErrors = $validator->getErrorHTML();
		// gauname įvestus laukus
		$data = $_POST;
	}
} else {
	// tikriname, ar nurodytas elemento id. Jeigu taip, išrenkame elemento duomenis ir jais užpildome formos laukus.
	if(!empty($id)) {
		$data = $gamintojasObj->getManufacturer($id);
	}
}

// įtraukiame šabloną
include "templates/{$module}/{$module}_form.tpl.php";

?>