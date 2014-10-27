<?php                                                                                                                 
/****************************************************************************                                         
 * add.ctp    - Add a MP node
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
                                                                              
     echo $html->addCrumb('Clients', '/nodes');       
     echo $html->addCrumb('Add', '/nodes/add');
     echo "<h1>".__("Add client",true)."</h1>";

                                                                                                                      
     if ($messages = $session->read('Message.multiFlash')) {
           foreach($messages as $k=>$v) $session->flash('multiFlash.'.$k);
     }

     $type = array('client'=> __('Client',true),'supernode' => __('Supernode',true), 'gateway' => __('Gateway',true));

     echo $form->create('Node', array('type' => 'post', 'action' => 'add','enctype' => 'multipart/form-data') );



     echo "<div class='frameLeft'>";                                                                                     
     echo "<table width='500px' cellspacing='0' class='blue'>";                                                          
     echo $html->tableCells(array (                             
     array(__("Name",true),                     $form->input('name',array('label'=>false))),                           
     array(__("Surname",true),                  $form->input('surname',array('label'=>false))),
     array(__("Address",true),                  $form->input('address',array('label'=>false))),                   
     array(__("Email",true),                    $form->input('email',array('label'=>false))),                            
     array(__("Mobile number",true),            $form->input('mobile',array('label'=>false))),               
     array(__("Landline",true),                 $form->input('landline',array('label'=>false))),               
     array(__("IP address",true),               $form->input('ip_addr',array('label'=>false))),                     
     array(__("Latitude",true),                 $form->input('lat',array('label'=>false))),
     array(__("Longitude",true),                 $form->input('long',array('label'=>false))),
     array(__("Type",true),                     $form->input('type',array('type'=>'select','options'=>$type, 'label'=>false))),
     array($form->submit(__('Save',true),  array('name' =>'data[Submit]', 'class' => 'button')),'')                      
     ),array('class' => 'blue'),array('class' => 'blue'));                                                               
     echo "</table>";                                                                                                    
     echo $form->end();                                                                                                  
     echo "</div>";     

?>