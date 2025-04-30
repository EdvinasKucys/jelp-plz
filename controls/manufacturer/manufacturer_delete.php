<?php

// sukuriame užklausų klasės objektą
$gamintojaiObj = new Manufacturer();

if(!empty($id)) {
	// patikriname, ar šalinamas gamintojas nenaudojamas, t.y. nepriskirtas jokiai prekei
	$count = $gamintojaiObj->getProductCountOfManufacturer($id);

	$removeErrorParameter = '';
	if($count == 0) {
		// pašaliname gamintoją
		$gamintojaiObj->deleteManufacturer($id);
	} else {
		// nepašalinome, nes gamintojas priskirtas bent vienai prekei, rodome klaidos pranešimą
		$removeErrorParameter = '&remove_error=1';
	}

	// nukreipiame į gamintojų puslapį
	common::redirect("index.php?module={$module}&action=list{$removeErrorParameter}");
	die();
}

?>