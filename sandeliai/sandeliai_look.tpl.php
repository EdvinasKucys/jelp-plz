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
	
	<!-- <div class="form-group">
		<label for="pavadinimas">Gamintojo pavadinimas<?php echo in_array('pavadinimas', $required) ? '<span> *</span>' : ''; ?></label>
		<input type="text" id="pavadinimas" <?php if(isset($data['editing'])) { ?> readonly="readonly" <?php } ?> name="pavadinimas" class="form-control" value="<?php echo isset($data['pavadinimas']) ? $data['pavadinimas'] : ''; ?>">
	</div> -->

	<div class="form-group">
		<label for="pavadinimas">Pavadinimas</label>
		<input type="text" readonly="readonly" id="pavadinimas" name="pavadinimas" class="form-control" value="<?php echo isset($data[0]['sandelio_pavadinimas']) ? $data[0]['sandelio_pavadinimas'] : ''; ?>">
	</div>
	
	<div class="form-group">
		<label for="telefonas">Telefono numeris</label>
		<input type="text" readonly="readonly" id="telefonas" name="telefonas" class="form-control" value="<?php echo isset($data[0]['telefonas']) ? $data[0]['telefonas'] : ''; ?>">
	</div>

	<div class="form-group">
		<label for="pastas">Adresas</label>
		<input type="text" readonly="readonly" id="pastas" name="pastas" class="form-control" value="<?php echo isset($data[0]['adresas']) ? $data[0]['adresas'] : ''; ?>">
	</div>

	<div class="form-group">
		<label for="pastas">Elektroninis paštas</label>
		<input type="text" readonly="readonly" id="pastas" name="pastas" class="form-control" value="<?php echo isset($data[0]['pastas']) ? $data[0]['pastas'] : ''; ?>">
	</div>


	<div class="form-group">
		<label for="pastas">Sandėlio talpa</label>
		<input type="text" readonly="readonly" id="pastas" name="pastas" class="form-control" value="<?php echo isset($data[0]['talpa']) ? $data[0]['talpa'] : ''; ?>">
	</div>

	<div> 
    <h4>Prekių likučiai</h4>  
    <dl>
        <?php 
        foreach ($data as $row) {
            echo '<dt><strong>' . htmlspecialchars($row["prekes_pavadinimas"]) . '</strong></dt>';
            echo '<dd>' . htmlspecialchars($row["saugomas_kiekis"]) . ' vnt.</dd>';
        }
        ?>
    </dl>
</div>

		


	<?php if(isset($data['id_Gamintojas'])) { ?>
		<input type="hidden" name="id_Gamintojas" value="<?php echo $data['id_Gamintojas']; ?>" />
	<?php } ?>


	<input type="submit" class="btn btn-primary w-25" name="submit" value="Uždaryti">
	
</form>
