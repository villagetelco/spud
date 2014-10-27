<?php
/****************************************************************************                                         
 * node.php  - Model for nodes (Village Telco clients)
 * version   - 1.0 
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

class Node extends AppModel {

    var $name = 'Node';

    var $hasMany = array(
        'Link' => array('order' => 'Link.neighbour DESC', 'dependent' => true)
        );


function __construct($id = false, $table = null, $ds = null) {                                  
       parent::__construct($id, $table, $ds);                                                  
                                                                                                
       $this->validate = array(                                                                  
        'email' => array(                                                                       
                        'between' => array(                                                     
                                       'rule' => array('between', 1, 50),                       
                                       'message' => __('Between 1 to 50 characters.',true),      
                                       'allowEmpty' => true                                     
                                       ),                                                       
                        'email' =>array(                                                        
                                     'rule' => array('email',true),                             
                                     'message' => __('Please supply a valid email address.',true),
                                     'allowEmpty' => true                                       
                                       )                            
                        ),
        'name' => array(                                                                        
                        'rule'     => '/^[a-zA-Z0-9 -.\']+$/i',                 
                        'required' =>  true,
                        'message'  => __('Only letters, spaces and hyphens.',true)
                        ),                                                      
        'surname' => array(                                                                     
                        'rule'     => '/^[a-zA-Z0-9 -.\']+$/i',                 
                        'allowEmpty' =>  true,
                        'message'  => __('Only letters, spaces and hyphens.',true)
                        ),                                                      
        'address' => array(  
                        'rule'     => '/^[a-zA-Z0-9 -.\']+$/i',                 
                        'allowEmpty' =>  true,                                  
                        'message'  => __('Only letters, spaces and hyphens.',true)
                        ),                                                       
        'ip_addr' => array(
                  'validIP' => array(
                        'rule' => array('validIP','ip_addr'),
                        'allowEmpty' =>  false,
                        'required'   => true,
                        'message' => __('Invalid IP address.',true)
                        ),
                   'isUnque' => array(
                        'rule' => array('isUnique'),
                        'allowEmpty' =>  false,
                        'required'   => true,
                        'message' => __('IP address must be unique.',true)
                        )
                       ),
        'type'   => array(
                        'rule' => array('inList', array('client','gateway','supernode')),
                        'allowEmpty' =>  false,
                        'required'   => true,
                        'message' => __('Invalid type of node.', true)
                        ),
        'lat' => array(                                                                       
                        'decimal' => array(                                                     
                                       'rule' => array('decimal'),                       
                                       'message' => __('Latitude must be a decimal number.',true),      
                                       'allowEmpty' => true,
                                       'required'   => false,
                                       ),                                                       
                        'range' =>array(                                                        
                                     'rule' => array('range',-90, 90),                             
                                     'message' => __('Latitude is not in valid range (-90 to 90).',true),
                                     'allowEmpty' => true, 
                                     'required'   => false,                                   
                                       )                            
                        ),
        'long' => array(                                                                       
                        'decimal' => array(                                                     
                                       'rule' => array('decimal'),
                                       'message' => __('Longitude must be a decimal number.',true),      
                                       'allowEmpty' => true,                                   
                                       'required'   => false,
                                       ),                                                       
                        'range' =>array(                                                        
                                     'rule' => array('range',-180, 180),                             
                                     'message' => __('Longitude is not in valid range (-180 to 180).',true),
                                     'allowEmpty' => true,
                                       'required'   => false,                                   
                                       )     
                        )

        );
    }



/*
 *
 * Validation of IP address
 * @params:
 *		$data(array)   = $node 
 *		$field(string) = ip_addr
 *
 * @return:
 *		boolean
 *	
 */

                                                                                       
 function validIP($data,$field) {                                                                 

        $ip = $data[$field];                                                           
        $cIP = ip2long($ip);                                                               
        $fIP = long2ip($cIP);                                                              
                                                                                               
        if($fIP=='0.0.0.0'){                                                               
            return false;                                                                   
        } else {                                                                        
            return true;                                                                    
        }                                                                               
  }
}

?>
