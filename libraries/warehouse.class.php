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
                      `sandelis`.`adresas`
                FROM `sandelis`
                {$limitOffsetString}";
        $data = mysql::select($query);
        
        return $data;
    }

    /**
     * Warehouse counting
     */
    public function getWarehouseListCount(): int 
    {
        $query = "SELECT COUNT(`sandelis`.`sandelio_id`) as `kiekis`
                    FROM `sandelis`";
        $data = mysql::select($query);
        
        return $data[0]['kiekis'];
    }
    
    /**
     * New Product adding to warehouse
     * @param type $productID
     * @param type $warehouseID
     * @param type $quantity
     */
    public function insertWarehouseProduct($productID, $warehouseID, $quantity)
    {
        $productID = mysql::escapeFieldForSQL($productID);
        $warehouseID = mysql::escapeFieldForSQL($warehouseID);
        $quantity = mysql::escapeFieldForSQL($quantity);
        
        $checkQuery = "SELECT `sandeliuojama_preke`.`id_SANDELIUOJAMA_PREKE` FROM `sandeliuojama_preke`
                  WHERE `sandeliuojama_preke`.`fk_PREKEid`='{$productID}' AND 
                  `sandeliuojama_preke`.`fk_SANDELISsandelio_id`='{$warehouseID}'";
        $existingRecords = mysql::select($checkQuery);

        if (!empty($existingRecords)) {
            // If product already exists in this warehouse, update the quantity
            $existingId = $existingRecords[0]['id_SANDELIUOJAMA_PREKE'];

            $updateQuery = "UPDATE `sandeliuojama_preke`
                       SET `kiekis` = `kiekis` + {$quantity} 
                       WHERE `id_SANDELIUOJAMA_PREKE`='{$existingId}'";

            mysql::query($updateQuery);
        } else {
            // If product doesn't exist in this warehouse, create a new record
            $insertQuery = "INSERT INTO `sandeliuojama_preke`
                      (`kiekis`,
                       `fk_SANDELISsandelio_id`,
                       `fk_PREKEid`)
                VALUES ('{$quantity}',
                       '{$warehouseID}',
                       '{$productID}')";

            mysql::query($insertQuery);
        }
    }

    /**
     * Getting warehoused products
     */
	public function getWarehousedProducts($warehouseID) {
		$warehouseID = mysql::escapeFieldForSQL($warehouseID);
	
		$query = "SELECT 
					  `sandeliuojama_preke`.`fk_PREKEid`,
					  `sandeliuojama_preke`.`fk_SANDELISsandelio_id`,
					  `sandeliuojama_preke`.`kiekis` AS `saugomas_kiekis`,
					  `sandelis`.`pavadinimas` AS `sandelio_pavadinimas`,
					  `preke`.`pavadinimas` AS `prekes_pavadinimas`,
					  `sandelis`.`adresas`
					  -- Removed 'sandelis.talpa' since it doesn't exist
				FROM `sandeliuojama_preke`
					LEFT JOIN `sandelis`
						ON `sandeliuojama_preke`.`fk_SANDELISsandelio_id`=`sandelis`.`sandelio_id`
					LEFT JOIN `preke` 
						ON `sandeliuojama_preke`.`fk_PREKEid`=`preke`.`id`
				WHERE `fk_SANDELISsandelio_id`='{$warehouseID}'";
		$data = mysql::select($query);
		return $data;
	}
}