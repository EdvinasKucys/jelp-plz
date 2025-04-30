<nav aria-label="breadcrumb">
	<ol class="breadcrumb">
		<li class="breadcrumb-item"><a href="index.php">Pradžia</a></li>
		<li class="breadcrumb-item" aria-current="page"><a href="index.php?module=<?php echo $module; ?>&action=list">Prekių gamintojai</a></li>
		<li class="breadcrumb-item active" aria-current="page"><?php if(!empty($id)) echo "Modelio redagavimas"; else echo "Naujas modelis"; ?></li>
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
	
	<!-- <div class="form-group">
		<label for="pavadinimas">Gamintojo pavadinimas<?php echo in_array('pavadinimas', $required) ? '<span> *</span>' : ''; ?></label>
		<input type="text" id="pavadinimas" <?php if(isset($data['editing'])) { ?> readonly="readonly" <?php } ?> name="pavadinimas" class="form-control" value="<?php echo isset($data['pavadinimas']) ? $data['pavadinimas'] : ''; ?>">
	</div> -->

	<div class="form-group">
		<label for="pavadinimas">Pavadinimas<?php echo in_array('pavadinimas', $required) ? '<span> *</span>' : ''; ?></label>
		<input type="text" id="pavadinimas" name="pavadinimas" class="form-control" value="<?php echo isset($data['pavadinimas']) ? $data['pavadinimas'] : ''; ?>">
	</div>
	
	<div class="form-group">
		<label for="telefonas">Telefono numeris<?php echo in_array('telefonas', $required) ? '<span> *</span>' : ''; ?></label>
		<input type="text" id="telefonas" name="telefonas" class="form-control" value="<?php echo isset($data['telefonas']) ? $data['telefonas'] : ''; ?>">
	</div>

	<div class="form-group">
		<label for="pastas">Elektroninis paštas<?php echo in_array('pastas', $required) ? '<span> *</span>' : ''; ?></label>
		<input type="text" id="pastas" name="pastas" class="form-control" value="<?php echo isset($data['el__pa_tas']) ? $data['el__pa_tas'] : ''; ?>">
	</div>


	<?php if(isset($data['id_Gamintojas'])) { ?>
		<input type="hidden" name="id_Gamintojas" value="<?php echo $data['id_Gamintojas']; ?>" />
	<?php } ?>

	<p class="required-note">* pažymėtus laukus užpildyti privaloma</p>

	<input type="submit" class="btn btn-primary w-25" name="submit" value="Išsaugoti">
</form>