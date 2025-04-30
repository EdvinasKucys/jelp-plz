<?php
/**
 * Manufacturer editing class
 *
 * @author E9160
 */

class Manufacturer {
    

    /**
     * Getting manufacturer list
     */
    public function getManufacturerList($limit = null, $offset = null): array 
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
        
        $query = "SELECT `gamintojas`.`gamintojo_id`,
                      `gamintojas`.`pavadinimas`,
                      `gamintojas`.`salis` AS `salis`,
                      `gamintojas`.`kontaktai`
                FROM `gamintojas`
                {$limitOffsetString}";
        $data = mysql::select($query);
        return $data;
    }

    /**
     * Get manufacturer amount
     */
    public function getManufacturerListCount(): int 
    {
        $query = "SELECT COUNT(`gamintojas`.`gamintojo_id`) as `kiekis`
                    FROM `gamintojas`";
        $data = mysql::select($query);
        
        return $data[0]['kiekis'];
    }
    
    /**
     * Editing existing manufacturer
     */
    public function updateManufacturer($data) {
        $data = mysql::escapeFieldsArrayForSQL($data);
        
        $query = "UPDATE `gamintojas`
                SET `pavadinimas`='{$data['pavadinimas']}',
                    `salis`='{$data['salis']}',
                    `kontaktai`='{$data['kontaktai']}'
                WHERE `gamintojo_id`='{$data['gamintojo_id']}'";
        mysql::query($query);
    }
    
    /**
     * inserting manufacturer
     */
    public function insertManufacturer($data) {
        $data = mysql::escapeFieldsArrayForSQL($data);

        $query = "INSERT INTO `gamintojas`
                          (`pavadinimas`,
                           `salis`,
                           `kontaktai`)
                VALUES    ('{$data['pavadinimas']}',
                           '{$data['salis']}',
                           '{$data['kontaktai']}')";
        mysql::query($query);
        
        // Return the last inserted ID
        return mysql::getLastInsertedId();
    }
    
    /**
     * Deleting manufacturer
     */
	public function getManufacturer($id) {
		// Remove the int type hint from the parameter
		$id = mysql::escapeFieldForSQL($id);
	
		$query = "SELECT *
				FROM `gamintojas` WHERE `gamintojo_id`='{$id}'";
		$data = mysql::select($query);
		
		return $data[0];
	}
	
	/**
	 * Apply the same fix to all other methods that use type hints for IDs
	 * For example:
	 */
	public function deleteManufacturer($id) {
		// Remove the int type hint if it exists
		$id = mysql::escapeFieldForSQL($id);
	
		$query = "DELETE FROM `gamintojas`
				WHERE `gamintojo_id`='{$id}'";
		mysql::query($query);
	}
	
	public function getProductCountOfManufacturer($id) {
		// Remove the int type hint if it exists
		$id = mysql::escapeFieldForSQL($id);
	
		$query = "SELECT COUNT(`gamintojas`.`gamintojo_id`) AS `kiekis`
				FROM `gamintojas`
					INNER JOIN `preke`
						ON `preke`.`fk_GAMINTOJASgamintojo_id`=`gamintojas`.`gamintojo_id`
				WHERE `gamintojas`.`gamintojo_id`='{$id}'";
		$data = mysql::select($query);
		
		return $data[0]['kiekis'];
	}
}