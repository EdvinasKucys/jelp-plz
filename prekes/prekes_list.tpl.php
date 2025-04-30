<?php
	// suformuojame puslapių kelio (breadcrumb) elementų masyvą
	$breadcrumbItems = array(array('link' => 'index.php', 'title' => 'Pradžia'), array('title' => 'Prekės'));
	
	// puslapių kelio šabloną
	include 'templates/common/breadcrumb.tpl.php';
?>

<div class="d-flex flex-row-reverse gap-3">
	<a href='index.php?module=<?php echo $module; ?>&action=create'>Nauja prekė</a>
</div>

<?php if(isset($_GET['remove_error'])) { ?>
	<div class="errorBox">
		Prekė nebuvo pašalinta. Pirmiausia pašalinkite prekę iš užsakymų.
	</div>
<?php } ?>

<table class="table">
	<tr>
		<th>ID</th>
		<th>Pavadinimas</th>
        <th>Kaina</th>
        <th>Būsena</th>
		<th>Gamintojas</th>
		<th></th>
	</tr>
	<?php
		// suformuojame lentelę
		foreach($data as $key => $val) {
			echo
				"<tr>"
					. "<td>{$val['id_Preke']}</td>"
					. "<td>{$val['pavadinimas']}</td>"
                    . "<td>{$val['kaina']}</td>"
                    . "<td>{$val['busena']}</td>"
					. "<td>{$val['gamintojas']}</td>"
					. "<td class='d-flex flex-row-reverse gap-2'>"
						. "<a href='index.php?module={$module}&action=edit&id={$val['id_Preke']}'>redaguoti</a>"
						. "<a href='#' onclick='showConfirmDialog(\"{$module}\", \"{$val['id_Preke']}\"); return false;'>šalinti</a>&nbsp;"
					. "</td>"
				. "</tr>";
		}
	?>
</table>

<?php
	// įtraukiame puslapių šabloną
	include 'templates/common/paging.tpl.php';
?>