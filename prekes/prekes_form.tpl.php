<nav aria-label="breadcrumb">
	<ol class="breadcrumb">
		<li class="breadcrumb-item"><a href="index.php">Pradžia</a></li>
		<li class="breadcrumb-item" aria-current="page"><a href="index.php?module=<?php echo $module; ?>&action=list">Prekės</a></li>
		<li class="breadcrumb-item active" aria-current="page"><?php if(!empty($id)) echo "Prekės redagavimas"; else echo "Nauja prekė"; ?></li>
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
		<label for="id_Preke">Prekes id<?php echo in_array('id_Preke', $required) ? '<span> *</span>' : ''; ?></label>
		<input type="text" id="id_Preke" <?php if(isset($data['editing'])) { ?> readonly="readonly" <?php } ?> name="id_Preke" class="form-control" value="<?php echo isset($data['id_Preke']) ? $data['pavadinimas'] : ''; ?>">
	</div> -->


	<div class="form-group">
		<label for="pavadinimas">Prekės pavadinimas<?php echo in_array('pavadinimas', $required) ? '<span> *</span>' : ''; ?></label>
		<input type="text" id="pavadinimas" name="pavadinimas" class="form-control" value="<?php echo isset($data['pavadinimas']) ? $data['pavadinimas'] : ''; ?>">
	</div>
	
	<div class="form-group">
		<label for="kaina">Prekės kaina<?php echo in_array('kaina', $required) ? '<span> *</span>' : ''; ?></label>
		<input type="text" id="kaina" name="kaina" class="form-control" value="<?php echo isset($data['kaina']) ? $data['kaina'] : ''; ?>">
	</div>

	<div class="form-group">
		<label for="busena">Prekės būsena<?php echo in_array('busena', $required) ? '<span> *</span>' : ''; ?></label>
		<input type="text" id="busena" name="busena" class="form-control" value="<?php echo isset($data['busena']) ? $data['busena'] : ''; ?>">
	</div>

    <div class="form-group">
		<label for="aprasymas">Prekės aprašymas<?php echo in_array('aprasymas', $required) ? '<span> *</span>' : ''; ?></label>
		<input type="text" id="aprasymas" name="aprasymas" class="form-control" value="<?php echo isset($data['aprasymas']) ? $data['aprasymas'] : ''; ?>">
	</div>

    <div class="form-group">
		<label for="prekes_rusis">Prekės rūšis<?php echo in_array('prekes_rusis', $required) ? '<span> *</span>' : ''; ?></label>
		<input type="text" id="prekes_rusis" name="prekes_rusis" class="form-control" value="<?php echo isset($data['prekes_rusis']) ? $data['prekes_rusis'] : ''; ?>">
	</div>

    <div class="form-group">
		<label for="fk_Gamintojasid_Gamintojas">Prekės gamintojas<?php echo in_array('fk_Gamintojasid_Gamintojas', $required) ? '<span> *</span>' : ''; ?></label>
		<select id="fk_Gamintojasid_Gamintojas" name="fk_Gamintojasid_Gamintojas" class="form-select form-control">
			<option value="">---------------</option>
			<?php
				// išrenkame klientus
				$gamintojai = $gamintojaiObj->getGamintojaiList();
				foreach($gamintojai as $key => $val) {
					$selected = "";
					if(isset($data['fk_Gamintojasid_Gamintojas']) && $data['fk_Gamintojasid_Gamintojas'] == $val['id_Gamintojas']) {
						$selected = " selected='selected'";
					}
					echo "<option{$selected} value='{$val['id_Gamintojas']}'>{$val['id_Gamintojas']} - {$val['pavadinimas']}</option>";
				}
			?>
		</select>
	</div>

	<h4 class="mt-3">Sandėlių likučiai</h4>





	<?php if(isset($data['id_Preke'])) { ?>
		<input type="hidden" name="id_Preke" value="<?php echo $data['id_Preke']; ?>" />
	<?php } ?>


	<div class="row w-75">
		<div class="formRowsContainer column">
			<div class="row headerRow<?php if(empty($data['sandelio_prekes']) || sizeof($data['sandelio_prekes']) == 1) echo ' d-none'; ?>">
				<div class="col-6">Sandėlis</div>
				<div class="col-1">Kiekis</div>
				<div class="col-4"></div>
			</div>
			<?php
				if(!empty($data['sandelio_prekes']) && sizeof($data['sandelio_prekes']) > 0) {
					foreach($data['sandelio_prekes'] as $key => $sandelioPrekes) {

						$disabledAttr = "";
						if($key === 0) {
							$disabledAttr = "disabled='disabled'";
						}

						$kiekis = '';
						if(isset($sandelioPrekes['saugomas_kiekis']) ) {
							$kiekis = $sandelioPrekes['saugomas_kiekis'];
						}

					?>
						<div class="formRow row col-12 <?php echo $key > 0 ? '' : 'd-none'; ?>">
							<div class="col-6">
								<select class="elementSelector form-select form-control" name="sandelis[]" <?php echo $disabledAttr; ?>>
									<?php
										$allSandeliai = $sandeliaiObj->getSandeliaiList();
										foreach($allSandeliai as $sandelis) {
											$selected = "";
												if(isset($sandelioPrekes['fk_Sandelisid_Sandelis']) && $sandelioPrekes['fk_Sandelisid_Sandelis'] == $sandelis['id_Sandelis']) {
													$selected = " selected='selected'";
												}
											echo "<option{$selected} value='{$sandelis['id_Sandelis']}'>{$sandelis['id_Sandelis']} - {$sandelis['pavadinimas']}</option>";
										}
									?>
								</select>
							</div>

							<div class="col-2"><input type="text" name="kiekis[]" class="form-control" value="<?php echo $kiekis; ?>" <?php echo $disabledAttr; ?> /></div>
							<div class="col-4"><a href="#" onclick="return false;" class="removeChild">šalinti</a></div>
						</div>
					<?php 
					}
				}
					?>
		</div>
		<div class="w-100">
			<a href="#" class="addChild">Pridėti</a>
		</div>
	</div>

	<div>
		<h4>Debug</h4>
		<pre>
			<?php var_dump($val, $_POST, $data); ?>
		</pre>
	</div>

	<p class="required-note">* pažymėtus laukus užpildyti privaloma</p>

	<input type="submit" class="btn btn-primary w-25" name="submit" value="Išsaugoti">
</form>