<?php

// sukuriame užklausų klasių objektus
$sandelisObj = new Warehouse();

$formErrors = null;
$data = array();

// nustatome privalomus laukus
$required = array('pavadinimas', 'adresas');

// paspaustas išsaugojimo mygtukas
if(!empty($_POST['submit'])) {
    // Tiesiog grįžtame į sąrašą, jei paspaustas mygtukas
    common::redirect("index.php?module={$module}&action=list");
    die();
} else {
    // išrenkame sandėlio prekių duomenis
    $data = $sandelisObj->getWarehousedProducts($id);
}

// įtraukiame šabloną - use sandeliai directory for templates
include "templates/sandeliai/sandeliai_look.tpl.php";

?>