<?php
/****************************************************************************                                         
 * missing_node.php  - Model for missing nodes (active nodes, but not yet added to SPUD)
 * version           - 1.0 
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

class MissingNode extends AppModel {

    var $name = 'MissingNode';

    function __construct($id = false, $table = null, $ds = null) {                                  
        parent::__construct($id, $table, $ds);                                                  
                                                                                                
      $this->validate = array(
        'ip_addr' => array(
                        'rule' => array('isUnique'),
                        'allowEmpty' =>  false,
                        'required'   => true,
                        'message' => __('IP address must be unique.',true)
                        ));
    }


}

?>