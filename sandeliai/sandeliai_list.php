<?php

// sukuriame užklausų klasės objektą
$sandeliaiObj = new Warehouse();

// suskaičiuojame bendrą įrašų kiekį
$elementCount = $sandeliaiObj->getWarehouseListCount();

// sukuriame puslapiavimo klasės objektą
$paging = new paging(config::NUMBER_OF_ROWS_IN_PAGE);

// suformuojame sąrašo puslapius
$paging->process($elementCount, $pageId);

// išrenkame nurodyto puslapio modelius
$data = $sandeliaiObj->getWarehouseList($paging->size, $paging->first);

// įtraukiame šabloną
include "templates/{$module}/{$module}_list.tpl.php";
	
?>