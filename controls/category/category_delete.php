<?php

// sukuriame užklausų klasės objektą
$categoryObj = new Category();

if(!empty($id)) {
	// patikriname, ar šalinama kategorija nenaudojama, t.y. nepriskirta jokiai prekei
	$count = $categoryObj->getProductCountInCategory($id);

	$removeErrorParameter = '';
	if($count == 0) {
		// pašaliname kategoriją
		$categoryObj->deleteCategory($id);
	} else {
		// nepašalinome, nes kategorija priskirta bent vienai prekei, rodome klaidos pranešimą
		$removeErrorParameter = '&remove_error=1';
	}

	// nukreipiame į kategorijų puslapį
	common::redirect("index.php?module={$module}&action=list{$removeErrorParameter}");
	die();
}

?>