<nav aria-label="breadcrumb">
	<ol class="breadcrumb">
		<li class="breadcrumb-item"><a href="index.php">Pradžia</a></li>
		<li class="breadcrumb-item" aria-current="page"><a href="index.php?module=<?php echo $module; ?>&action=list">Kategorijos</a></li>
		<li class="breadcrumb-item active" aria-current="page"><?php if(!empty($id)) echo "Kategorijos redagavimas"; else echo "Nauja kategorija"; ?></li>
	</ol>
</nav>

<?php if($formErrors != null) { ?>
	<div class="alert alert-danger" role="alert">
		Neįvesti arba neteisingai įvesti šie laukai:
		<?php 
			echo $formErrors;
		?>
	</div>
<?php } ?>

<form action="" method="post" class="d-grid gap-3">
	<div class="form-group">
		<label for="pavadinimas">Pavadinimas<?php echo in_array('pavadinimas', $required) ? '<span> *</span>' : ''; ?></label>
		<input type="text" id="pavadinimas" name="pavadinimas" class="form-control" value="<?php echo isset($data['pavadinimas']) ? $data['pavadinimas'] : ''; ?>">
	</div>
	
	<div class="form-group">
		<label for="aprasymas">Aprašymas<?php echo in_array('aprasymas', $required) ? '<span> *</span>' : ''; ?></label>
		<textarea id="aprasymas" name="aprasymas" class="form-control"><?php echo isset($data['aprasymas']) ? $data['aprasymas'] : ''; ?></textarea>
	</div>

	<?php if(isset($data['id_KATEGORIJA'])) { ?>
		<input type="hidden" name="id_KATEGORIJA" value="<?php echo $data['id_KATEGORIJA']; ?>" />
	<?php } ?>

	<p class="required-note">* pažymėtus laukus užpildyti privaloma</p>

	<input type="submit" class="btn btn-primary w-25" name="submit" value="Išsaugoti">
</form>