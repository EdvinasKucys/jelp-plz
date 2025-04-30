<?php
/**
 * Warehouse editing class
 *
 * @author E9160
 */

class Warehouse {

	
	/**
	 * Getting warehouse
	 */
	public function getWarehouse(int $id) {
		$id = mysql::escapeFieldForSQL($id);

		$query = "SELECT *
				FROM `sandelis`
				WHERE `sandelio_id`='{$id}'";
		$data = mysql::select($query);
		
		return $data[0];
	}
	
	/**
	 * Getting warehouse list
	 */
	public function getWarehouseList($limit = null, $offset = null): array 
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
		
		$query = "SELECT `sandelis`.`sandelio_id`,
					  `sandelis`.`pavadinimas`,
                      `sandelis`.`adresas`,
				FROM `sandelis`
				{$limitOffsetString}";
		$data = mysql::select($query);
		
		return $data;
	}

	/**
	 * Manufacturer counting
	 */
	public function getWarehouseListCount(): int 
	{
		$query = "SELECT COUNT(`sandelis`.`sandelis_id`) as `kiekis`
					FROM `sandelis`";
		$data = mysql::select($query);
		
		return $data[0]['kiekis'];
	}
	

	/**
	 * New Product adding
	 * @param type $data
	 */
    public function insertWarehouseProduct($data)
	{
		$data = mysql::escapeFieldsArrayForSQL($data);
		
		$checkQuery = "SELECT `sandeliuojama_preke`.`id_SANDELIUOJAMA_PREKE` FROM `sandeliuojama_preke`
                  WHERE `sandeliuojama_preke`.`fk_PREKEid`='{$data['fk_PREKEid']}' AND 
				  `sandeliuojama_preke`.`fk_SANDELISsandelio_id`='{$data['fk_SANDELISsandelio_id']}'";
		$existingRecords = mysql::select($checkQuery);

		if (!empty($existingRecords)) {
			// If product already exists in this warehouse, update the quantity
			$existingId = $existingRecords[0]['id_SANDELIUOJAMA_PREKE'];

			$updateQuery = "UPDATE `sandeliuojama_preke`
                       SET `sandeliuojama_preke`.`kiekis` = `sandeliuojama_preke`.`kiekis` + {$data['kiekis']} 
                       WHERE `sandeliuojama_preke`.`id_SANDELIUOJAMA_PREKE`='{$existingId}'";

			mysql::query($updateQuery);
		} else {
			// If product doesn't exist in this warehouse, create a new record
			$insertQuery = "INSERT INTO `sandeliuojama_preke`
                      (`kiekis`,
                       `fk_SANDELISsandelio_id`,
                       `fk_PREKEid`)
                VALUES ('{$data['kiekis']}',
                       '{$data['fk_SANDELISsandelio_id']}',
                       '{$data['fk_PREKEid']}')";

			mysql::query($insertQuery);
		}
	}




    /**
	 * Getting warehoused products
	 */
	public function getWarehousedProducts($warehouseID) {
		$contractId = mysql::escapeFieldForSQL($warehouseID);

		$query = "SELECT `sandeliuojama_preke`.`fk_PREKEid`,
					  `sandeliuojama_preke`.`fk_SANDelissandelio_id`,
					  `sandeliuojama_preke`.`kiekis`,
					  `sandelis`.`pavadinimas` AS sandelio_pavadinimas,
                      `prekes`.`pavadinimas` AS prekes_pavadinimas,
                      `sandelis`.`adresas`,
				FROM `sandeliuojama_preke`
					LEFT JOIN `sandelis`
						ON `sandeliuojama_preke`.`fk_SANDelissandelio_id`=`sandelis`.`sandelio_id`
                    LEFT JOIN `prekes` 
                        ON `sandeliuojama_preke`.`fk_PREKEid`=`preke`.`id`
				WHERE `fk_warehouseID_Sandelis`='{$warehouseID}'";
		$data = mysql::select($query);
		return $data;
	}
}