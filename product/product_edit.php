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
		// atnaujiname sutartį
		$prekesObj->updateProduct($_POST);

		// pašaliname nebereikalingas paslaugas ir įrašome naujas
		// gauname esamas paslaugas
		$PrekesSandeliuoseFromDb = $prekesObj->getWarehousedProducts($id);

		// jeigu paslaugos kainos nerandame iš formos gautame masyve, šaliname
		foreach($PrekesSandeliuoseFromDb as $PrekeSandelyDb) {
			$found = false;
			if(isset($_POST['sandelis'])) {
				foreach($_POST['sandelis'] as $keyForm => $sandelisForm) {
					// gauname paslaugos id, galioja nuo ir kaina reikšmes {$price['fk_paslauga']}#{$price['galioja_nuo']}
					
					$sandelisId = $sandelisForm;
					
					
					if($PrekeSandelyDb['fk_SANDELISsandelio_id'] == $sandelisId && $PrekeSandelyDb['kiekis'] == $_POST['kiekis'][$keyForm]) {
						$found = true;
					}
				}
			}

			if(!$found) {
				// šalinama paslaugos kaina
				$prekesObj->deleteProductFromWarehouse($id, $PrekeSandelyDb['fk_SANDELISsandelio_id']);
			}
		}
		
		if(isset($_POST['sandelis'])) {
			foreach($_POST['sandelis'] as $keyForm => $sandelisForm) {
				// jeigu užsakytos paslaugos nerandame duomenų bazėje, tačiau ji yra formoje, įrašome

				// gauname paslaugos id, galioja nuo ir kaina reikšmes {$price['fk_paslauga']}#{$price['galioja_nuo']}
				
				$sandelisId = $sandelisForm;
				
				$found = false;
				foreach($PrekesSandeliuoseFromDb as $PrekeSandelyDb) {
					if($PrekeSandelyDb['fk_SANDELISsandelio_id'] == $sandelisId && $serviceDb['kiekis'] == $_POST['kiekis'][$keyForm]) {
						$found = true;
					}
				}

				if(!$found) {
					// įrašoma paslaugos kaina
					$sandeliaiObj->insertWarehouseProduct($id, $sandelisId, $_POST['kiekis'][$keyForm]);
				}
			}
		}

		// nukreipiame vartotoją į sutarčių puslapį
		common::redirect("index.php?module={$module}&action=list");
		die();
	} else {
		// gauname klaidų pranešimą
		$formErrors = $validator->getErrorHTML();

		// laukų reikšmių kintamajam priskiriame įvestų laukų reikšmes
		$data = $_POST;
		if(isset($_POST['sandelis'])) {
			$i = 0;
			foreach($_POST['sandelis'] as $key => $val) {
				// gauname paslaugos id, galioja nuo ir kaina reikšmes {$price['fk_paslauga']}#{$price['galioja_nuo']}
				
				$sandelisId = $val;
				
				
				$data['o'][$i]['fk_SANDELISsandelio_id'] = $sandelisId;
				$data['o'][$i]['saugomas_kiekis'] = $_POST['kiekis'][$key];

				$i++;
			}
		}

		array_unshift($data['o'], array());
	}
} else {
	//  išrenkame elemento duomenis ir jais užpildome formos laukus.
	$data = $prekesObj->getProduct($id);
	$data['o'] = $prekesObj->getWarehousedProducts($id);

	// į užsakytų paslaugų masyvo pradžią įtraukiame tuščią reikšmę, kad užsakytų paslaugų formoje
	// būtų visada išvedami paslėpti formos laukai, kuriuos galėtume kopijuoti ir pridėti norimą
	// kiekį paslaugų
	array_unshift($data['sandeliuojama_preke'], array());
}

// nustatome požymį, kad įrašas redaguojamas norint išjungti ID redagavimą šablone
$data['editing'] = 1;

// įtraukiame šabloną
include "templates/{$module}/{$module}_form.tpl.php";

?>