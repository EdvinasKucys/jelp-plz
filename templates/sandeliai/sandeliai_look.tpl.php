<nav aria-label="breadcrumb">
	<ol class="breadcrumb">
		<li class="breadcrumb-item"><a href="index.php">Pradžia</a></li>
		<li class="breadcrumb-item" aria-current="page"><a href="index.php?module=<?php echo $module; ?>&action=list">Sandėliai</a></li>
		<li class="breadcrumb-item active" aria-current="page"><?php if(!empty($id)) echo "Sandėlio peržiūra"; else echo "Sandėlio peržiūra"; ?></li>
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
		<label for="pavadinimas">Pavadinimas</label>
		<input type="text" readonly="readonly" id="pavadinimas" name="pavadinimas" class="form-control" value="<?php echo isset($data[0]['sandelio_pavadinimas']) ? $data[0]['sandelio_pavadinimas'] : ''; ?>">
	</div>
	
	<div class="form-group">
		<label for="adresas">Adresas</label>
		<input type="text" readonly="readonly" id="adresas" name="adresas" class="form-control" value="<?php echo isset($data[0]['adresas']) ? $data[0]['adresas'] : ''; ?>">
	</div>

	<input type="submit" class="btn btn-primary w-25" name="submit" value="Uždaryti">
	
</form>