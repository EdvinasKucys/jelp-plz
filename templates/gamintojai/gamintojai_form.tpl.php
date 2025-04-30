<nav aria-label="breadcrumb">
	<ol class="breadcrumb">
		<li class="breadcrumb-item"><a href="index.php">Pradžia</a></li>
		<li class="breadcrumb-item" aria-current="page"><a href="index.php?module=<?php echo $module; ?>&action=list">Prekių gamintojai</a></li>
		<li class="breadcrumb-item active" aria-current="page"><?php if(!empty($id)) echo "Gamintojo redagavimas"; else echo "Naujas gamintojas"; ?></li>
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
		<label for="salis">Šalis<?php echo in_array('salis', $required) ? '<span> *</span>' : ''; ?></label>
		<input type="text" id="salis" name="salis" class="form-control" value="<?php echo isset($data['salis']) ? $data['salis'] : ''; ?>">
	</div>

	<div class="form-group">
		<label for="kontaktai">Kontaktinė informacija<?php echo in_array('kontaktai', $required) ? '<span> *</span>' : ''; ?></label>
		<input type="text" id="kontaktai" name="kontaktai" class="form-control" value="<?php echo isset($data['kontaktai']) ? $data['kontaktai'] : ''; ?>">
	</div>


	<?php if(isset($data['gamintojo_id'])) { ?>
		<input type="hidden" name="gamintojo_id" value="<?php echo $data['gamintojo_id']; ?>" />
	<?php } ?>

	<p class="required-note">* pažymėtus laukus užpildyti privaloma</p>

	<input type="submit" class="btn btn-primary w-25" name="submit" value="Išsaugoti">
</form>