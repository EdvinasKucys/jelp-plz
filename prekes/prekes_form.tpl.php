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
	<div class="form-group">
		<label for="pavadinimas">Prekės pavadinimas<?php echo in_array('pavadinimas', $required) ? '<span> *</span>' : ''; ?></label>
		<input type="text" id="pavadinimas" name="pavadinimas" class="form-control" value="<?php echo isset($data['pavadinimas']) ? $data['pavadinimas'] : ''; ?>">
	</div>
	
	<div class="form-group">
		<label for="kaina">Prekės kaina<?php echo in_array('kaina', $required) ? '<span> *</span>' : ''; ?></label>
		<input type="text" id="kaina" name="kaina" class="form-control" value="<?php echo isset($data['kaina']) ? $data['kaina'] : ''; ?>">
	</div>

	<div class="form-group">
		<label for="svoris">Prekės svoris<?php echo in_array('svoris', $required) ? '<span> *</span>' : ''; ?></label>
		<input type="text" id="svoris" name="svoris" class="form-control" value="<?php echo isset($data['svoris']) ? $data['svoris'] : ''; ?>">
	</div>

    <div class="form-group">
		<label for="aprasymas">Prekės aprašymas<?php echo in_array('aprasymas', $required) ? '<span> *</span>' : ''; ?></label>
		<input type="text" id="aprasymas" name="aprasymas" class="form-control" value="<?php echo isset($data['aprasymas']) ? $data['aprasymas'] : ''; ?>">
	</div>

    <div class="form-group">
		<label for="medziaga">Prekės medžiaga<?php echo in_array('medziaga', $required) ? '<span> *</span>' : ''; ?></label>
		<input type="text" id="medziaga" name="medziaga" class="form-control" value="<?php echo isset($data['medziaga']) ? $data['medziaga'] : ''; ?>">
	</div>

    <div class="form-group">
		<label for="fk_GAMINTOJASgamintojo_id">Prekės gamintojas<?php echo in_array('fk_GAMINTOJASgamintojo_id', $required) ? '<span> *</span>' : ''; ?></label>
		<select id="fk_GAMINTOJASgamintojo_id" name="fk_GAMINTOJASgamintojo_id" class="form-select form-control">
			<option value="">---------------</option>
			<?php
				// išrenkame gamintojus
				$gamintojai = $gamintojaiObj->getGamintojaiList();
				foreach($gamintojai as $key => $val) {
					$selected = "";
					if(isset($data['fk_GAMINTOJASgamintojo_id']) && $data['fk_GAMINTOJASgamintojo_id'] == $val['gamintojo_id']) {
						$selected = " selected='selected'";
					}
					echo "<option{$selected} value='{$val['gamintojo_id']}'>{$val['gamintojo_id']} - {$val['pavadinimas']}</option>";
				}
			?>
		</select>
	</div>

	<div class="form-group">
		<label for="fk_KATEGORIJAid_KATEGORIJA">Prekės kategorija<?php echo in_array('fk_KATEGORIJAid_KATEGORIJA', $required) ? '<span> *</span>' : ''; ?></label>
		<select id="fk_KATEGORIJAid_KATEGORIJA" name="fk_KATEGORIJAid_KATEGORIJA" class="form-select form-control">
			<option value="">---------------</option>
			<?php
				// išrenkame kategorijas
				$categoryObj = new Category();
				$kategorijos = $categoryObj->getCategoriesForSelect();
				foreach($kategorijos as $key => $val) {
					$selected = "";
					if(isset($data['fk_KATEGORIJAid_KATEGORIJA']) && $data['fk_KATEGORIJAid_KATEGORIJA'] == $val['id_KATEGORIJA']) {
						$selected = " selected='selected'";
					}
					echo "<option{$selected} value='{$val['id_KATEGORIJA']}'>{$val['id_KATEGORIJA']} - {$val['pavadinimas']}</option>";
				}
			?>
		</select>
	</div>

	<?php if(isset($data['id'])) { ?>
		<input type="hidden" name="id" value="<?php echo $data['id']; ?>" />
	<?php } ?>

	<h4 class="mt-3">Sandėlių likučiai</h4>

	<div class="row w-75">
		<div class="formRowsContainer column">
			<div class="row headerRow<?php if(empty($data['sandelio_prekes']) || sizeof($data['sandelio_prekes']) == 1) echo ' d-none'; ?>">
				<div class="col-6">Sandėlis</div>
				<div class="col-2">Kiekis</div>
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
						if(isset($sandelioPrekes['kiekis'])) {
							$kiekis = $sandelioPrekes['kiekis'];
						}

					?>
						<div class="formRow row col-12 <?php echo $key > 0 ? '' : 'd-none'; ?>">
							<div class="col-6">
								<select class="elementSelector form-select form-control" name="sandelis[]" <?php echo $disabledAttr; ?>>
									<?php
										$allSandeliai = $sandeliaiObj->getSandeliaiList();
										foreach($allSandeliai as $sandelis) {
											$selected = "";
												if(isset($sandelioPrekes['fk_SANDELISsandelio_id']) && $sandelioPrekes['fk_SANDELISsandelio_id'] == $sandelis['sandelio_id']) {
													$selected = " selected='selected'";
												}
											echo "<option{$selected} value='{$sandelis['sandelio_id']}'>{$sandelis['sandelio_id']} - {$sandelis['pavadinimas']}</option>";
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

	<p class="required-note">* pažymėtus laukus užpildyti privaloma</p>

	<input type="submit" class="btn btn-primary w-25" name="submit" value="Išsaugoti">
</form>