<?php

// sukuriame užklausų klasės objektą
$prekesObj = new Product();

if(!empty($id)) {
	// pašaliname užsakytas paslaugas
	$prekesObj->deleteWarehouseProduct($id);

	// šaliname sutartį
	$prekesObj->deleteProduct($id);

	// nukreipiame į sutarčių puslapį
	common::redirect("index.php?module={$module}&action=list");
	die();
}

?>