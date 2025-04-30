<?php
	// suformuojame puslapių kelio (breadcrumb) elementų masyvą
	$breadcrumbItems = array(array('link' => 'index.php', 'title' => 'Pradžia'), array('title' => 'Gamintojai'));
	
	// puslapių kelio šabloną
	include 'templates/common/breadcrumb.tpl.php';
?>

<div class="d-flex flex-row-reverse gap-3">
	<a href='index.php?module=<?php echo $module; ?>&action=create'>Naujas gamintojas</a>
</div>

<?php if(isset($_GET['remove_error'])) { ?>
	<div class="errorBox">
		Gamintojas nebuvo pašalintas. Pirmiausia pašalinkite to gamintojo prekes.
	</div>
<?php } ?>

<table class="table">
	<tr>
		<th>ID</th>
		<th>Pavadinimas</th>
        <th>El Paštas</th>
        <th>Telefonas</th>
		<th></th>
	</tr>
	<?php
		// suformuojame lentelę
		foreach($data as $key => $val) {
			echo
				"<tr>"
					. "<td>{$val['id_Gamintojas']}</td>"
					. "<td>{$val['pavadinimas']}</td>"
                    . "<td>{$val['pastas']}</td>"
                    . "<td>{$val['telefonas']}</td>"
					. "<td class='d-flex flex-row-reverse gap-2'>"
						. "<a href='index.php?module={$module}&action=edit&id={$val['id_Gamintojas']}'>redaguoti</a>"
						. "<a href='#' onclick='showConfirmDialog(\"{$module}\", \"{$val['id_Gamintojas']}\"); return false;'>šalinti</a>&nbsp;"
					. "</td>"
				. "</tr>";
		}
	?>
</table>

<?php
	// įtraukiame puslapių šabloną
	include 'templates/common/paging.tpl.php';
?>