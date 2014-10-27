<?php                                                                                                                 
/****************************************************************************                                         
 * formatting.php    - Formatting helper for views
 * version     	     - 1.0                                                                     
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


 class FormattingHelper extends AppHelper {

 
    function getIcon($type){

     $spud  = Configure::read('SPUD');

        switch ($type){

                  case 'client':
                  $icon = "http://".$spud['host']."/spud/img/icons/client.png";
                  break;

                  case 'client_edit':
                  $icon = "http://".$spud['host']."/spud/img/icons/client_large.png";
                  break;

                  case 'client_default':
                  $icon = "http://".$spud['host']."/spud/img/icons/default.png";
                  break;

                  case 'supernode':
                  $icon = "http://".$spud['host']."/spud/img/icons/supernode.png";
                  break;

                  case 'gateway':
                  $icon = "http://".$spud['host']."/spud/img/icons/gateway.png";
                  break;


           }

	   return  $icon;
    }


  function getLastSeen($epoch){

   	   if($epoch) { 
	   	return date('M j, Y H:i',$epoch);
           } else {
	        return __('Never',true);
	   }

  }

}