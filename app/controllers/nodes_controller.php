<?php
/****************************************************************************                                         
 * nodes_controller.php  - Controller for nodes (Village Telco clients)
 *  			   List and edit nodes
 *			   Show nodes on map
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

 class NodesController extends AppController{

       var $name = 'Nodes';

       var $helpers = array('Html','Form','GoogleMap','Ajax','Flash','Session','Javascript', 'Formatting','Number');
       var $paginate = array('Node' => array('order' => array('Node.name' => 'asc'),'limit' => 50));       
       var $components = array('RequestHandler');


/*
 *
 * List all nodes with client details
 *	
 */
       function index(){

                $this->set('title_for_layout', 'Clients');

		//$this->refreshAll();
                $data = $this->paginate('Node');
                $this->set('nodes',$data);
                $this->render();
       }


/*
 *
 * Display all nodes on GoogleMap
 *	
 */
   function map(){

         $this->set('title_for_layout', 'View clients on map');
         $this->refreshAll();
         $conditions = array('NOT' => array('Node1.lat' => null, 'Node1.long' => null,'Node2.lat' => null, 'Node2.long' => null));
         $links_result  = $this->Node->Link->find('all', array('conditions' => $conditions));

          foreach ($links_result as $key => $entry){

              $links[$key]['lat1'] = $entry['Node1']['lat'];
              $links[$key]['long1'] = $entry['Node1']['long'];
              $links[$key]['lat2'] = $entry['Node2']['lat'];
              $links[$key]['long2'] = $entry['Node2']['long'];
              $links[$key]['label'] = $entry['Link']['label'];

              $this->loadModel('Limit');
              $links[$key]['color'] = $this->Limit->getColor('label', min(array($entry['Link']['label'],$entry['Link']['label_reverse'])));
              $links[$key]['distance'] = $this->distance_haversine($entry['Node1']['lat'],$entry['Node1']['long'],$entry['Node2']['lat'],$entry['Node2']['long']);

          }

          $conditions = array('NOT' => array('Node.lat' => null, 'Node.long' => null));
          $nodes_result = $this->Node->find('all', array('conditions' => $conditions));
          $this->set(compact('nodes_result','links'));
          $this->render();

       }


