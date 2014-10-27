<?php
/****************************************************************************   
 * limits_controller.php  - Controller for limits (Max and min values of B.A.T.M.A.N labels to determine link quality)
 * 			    Edit B.A.T.M.A.N label limits and link colors
 *
 * version		  - 1.0 
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

class LimitsController extends AppController{

      var $name = 'Limits';

      var $helpers = array('Html','Form','Session');      

/*
 * 
 * Edit signal quality limits and colors.
 *	
 */
 function edit(){

        if($this->data){

         if($this->data['Limit'][0]['min'] > $this->data['Limit'][1]['min']){

                 $this->data['Limit'][0]['max'] = 100;
                 $this->data['Limit'][1]['max'] = $this->data['Limit'][0]['min'];
                 $this->data['Limit'][2]['max'] = $this->data['Limit'][1]['min'];
                           
                 foreach($this->data['Limit'] as $key => $limit){
                          $data[$key] = array('Limit' => $limit);
                 }
                 $this->Limit->set($data);
                if($this->Limit->saveAll($data, array('validate' => 'only'))){
                          $this->Limit->saveAll($data);
                          $this->Session->setFlash(__("Limits successfully updated.",true),'flash_success');
                 } else {
                          $errors = $this->Limit->invalidFields();

                 }

               } else {

                       $this->Session->setFlash(__("Min value for Good, must be lower than Min value for Poor.",true),'flash_failure');
               }

          }
          $this->data = $this->Limit->find('all');
  }


}

?>