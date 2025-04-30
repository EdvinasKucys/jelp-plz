<?php

// sukuriame užklausų klasės objektą
$gamintojaiObj = new Manufacturer();

if(!empty($id)) {
	// patikriname, ar šalinamas modelis nenaudojamas, t.y. nepriskirtas jokiam automobiliui
    // patikriname, ar šalinamas gamintojas nenaudojamas, t.y. nepriskirtas jokiai prekei

	$count = $gamintojaiObj->getProductCountOfManufacturer($id);

	$removeErrorParameter = '';
	if($count == 0) {
		// pašaliname modelį
		$gamintojaiObj->deleteManufacturer($id);
	} else {
		// nepašalinome, nes modelis priskirtas bent vienam automobiliui, rodome klaidos pranešimą
		$removeErrorParameter = '&remove_error=1';
	}

	// nukreipiame į modelių puslapį
	common::redirect("index.php?module={$module}&action=list{$removeErrorParameter}");
	die();
}

?>