<?php
/****************************************************************************                                         
 * missing_nodes_controller.php  - Controller for missing nodes (active nodes, but not yet added to SPUD).
 *  				   Lists missing nodes on SPUD welcome page.
 *				   Updates missing nodes status fron cronjob or Reload buttons
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

class MissingNodesController extends AppController{

      var $name = 'MissingNodes';
      var $helpers = array('Html');

/*
 * Lists missing nodes
 *
 * 
 *	
 */
  function index(){

                $this->set('title_for_layout', 'Welcome to Spud');

		$this->refreshAll();
                $missing_nodes = $this->MissingNode->find('all');
                $this->set('data', $missing_nodes);
                $this->render();
     	       

      }

/*
 * Updates status of missing nodes, by comparison of existing nodes in the system.
 *
 * 
 *	
 */
  function update(){


                $this->log('INFO missing nodes update', 'node');
                $missing_nodes = $this->MissingNode->find('all');
		$this->loadModel('Node');
                $nodes = $this->Node->find('list',array('fields'=> array('Node.ip_addr')));

		foreach($missing_nodes as $missing_node){
		     if(in_array($missing_node['MissingNode']['ip_addr'],$nodes)){
			$this->MissingNode->delete($missing_node['MissingNode']['id']);
                	$this->log('SUCCESS missing nodes DELETE: '.$missing_node['MissingNode']['ip_addr'], 'node');
		     }

		}

        	$this->autoRender = false;

      }

}

?>