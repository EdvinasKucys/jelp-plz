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
		// atnaujiname prekę
		$prekesObj->updateProduct($_POST);

		// pašaliname nebereikalingas prekes iš sandėlių ir įrašome naujas
		// gauname esamus įrašus
		$PrekesSandeliuoseFromDb = $prekesObj->getWarehousedProducts($id);

		// jeigu prekės nerandame iš formos gautame masyve, šaliname
		foreach($PrekesSandeliuoseFromDb as $PrekeSandelyDb) {
			$found = false;
			if(isset($_POST['sandelis'])) {
				foreach($_POST['sandelis'] as $keyForm => $sandelisForm) {
					$sandelisId = $sandelisForm;
					
					if($PrekeSandelyDb['fk_SANDELISsandelio_id'] == $sandelisId && $PrekeSandelyDb['kiekis'] == $_POST['kiekis'][$keyForm]) {
						$found = true;
					}
				}
			}

			if(!$found) {
				// šalinama prekė iš sandėlio
				$prekesObj->deleteProductFromWarehouse($id, $PrekeSandelyDb['fk_SANDELISsandelio_id']);
			}
		}
		
		if(isset($_POST['sandelis'])) {
			foreach($_POST['sandelis'] as $keyForm => $sandelisForm) {
				// jeigu prekės nerandame duomenų bazėje, tačiau ji yra formoje, įrašome
				$sandelisId = $sandelisForm;
				
				$found = false;
				foreach($PrekesSandeliuoseFromDb as $PrekeSandelyDb) {
					if($PrekeSandelyDb['fk_SANDELISsandelio_id'] == $sandelisId && $PrekeSandelyDb['kiekis'] == $_POST['kiekis'][$keyForm]) {
						$found = true;
					}
				}

				if(!$found) {
					// įrašoma prekė į sandėlį
					$sandeliaiObj->insertWarehouseProduct($id, $sandelisId, $_POST['kiekis'][$keyForm]);
				}
			}
		}

		// nukreipiame vartotoją į prekių puslapį
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
				// gauname sandėlio ID
				$sandelisId = $val;
				
				$data['sandelio_prekes'][$i]['fk_SANDELISsandelio_id'] = $sandelisId;
				$data['sandelio_prekes'][$i]['kiekis'] = $_POST['kiekis'][$key];

				$i++;
			}
		}

		array_unshift($data['sandelio_prekes'], array());
	}
} else {
	//  išrenkame elemento duomenis ir jais užpildome formos laukus.
	$data = $prekesObj->getProduct($id);
	$data['sandelio_prekes'] = $prekesObj->getWarehousedProducts($id);

	// į masyvo pradžią įtraukiame tuščią reikšmę
	array_unshift($data['sandelio_prekes'], array());
}

// Get the categories for dropdown
$kategorijos = $categoryObj->getCategoriesForSelect();

// nustatome požymį, kad įrašas redaguojamas norint išjungti ID redagavimą šablone
$data['editing'] = 1;

// įtraukiame šabloną
include "templates/prekes/prekes_form.tpl.php";

?>