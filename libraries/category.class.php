<?php
/**
 * Category management class
 *
 * @author E9160
 */

class Category {
	
	/**
	 * Getting a specific category
	 */
	public function getCategory($id) {
		$id = mysql::escapeFieldForSQL($id);

		$query = "SELECT *
				FROM `kategorija` WHERE `id_KATEGORIJA`='{$id}'";
		$data = mysql::select($query);
		
		return $data[0];
	}
	
	/**
	 * Getting category list
	 */
	public function getCategoryList($limit = null, $offset = null): array 
	{
		if($limit) {
			$limit = mysql::escapeFieldForSQL($limit);
		}
		if($offset) {
			$offset = mysql::escapeFieldForSQL($offset);
		}

		$limitOffsetString = "";
		if(isset($limit)) {
			$limitOffsetString .= " LIMIT {$limit}";
			
			if(isset($offset)) {
				$limitOffsetString .= " OFFSET {$offset}";
			}	
		}
		
		$query = "SELECT `kategorija`.`id_KATEGORIJA`,
					  `kategorija`.`pavadinimas`,
					  `kategorija`.`aprasymas`
				FROM `kategorija`
				{$limitOffsetString}";
		$data = mysql::select($query);
		return $data;
	}

	/**
	 * Get category count
	 */
	public function getCategoryListCount(): int 
	{
		$query = "SELECT COUNT(`kategorija`.`id_KATEGORIJA`) as `kiekis`
					FROM `kategorija`";
		$data = mysql::select($query);
		
		return $data[0]['kiekis'];
	}
	
	/**
	 * Update existing category
	 */
	public function updateCategory($data) {
		$data = mysql::escapeFieldsArrayForSQL($data);
		
		$query = "UPDATE `kategorija`
				SET `pavadinimas`='{$data['pavadinimas']}',
					`aprasymas`='{$data['aprasymas']}'
				WHERE `id_KATEGORIJA`='{$data['id_KATEGORIJA']}'";
		mysql::query($query);
	}
	
	/**
	 * Insert new category
	 */
	public function insertCategory($data) {
		$data = mysql::escapeFieldsArrayForSQL($data);

		$query = "INSERT INTO `kategorija`
						  (`pavadinimas`,
						   `aprasymas`)
				VALUES      ('{$data['pavadinimas']}',
						   '{$data['aprasymas']}')";
		mysql::query($query);
		
		return mysql::getLastInsertedId();
	}
	
	/**
	 * Delete category
	 */
	public function deleteCategory($id) {
		$id = mysql::escapeFieldForSQL($id);

		$query = "DELETE FROM `kategorija`
				WHERE `id_KATEGORIJA`='{$id}'";
		mysql::query($query);
	}
	
	/**
	 * Get count of products in a category
	 */
	public function getProductCountInCategory($id) {
		$id = mysql::escapeFieldForSQL($id);

		$query = "SELECT COUNT(`preke`.`id`) AS `kiekis`
				FROM `kategorija`
					INNER JOIN `preke`
						ON `preke`.`fk_KATEGORIJAid_KATEGORIJA`=`kategorija`.`id_KATEGORIJA`
				WHERE `kategorija`.`id_KATEGORIJA`='{$id}'";
		$data = mysql::select($query);
		
		return $data[0]['kiekis'];
	}
	
	/**
	 * Get list of all categories for dropdown
	 */
	public function getCategoriesForSelect() {
		$query = "SELECT `id_KATEGORIJA`, `pavadinimas`
				FROM `kategorija`
				ORDER BY `pavadinimas` ASC";
		$data = mysql::select($query);
		
		return $data;
	}
}