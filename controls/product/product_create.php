<?php
	
// sukuriame užklausų klasių objektus
$prekesObj = new Product();
$sandeliaiObj = new Warehouse();
$gamintojaiObj = new Manufacturer();
$categoryObj = new Category();

$formErrors = null;
$data = array();
$data['sandelio_prekes'] = array();

// nustatome privalomus laukus
$required = array('pavadinimas', 'kaina', 'svoris', 'fk_GAMINTOJASgamintojo_id', 'fk_KATEGORIJAid_KATEGORIJA');

// maksimalūs leidžiami laukų ilgiai
$maxLengths = array (
	'pavadinimas' => 200,
	'aprasymas'=> 255,
	'medziaga'=> 100,
);

// paspaustas išsaugojimo mygtukas
if(!empty($_POST['submit'])) {
	// nustatome laukų validatorių tipus
	$validations = array (
		'pavadinimas' => 'anything',
		'kaina' => 'float',
		'svoris' => 'float',
		'medziaga'=> 'anything',
		'aprasymas'=> 'anything',
		'fk_GAMINTOJASgamintojo_id'=> 'anything',
		'fk_KATEGORIJAid_KATEGORIJA'=> 'int',
    );
	
	// sukuriame laukų validatoriaus objektą
	$validator = new validator($validations, $required, $maxLengths);

	// laukai įvesti be klaidų
	if($validator->validate($_POST)) {
		// įrašome naują prekę
		$prekesID = $prekesObj->insertProduct($_POST);

		// įrašome prekes į sandėlius
		if(isset($_POST['sandelis']) && !empty($_POST['sandelis'])) {
			foreach($_POST['sandelis'] as $keyForm => $sandelisForm) {
				if(!empty($sandelisForm) && !empty($_POST['kiekis'][$keyForm])) {
					$sandelisId = $sandelisForm;
					$sandeliaiObj->insertWarehouseProduct($prekesID, $sandelisId, $_POST['kiekis'][$keyForm]);
				}
			}
		}

		// nukreipiame vartotoją į prekių puslapį
		if($formErrors == null) {
			common::redirect("index.php?module={$module}&action=list");
			die();
		}
	} else {
		// gauname klaidų pranešimą
		$formErrors = $validator->getErrorHTML();

		// laukų reikšmių kintamajam priskiriame įvestų laukų reikšmes
		$data = $_POST;

		$data['sandelio_prekes'] = array();
		if(isset($_POST['sandelis'])) {
			$i = 0;
			foreach($_POST['sandelis'] as $key => $val) {
				if(!empty($val)) {
					$sandelisId = $val;
					
					$data['sandelio_prekes'][$i]['fk_SANDELISsandelio_id'] = $sandelisId;
					$data['sandelio_prekes'][$i]['kiekis'] = $_POST['kiekis'][$key];

					$i++;
				}
			}
		}
	}
}
array_unshift($data['sandelio_prekes'], array());

// Get the categories for dropdown
$kategorijos = $categoryObj->getCategoriesForSelect();

// įtraukiame šabloną
include "templates/prekes/prekes_form.tpl.php";

?>