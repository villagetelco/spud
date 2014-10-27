<?php
/****************************************************************************                                         
 * app_controller.php    - Actions general to all controllers
 *
 * version           		 - 1.0 
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
App::import('Core','L10n');

class AppController extends Controller {                                                                                                                    
                                                                                                                                                            
var $helpers = array('Form','Paginator','Javascript');
var $components = array('RequestHandler','Session');

/*
 *
 * Calculate distance between two nodes based on GPS position
 *	
 * @params
 *		$lat1  (float) Latitude of Node 1
 *		$long1 (float) Latitude of Node 1
 *		$lat2  (float) Longitude of Node 2
 *		$long2 (float) Longitude of Node 2
 *
 * @return
 *		$distance (float) Distance in km
 * 
 */
 
 function distance_haversine($lat1,$lng1,$lat2,$lng2) {

          $earth_radius = 3960;

          $delta_lat = $lat2 - $lat1;
          $delta_lon = $lng2 - $lng1;


          $alpha    = $delta_lat/2;
          $beta     = $delta_lon/2;


          $a        = (sin(deg2rad($alpha)) * sin(deg2rad($alpha))) + (cos(deg2rad($lat1)) * cos(deg2rad($lat2)) * sin(deg2rad($beta)) * sin(deg2rad($beta))) ;
          $c        = asin(min(1, sqrt($a)));
          $distance = 2*$earth_radius * $c;


          $distance = round($distance, 4);

          return $distance;

 }

                                                                                                              
/*
 *
 * Get status of HTTP header
 *	
 * @params
 *		$header (text) 
 *
 * @return
 *		$status (int) 
 *			1 = 200 OK
 * 			0 = All other headers
 */
     function headerGetStatus($header){                                                                           
                                                                                                                  
              $status = false;                                                                                    
                                                                           
              switch(trim($header,'\n\t')){  
                            
                                                                                     
                case 'HTTP/1.0 200 OK':                                                                           
                $status = 1;                                                                                      
                break;                                                                                            
                                                                                                                  
                case 'HTTP/1.1 200 OK':                                                                           
                $status = 1;                                                                                      
                break;                                                                                            
                                                                                                                  
              }                                                                                                   

              return $status;                                                                                     
                                                                                                                  
     }


/*
 *
 * Refresh of link data from VIS. Update of missing nodes.
 *	
 */

     function refreshAll(){

      $this->requestAction('/nodes/update');
      $this->requestAction('/missing_nodes/update');

     }

}

?>