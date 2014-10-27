<?php                                                                                                                 
/****************************************************************************                                         
 * import.ctp    - Import CSV files with MP nodes
 * version       - 1.0                                                                     
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
                                                                              
     echo $html->addCrumb('Clients', '');                                                                 
     echo $html->addCrumb('Import', '/nodes/import');
     echo "<h1>".__("Import clients",true)."</h1>";

     echo $html->div('info-message',__('Import clients in bulk from a comma separated file. Each line must contain one client with the following format:',true));
     echo $html->div('pre',__('IP address, type {client,supernode,gateway}, first name, last name, address, latitude, longitude, phone number (landline), mobile phone, email, comment, MP firmware',true));                                                                                                                      
     if ($messages = $session->read('Message.multiFlash')) {
           foreach($messages as $k=>$v) $session->flash('multiFlash.'.$k);
     }

     echo $form->create('Node', array('type' => 'post', 'action' => 'import','enctype' => 'multipart/form-data') );

     $row[] = array(__("CSV file",true), $form->input('file',array('label'=>false,'type'=>'file')));       
     $row[] = array(array(__("Comma separated, one client per line.",true),"colspan='2' class='formComment'"));

     $row[] = array(array($form->end(__('Save',true)), array('colspan' =>2, 'align' => 'center'))); 

     echo "<table cellspacing = 0 class='stand-alone'>";
     echo $html->tableCells($row, array('class'=>'stand-alone'),array('class'=>'stand-alone'));
     echo "</table>";

?>