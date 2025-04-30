<?php

// sukuriame užklausų klasės objektą
$prekesObj = new Product();

// sukuriame puslapiavimo klasės objektą
$paging = new paging(config::NUMBER_OF_ROWS_IN_PAGE);

// suskaičiuojame bendrą įrašų kiekį
$elementCount = $prekesObj->getProductListCount();

// suformuojame sąrašo puslapius
$paging->process($elementCount, $pageId);

// išrenkame nurodyto puslapio sutartis
$data = $prekesObj->getProductList($paging->size, $paging->first);

// įtraukiame šabloną - FIX: Use prekes instead of product for template path
include "templates/prekes/prekes_list.tpl.php";

?>