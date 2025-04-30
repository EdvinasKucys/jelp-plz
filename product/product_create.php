<?php
	
// sukuriame užklausų klasių objektus
$prekesObj = new Product();
$sandeliaiObj = new Warehouse();
$gamintojaiObj = new Manufacturer();


$formErrors = null;
$data = array();
$data['sandeliuojama_preke'] = array();

// nustatome privalomus laukus
$required = array('pavadinimas', 'kaina', 'svoris', 'gamintojas', 'kategorija', 'fk_GAMINTOJASgamintojo_id', 'fk_KATEGORIJAid_KATEGORIJA');

// maksimalūs leidžiami laukų ilgiai
$maxLengths = array (
	'pavadinimas' => 200,
	'kategorija' => 50,
	'gamintojas'=> 200,
	'medziaga'=> 100,
	'aprasymas'=> 255,
	'fk_Gamintojasid_Gamintojas'=> 64,
	'fk_KATEGORIJAid_KATEGORIJA'=> 11,
);

// paspaustas išsaugojimo mygtukas
if(!empty($_POST['submit'])) {
	// nustatome laukų validatorių tipus
	$validations = array (
		'pavadinimas' => 'anything',
		'kaina' => 'float',
		'svoris' => 'float',
		'kategorija' => 'alfnum',
		'gamintojas'=> 'alfnum',
		'medziaga'=> 'alfnum',
		'aprasymas'=> 'anything',
		'fk_Gamintojasid_Gamintojas'=> 'alfnum',
		'fk_KATEGORIJAid_KATEGORIJA'=> 'int',
		'kiekis'=> 'int',
    );
	
	// sukuriame laukų validatoriaus objektą
	$validator = new validator($validations, $required);

	// laukai įvesti be klaidų
	if($validator->validate($_POST)) {
		// įrašome naują sutartį
		$prekesID = $prekesObj->insertProduct($_POST);

		// įrašome užsakytas paslaugas
		foreach($_POST['sandelis'] as $keyForm => $sandelisForm) {

			// gauname paslaugos id, galioja nuo ir kaina reikšmes {$price['fk_paslauga']}#{$price['galioja_nuo']}}
			
			$sandelisId = $sandelisForm;

			$sandeliaiObj->insertWarehouseProduct($prekesID, $sandelisId, $_POST['kiekis'][$keyForm]);
		}

		// nukreipiame vartotoją į sutarčių puslapį
		if($formErrors == null) {
			common::redirect("index.php?module={$module}&action=list");
			die();
		}
	} else {
		// gauname klaidų pranešimą
		$formErrors = $validator->getErrorHTML();

		// laukų reikšmių kintamajam priskiriame įvestų laukų reikšmes
		$data = $_POST;

		$data['sandeliuojama_preke'] = array();
		if(isset($_POST['sandelis'])) {
			$i = 0;
			foreach($_POST['sandelis'] as $key => $val) {
				// gauname paslaugos id, galioja nuo ir kaina reikšmes {$price['fk_paslauga']}#{$price['galioja_nuo']}
				
				$sandelisId = $val;
				
				$data['sandeliuojama_preke'][$i]['fk_PREKEid'] = $sandelisId;
				$data['sandeliuojama_preke'][$i]['kiekis'] = $_POST['kiekis'][$key];

				$i++;
			}
		}
	}
}
array_unshift($data['sandeliuojama_preke'], array());

// įtraukiame šabloną
include "templates/{$module}/{$module}_form.tpl.php";

?>