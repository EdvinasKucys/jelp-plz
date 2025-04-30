<?php

// sukuriame užklausų klasės objektą
$gamintojaiObj = new Manufacturer();

// suskaičiuojame bendrą įrašų kiekį
$elementCount = $gamintojaiObj->getManufacturerListCount();

// sukuriame puslapiavimo klasės objektą
$paging = new paging(config::NUMBER_OF_ROWS_IN_PAGE);

// suformuojame sąrašo puslapius
$paging->process($elementCount, $pageId);

// išrenkame nurodyto puslapio modelius
$data = $gamintojaiObj->getManufacturerList($paging->size, $paging->first);

// įtraukiame šabloną - FIX: Use gamintojai instead of manufacturer for template path
include "templates/gamintojai/gamintojai_list.tpl.php";
	
?>