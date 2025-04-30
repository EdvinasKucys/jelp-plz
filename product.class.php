<?php
/**
 * Produc editing class
 *
 * @author E9160
 */

class Product {
	
	/**
	 * getting a product
	 */
	public function getProduct(int $id) {
		$id = mysql::escapeFieldForSQL($id);

		$query = "SELECT *
				FROM `preke`
				WHERE `id`='{$id}'";
		$data = mysql::select($query);
		
		return $data[0];
	}
	
	/**
	 * Getting the product list
	 */
	public function getProductList($limit = null, $offset = null): array 
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
		
		$query = "SELECT `preke`.`id`,
					  `preke`.`pavadinimas`,
					  `preke`.`aprasymas`,
					  `preke`.`kaina`,
					  `preke`.`svoris`,
					  `preke`.`medziaga`,
                      `gamintojas`.`pavadinimas` AS `gamintojas`,
                      `preke`.`fk_GAMINTOJASgamintojo_id`
					  `kategorija`.`pavadinimas` AS `kategorija`
					  `kategorija`.`fk_KATEGORIJAid_KATEGORIJA`
				FROM `preke`
                    LEFT JOIN `gamintojas`
                        ON `gamintojas`.`gamintojo_id` = `preke`.`fk_GAMINTOJASgamintojo_id`
					LEFT JOIN `kategorija`
                        ON `kategorija`.`id_KATEGORIJA` = `preke`.`fk_KATEGORIJAid_KATEGORIJA`
				{$limitOffsetString}";
		$data = mysql::select($query);
		
		return $data;
	}

	/**
	 * Getting product amount
	 */
	public function getProductListCount(): int 
	{
		$query = "SELECT COUNT(`preke`.`id`) as `kiekis`
					FROM `preke`";
		$data = mysql::select($query);
		
		return $data[0]['kiekis'];
	}

	/**
	 * Checking if product id is used
	 */
    public function checkIfProductExists($nr) {
		$nr = mysql::escapeFieldForSQL($nr);

		$query = "SELECT COUNT(`preke`.`id`) AS `kiekis`
				FROM `preke`
				WHERE `preke`.`id`='{$nr}'";
		$data = mysql::select($query);

		//
		return $data[0]['kiekis'];
	}

	

    /**
	 * Product data updating
	 */
	public function updateProduct($data) {
		$data = mysql::escapeFieldsArrayForSQL($data);

		$query = "UPDATE `preke`
				SET `pavadinimas`='{$data['pavadinimas']}',
					`kaina`='{$data['kaina']}',
					`svoris`='{$data['svoris']}',
					`aprasymas`='{$data['aprasymas']}',
					`medziaga`='{$data['medziaga']}',
					`gamintojas`='{$data['gamintojas']}',
					`fk_GAMINTOJASgamintojo_id`='{$data['fk_GAMINTOJASgamintojo_id']}'
					`kategorija`='{$data['kategorija']}',
					`fk_KATEGORIJAid_KATEGORIJA`='{$data['fk_KATEGORIJAid_KATEGORIJA']}'
				WHERE `id`='{$data['id']}'";
		mysql::query($query);
	}
	
	/**
	 * insert a product
	 */
	public function insertProduct($data): int {
		$data = mysql::escapeFieldsArrayForSQL($data);

		$query = "INSERT INTO `preke`
					 (	`pavadinimas`,
					  `aprasymas`,
					  `kaina`,
					  `svoris`,
					  `medziaga`,
                      `gamintojas`,
                      `fk_GAMINTOJASgamintojo_id`
					  `kategorija`
					  `fk_KATEGORIJAid_KATEGORIJA`)
				VALUES      ('{$data['pavadinimas']}',
						   '{$data['aprasymas']}', '{$data['kaina']}', '{$data['svoris']}',
                           '{$data['medziaga']}', '{$data['gamintojas']}', '{$data['fk_GAMINTOJASgamintojo_id']}',
						   '{$data['kategorija']}', '{$data['fk_KATEGORIJAid_KATEGORIJA']}')";
		mysql::query($query);

        $id = (int) mysql::getLastInsertedId();

        return $id;
	}



    /**
	 * Deleting product
	 */
	public function deleteProduct($id) {
		$id = mysql::escapeFieldForSQL($id);

		$query = "DELETE FROM `preke`
				WHERE `id`='{$id}'";
		mysql::query($query);
	}


    /**
	 * Deleting all of a products in a warehouse
	 * @param type $contractId
	 */
	public function deleteWarehouseProduct($productID) {
		$contractId = mysql::escapeFieldForSQL($productID);

		$query = "DELETE FROM `sandeliuojama_preke`
				WHERE `fk_PREKEid`='{$productID}'";
		mysql::query($query);
	}




    /**
	 * Product deletion from a warehouse
	 */
	public function deleteProductFromWarehouse($productID, $warehouseID) {
		$productID = mysql::escapeFieldForSQL($productID);
		$warehouseID = mysql::escapeFieldForSQL($warehouseID);

		$query = "DELETE FROM `sandeliuojama_preke`
				WHERE `fk_PREKEid`='{$productID}' AND `fk_SANDELISsandelio_id`='{$warehouseID}'";
		mysql::query($query);
	}

    

	/**
	 * Prekių sandėliuose išrinkimas
	 */
	public function getWarehousedProducts($productID) {
		$contractId = mysql::escapeFieldForSQL($productID);

		$query = "SELECT `sandeliuojama_preke`.`fk_PREKEid`,
					  `sandeliuojama_preke`.`fk_SANDELISsandelio_id`,
					  `sandeliuojama_preke`.`kiekis`,
					  `sandelis`.`pavadinimas`
				FROM `sandeliuojama_preke`
					LEFT JOIN `sandelis`
						ON `sandeliuojama_preke`.`fk_SANDELISsandelio_id`=`sandeliuojama_preke`.`id_SANDELIUOJAMA_PREKE`
				WHERE `fk_Prekeid_Preke`='{$productID}'";
		$data = mysql::select($query);
		
		return $data;
	}
	
}