/*
 *
 * Poll link status from VIS and update Links and MissingNodes table.
 *	
 */
   function update(){

      $vis = Configure::read('VIS');
      $this->requestAction('/missing_nodes/update');

      if(!$fp = fsockopen($vis['host'], $vis['port'], $errno, $errstr, $vis['timeout'])){
  
          	    $this->log('ERROR failed to establish connection to VIS server: Error:'.$errno.', '.$errstr, 'node');

      } else {

      	     $data = $vis_link = $links = false;



      	     //MP running bat-adv mode
      	     if($vis['mode'] == 'batman-adv'){

	       //Patch for bat-adv mode: no header data present
	       $header = 'HTTP/1.1 200 OK';

	       while (!feof($fp)) {

	             $line = rtrim(fgets($fp),',\n');
	             $line = trim($line,"\t");
		     $line = preg_split("/[\s,:]+/", $line);

	  	     if(array_key_exists(7, $line) && !in_array('gateway',$line) && !in_array('"gateway"',$line)){

           	     			    $line[1] = '"'.trim($line[1],'"').'"';
           				    $line[3] = '"'.trim($line[3],'"').'"';
           				    $line[5] = '"'.trim($line[5],'"').'"';
           				    $vis_link .= $line[0].$line[1].':'.$line[2].','.$line[3].':'.$line[4].','.$line[5].':'.$line[6].$line[7].",\n";
					    }

					    $vis_link = str_ireplace('neighbor','neighbour',$vis_link);

               }    
             } 
      	     //MP running batman mode
      	     elseif ($vis['mode'] == 'batman') {

	         $header = rtrim(fgets($fp),',\n\t');
      	         $application = rtrim(fgets($fp),',\n\t');


      	     	  //VIS server legacy
      		  if($vis['vis_version'] == 'legacy'){
      
			while (!feof($fp)) {

	  		      $line = rtrim(fgets($fp),',\n');

          		      $line = preg_split("/[\s,:]+/", $line);
	  		      if(array_key_exists(2, $line)){ 
           		      			     $line[2] = '"'.$line[2].'"';
           					     $line[4] = '"'.$line[4].'"';
           					     $line[6] = '"'.$line[6].'"';
           					     $vis_link .= $line[1].$line[2].':'.$line[3].','.$line[4].':'.$line[5].','.$line[6].':'.$line[7].$line[8].",\n";
	   		      }
         		}

      		  } elseif($vis['vis_version'] == 'trunk'){
		  //VIS server trunk (git)
		  
	   	    while (!feof($fp)) {
	      	    	  $vis_link .= rtrim(fgets($fp),',\n');
	    	    }
	          } else {

            	    $this->log('ERROR Invalid VIS server version', 'node');

		  }
             }  else {
	     //INVALID MP mode

            	    $this->log('ERROR Invalid VIS server mode', 'node');
	     }

      	     $data     = rtrim($vis_link,",\n");
      	     $data = "[\n".$data."]";

      	     if($this->headerGetStatus(trim($header))){

		$links = json_decode($data,true);
      	     }

      	     if($links){

		$this->Node->Link->deleteAll(array('Link.id !=' => 0));
      		$this->Node->Link->query('alter table links AUTO_INCREMENT = 0');

        	$missing_nodes = array();
        	foreach ($links as $key => $link){

                	//All nodes but gateway
                	if (!key_exists('gateway', $link)){

                  	   $this->data['neighbour']  = $link['neighbour'];
                  	   $this->data['label']      = $link['label'];
                  	   $router    = $this->Node->findByIpAddr($link['router']);
                  	   $neighbour = $this->Node->findByIpAddr($link['neighbour']);

		  
			  //Node existing in SPUD
		  	  if($router && $neighbour){

		  	  	     $node_id[] = $router['Node']['id'];
                        	     foreach($links as $entry){

                           	     	    if($entry['router'] == $link['neighbour'] && $entry['label']!='HNA'){

			      		    			$this->data['distance'] = $this->distance_haversine($router['Node']['lat'],$router['Node']['long'],$neighbour['Node']['lat'],$neighbour['Node']['long']); 
                              					$this->data['label_reverse'] = $entry['label'];
                             		     }
                        	     }

				     $this->data['neighbour_id']     = $neighbour['Node']['id'];
                  		     $this->data['node_id']          = $router['Node']['id'];
                  		     $this->Node->Link->SaveAll($this->data);
				     $node_id = array_unique($node_id);
				     $time = time();
				     $this->Node->updateAll(array('Node.last_seen' => $time), array('Node.id' => $node_id));
                  		     unset($this->data);

                  	   //Node is not present in SPUD
		           } elseif (!$router) {
	              	     	    $missing_nodes[] = $link['router'];

                  	   //Neighbour is not present in SPUD
		  	   } elseif (!$neighbour) {
	              	     	    $missing_nodes[] = $link['neighbour'];
		           }
                     } //if	
   	      } //foreach

              $this->loadModel('MissingNode');
              foreach(array_unique($missing_nodes) as $node){
	            unset($this->data);
      	    	    $this->data['ip_addr'] = $node;
      	    	    $this->MissingNode->save($this->data);
            	    $this->log('INFO missing nodes CREATED: '.$node, 'node');
              }

        } else {

            	    $this->log('INFO No links found', 'node');

	}

     } //else $fp

     $this->autoRender = false;


   }


/*
 *
 * Add new client to SPUD
 *	
 */
  function add(){

        $this->set('title_for_layout', 'Add Client');
        if(!empty($this->data)){

           $this->Node->set($this->data);

           if($this->Node->save($this->data['Node'])){
	   	  $this->refreshAll();
                  $this->Session->setFlash(__("Client successfully added.",true),'flash_success');
                  $this->redirect(array('action' => 'index'));
 
           } else {
                  $this->render();
           }
         }
  }


