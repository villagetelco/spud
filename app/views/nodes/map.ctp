<?php                                                                                                                 
/****************************************************************************                                         
 * map.ctp    - Display nodes and links using GoogleMaps (v3)
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

     echo $html->addCrumb('Clients', '');                                                                 
     echo $html->addCrumb('Map', '/nodes/Map');

     echo $form->create('Node',array('type' => 'post','action'=> 'map'));
     echo $html->div('frameRightAlone',$form->submit(__('Refresh',true),  array('name' =>'submit', 'class' => 'button')));
     echo $form->end();

     $zoom = 16;
     $type = 'ROADMAP';


     //Create Markers for nodes
     if($nodes_result){

        foreach ($nodes_result as $key => $node){

            $nodes[$key]['Point']['icon']      = $formatting->getIcon($node['Node']['type']);
            $nodes[$key]['Point']['latitude']  = $node['Node']['lat'];
            $nodes[$key]['Point']['longitude'] = $node['Node']['long'];
            $nodes[$key]['Point']['title']     = __("Name",true).': '.$node['Node']['name'].' '.$node['Node']['surname'];
            $inner_html                        = '<div>'.__("Address",true).': '.$node['Node']['address'].'</div>';
            $inner_html                       .= '<div>'.__("IP address",true).': '.$node['Node']['ip_addr'].'</div>';
            $inner_html                       .= '<div>'.__("Last seen",true).': '.$formatting->getLastSeen($node['Node']['last_seen']).'</div>';
            $unique_id = rand();
     //       $inner_html                       .= "<div><a href='/spud/nodes/details/{$node['Node']['id']}' id='link{$unique_id}' onclick='event.returnValue = false; return false;'>View details</a></div>";
            $inner_html                       .= "<div><a href='/spud/nodes/details/{$node['Node']['id']}' id='link{$unique_id}'>View details</a></div>";

            //$js_ajax[]                        = "Event.observe('link{$unique_id}', 'click', function(event) { new Ajax.Updater('results','/spud/nodes/details/{$node['Node']['id']}', {asynchronous:true, evalScripts:true, requestHeaders:['X-Update', 'results']}) }, false);";

            $nodes[$key]['Point']['html']      = $inner_html;
            $lat[] = $node['Node']['lat'];
            $long[] = $node['Node']['long'];

        }

      }
      //No nodes to display. Show empty map. 
      else {

          $lat = array(0);
          $long= array(0);
          $nodes = false;
          $zoom = 1;

          echo $html->div('info-message',__('There are no clients to display on the map.',true));
       }

          $lat_centre = (max($lat)-min($lat))/2 + min($lat);
          $long_centre = (max($long)-min($long))/2 + min($long);


        //# ROADMAP displays the normal, default 2D tiles of Google Maps.
        //# SATELLITE displays photographic tiles.
        //# HYBRID displays a mix of photographic tiles and a tile layer for prominent features (roads, city names).
        //# TERRAIN displays physical relief tiles for displaying elevation and water features (mountains, rivers, etc.).

	//Display map
        $default = array('type'=> $type,'zoom'=>$zoom,'lat'=>$lat_centre,'long'=> $long_centre);
        $key = $this->GoogleMap->key;
        echo $javascript->link($this->GoogleMap->url);
        echo $this->GoogleMap->map($default,'width: 1000px; height: 790px');
        

	//Display nodes
        if ($nodes) {

           echo $this->GoogleMap->addMarkers($nodes);
           echo "<div id='details'></div>";

	   	  //Display links
                  if ($links){
                     foreach ($links as $link){                    
                        echo $this->GoogleMap->drawLine($link,$zoom);
                        //echo "Distance [km] ".$link['distance']."</br>";
                     }
                  }

           }


?>
