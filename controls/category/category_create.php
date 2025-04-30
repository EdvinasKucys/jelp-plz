<?php

// sukuriame užklausų klasių objektus
$categoryObj = new Category();

$formErrors = null;
$data = array();

// nustatome privalomus laukus
$required = array('pavadinimas');

// maksimalūs leidžiami laukų ilgiai
$maxLengths = array (
	'pavadinimas' => 50,
    'aprasymas' => 255,
);

// paspaustas išsaugojimo mygtukas
if(!empty($_POST['submit'])) {
	// nustatome laukų validatorių tipus
	$validations = array (
		'pavadinimas' => 'anything',
		'aprasymas' => 'anything',
    );

	// sukuriame validatoriaus objektą
	$validator = new validator($validations, $required, $maxLengths);

	// laukai įvesti be klaidų
	if($validator->validate($_POST)) {
		// įrašome naują kategoriją
		$categoryObj->insertCategory($_POST);

		// nukreipiame į kategorijų puslapį
		common::redirect("index.php?module={$module}&action=list");
		die();
	} else {
		// gauname klaidų pranešimą
		$formErrors = $validator->getErrorHTML();
		// gauname įvestus laukus
		$data = $_POST;
	}
}

// įtraukiame šabloną
include "templates/kategorijos/kategorijos_form.tpl.php";

?>