/*
 *
 * Edit client data. Edit GPS position by moving marker on GoogleMap
 *	
 */
 function edit ($id  = null){

     $this->set('title_for_layout', 'Edit client');

     if(empty($this->data['Node'])){
           if($id) {
	         $conditions = array('NOT' => array('Node.lat' => null, 'Node.long' => null,'Node.id' => $id));
          	 $nodes      = $this->Node->find('all', array('conditions' => $conditions));
          	 $this->set(compact('nodes'));
                 $this->data = $this->Node->read(null,$id); 
                 $this->render();
           } else {
                 $this->redirect(array('action' =>'/')); 
           }
     } else {         
           if($this->Node->save($this->data)){
	   	 $this->refreshAll();
                 $this->Session->setFlash(__("Client successfully updated.",true),'flash_success');
                 $this->redirect(array('action' => 'index'));
           }
     }
  }

   
/*
 *
 * Import bulk client in CSV format
 *	
 */
 function import(){

   $this->set('title_for_layout', 'Import clients');
   if($this->data){

           $tmp_name = $this->data['Node']['file']['tmp_name'];
           $file_content = file($tmp_name);
           unset($this->data['Node']['file']);

           foreach ($file_content as $key => $line){

               $line = explode(',',$line);   
	       $size = count($line);        
	       if($size >= 1){ $this->data['Node']['ip_addr']  = trim($line[0]); }
               if($size >= 2){ $this->data['Node']['type']     = trim($line[1]); }
               if($size >= 3){ $this->data['Node']['name']     = trim($line[2]); }
               if($size >= 4){ $this->data['Node']['surname']  = trim($line[3]); }
               if($size >= 5){ $this->data['Node']['address']  = trim($line[4]); }
               if($size >= 6){ $this->data['Node']['lat']      = trim($line[5]); }
               if($size >= 7){ $this->data['Node']['long']     = trim($line[6]); }
               if($size >= 8){ $this->data['Node']['mobile']   = trim($line[7]); }
               if($size >= 9){ $this->data['Node']['landline'] = trim($line[8]); }
               if($size >= 10){ $this->data['Node']['email']    = trim($line[9]); }
               if($size >= 11){ $this->data['Node']['comment']  = trim($line[10]); }
               if($size >= 12){ $this->data['Node']['firmware']  = trim($line[11]); }

               $this->Node->create();

               if($this->Node->save($this->data['Node'])){
                     $this->log('SUCCESS node import '.$this->data['Node']['ip_addr'], 'node');
               } else {
                     $this->log('FAILURE node import '.$this->data['Node']['ip_addr'], 'node');
               }
           }

	   $this->refreshAll();
           $this->redirect(array('action' => 'index'));


        } else {
             $this->render();
        }
  }



/*
 *
 * Show client details in AJAX drop-down window
 *
 * @params
 *		$id(int) = Client id
 */
   function details($id = null){

         $this->set('title_for_layout', 'Client details');
         $details = $this->Node->findById($id);
         
         $this->loadModel('Limit');
         $limits = $this->Limit->getLimits();
         $this->set(compact('details','limits'));
         $this->log('AJAX details', 'node');

   }


/*
 *
 * Delete client and corresponding links
 *
 * @params
 *		$id(int) = Client id
 */
   function delete($id = null){


             if($this->Node->delete($id,true)) {            
                   $this->Session->setFlash(__("Selected client has been deleted.",true),'flash_success');
                   $data = $this->Node->getIdentifier($id);
		   $this->log("INFO DELETE {ID: ".$id."; NAME: ".$data['Node']['name']." ".$data['Node']['surname']."}", "node");
		   $this->refreshAll();
             }
             $this->redirect(array('action' => 'index')); 
    }



}
?>