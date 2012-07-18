<?php
/**
 * Application model for Cake.
 *
 * This file is application-wide model file. You can put all
 * application-wide model-related methods here.
 *
 * PHP versions 4 and 5
 *
 * CakePHP(tm) : Rapid Development Framework (http://cakephp.org)
 * Copyright 2005-2010, Cake Software Foundation, Inc. (http://cakefoundation.org)
 *
 * Licensed under The MIT License
 * Redistributions of files must retain the above copyright notice.
 *
 * @copyright     Copyright 2005-2010, Cake Software Foundation, Inc. (http://cakefoundation.org)
 * @link          http://cakephp.org CakePHP(tm) Project
 * @package       cake
 * @subpackage    cake.cake.libs.model
 * @since         CakePHP(tm) v 0.2.9
 * @license       MIT License (http://www.opensource.org/licenses/mit-license.php)
 */

/**
 * Application model for Cake.
 *
 * This is a placeholder class.
 * Create the same file in app/app_model.php
 * Add your application-wide methods to the class, your models will inherit them.
 *
 * @package       cake
 * @subpackage    cake.cake.libs.model
 */
class AppModel extends Model {
	
// For associationForeignKey
	function beforeFind($queryData){
		//Make sure swapKeys variable is initalized
		$this->swapKeys = array();
		
		//Check if any belongsTo association is defined in the Model
		if(isset($this->belongsTo) && !empty($this->belongsTo)) {
			foreach($this->belongsTo as $key => $value) {
				if(!is_array($value)) continue;  
				//Check if associationForeignKey is defined.
				//If it is, then change the primary key of the associated model
				if(array_key_exists('associationForeignKey', $value) 
					  && !empty($value['associationForeignKey'])){
						 $this->swapKeys[$key] = $this->{$key}->primaryKey;  // save orignal primary key
						 $this->{$key}->primaryKey = $value['associationForeignKey']; //change primary key
				}
			} //next $key
		} //endif
	}  //end beforeFind
	
	//
	// Defining afterFind function. This function is called by CakePHP after it executed a query
	//                     
	function afterFind($results){                  
		//reset primary keys for all belongsTo association
		if (isset($this->swapKeys)) {
			foreach($this->swapKeys as $key => $value)
				  $this->{$key}->primaryKey = $value;
			unset($this->swapKeys);
		}
		return $results; 
	}
	
}
