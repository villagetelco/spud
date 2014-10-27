<?php
/****************************************************************************                                         
 * limit.php  - Model for limits (Max and min values of B.A.T.M.A.N labels to determine link quality)
 * version    - 1.0 
 *
 * Version: MPL 1.1
 *
 * The contents of this file are subject to the Mozilla Public License Version
 * 1.1 (the "License"); you may not use this file except in compliance with                                        
 * the License. You may obtain a copy of the License at                                           
 * http://www.mozilla.org/MPL/                                                               
 *                                                                                         
 * Software distributed under the License is distributed on an "AS IS" basis,
 * WITHOUT WARRANTY OF ANY KIND, either express or implied. See the License                                         
 * for the specific language governing rights and limitations under the                                           
 * License.                                               
 *                                                                                                           
 * 
 * The Initial Developer of the Original Code is
 *   Louise Berthilson <louise@it46.se>                                                                      
 *                                                                               
 *
***************************************************************************/

class Limit extends AppModel {

    var $name = 'Limit';

        function getColor($type , $value){

		 if($value){
			$result = $this->find('first', array('conditions' => array('Limit.type' => $type, 'Limit.min <' => $value,  'Limit.max >=' => $value)));
                 	return '#'.$result['Limit']['color'];
                 } else {

		 	return '#000000';
		 
		 }

        }

function __construct($id = false, $table = null, $ds = null) {                                  
        parent::__construct($id, $table, $ds);                                                  
                                                                                                
      $this->validate = array(
        'color' => array (
                        'between' => array(                                                     
                                       'rule' => array('between', 6, 6),                       
                                       'message' => __('Six characters.',true),      
                                       'allowEmpty' => false                              
                                       ),
                        'rgb' => array(                                                                        
                                       'rule'     => '/^[a-fA-F0-9]+$/i',                 
                                       'allowEmpty' =>  false,
                                       'message'  => __('Allowed characters: A-F, 0-9',true),
                        )),     
       'min' =>	array(
       		'numeric' => array(
                        'rule' => 'numeric',
                        'message'  => __('Value must be numeric.',true),
                        'allowEmpty' => false,
                        ),
       		'range' => array(
                        'rule' => array('range',1,99),
                        'message'  => __('Value must be in the range 1-99.',true),
                        'allowEmpty' => false,
                        )));

                        }


/*
 *
 * Get set limits and colors
 * @params:
 *		
 * @return:
 *		array[0] = Limit between Poor and Good
 *		array[1] = Limit between Good and Excellent
 *		array[3] = array(color for Poor, color for Good, color for Excellent)
 *	
 */
   function getLimits(){

        $limits = $this->find('all', array('conditions' => array('Limit.type' => 'label')));
        foreach($limits as $key => $limit){

             if($limit['Limit']['name']=='med'){
                    $min = $limit['Limit']['min'];
                    $max = $limit['Limit']['max'];
             }

             $color[$limit['Limit']['name']] = $limit['Limit']['color'];
        }

        return array($min,$max,$color);

   }
          
}

?>