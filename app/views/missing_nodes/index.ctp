<?php                                                                                                                 
/****************************************************************************                                         
 * index.ctp    - Display welcome page and missing nodes
 * version      - 1.0                                                                     
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


     echo $html->addCrumb('Welcome', '/'); 

     echo "<h1>".__('Welcome to SPUD',true)."</h1>";

     echo $html->div('info-message',__('SPUD is a monitoring and visualization tool for Village Telco networks.',true));
     if($data){

     echo "<h2>".__('Missing Clients',true)."</h2>";
     echo $html->div('info-message', __('Note that the clients listed below are present in your network (active nodes), but are not yet added to SPUD.',true));
     echo $html->div('info-message', __('Please add the Clients below to SPUD.',true));

     	  echo "<table class='none'>";
     	  echo $html->tableHeaders(array(
                        __("IP address",true),
                        __("Active since",true)));

     	  foreach($data as $entry){

	    $row[] = array($entry['MissingNode']['ip_addr'],$entry['MissingNode']['created']);

	  }

     echo $html->tableCells($row, array('class'=> 'none'),array('class'=> 'none'));
     echo "</table>";
     }

     


?>