<?php

// sukuriame užklausų klasės objektą
$categoryObj = new Category();

// suskaičiuojame bendrą įrašų kiekį
$elementCount = $categoryObj->getCategoryListCount();

// sukuriame puslapiavimo klasės objektą
$paging = new paging(config::NUMBER_OF_ROWS_IN_PAGE);

// suformuojame sąrašo puslapius
$paging->process($elementCount, $pageId);

// išrenkame nurodyto puslapio modelius
$data = $categoryObj->getCategoryList($paging->size, $paging->first);

// įtraukiame šabloną - use kategorijos directory for templates
include "templates/kategorijos/kategorijos_list.tpl.php";
	
?>