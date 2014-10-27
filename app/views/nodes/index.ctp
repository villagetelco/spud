<?php                                                                                                                 
/****************************************************************************                                         
 * index.ctp  - Display all nodes
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
     echo $this->Session->flash();   

     echo "<h1>".__('Clients',true)."</h1>";
     echo $html->div('info-message',__('This page shows an overview of all clients added to SPUD.',true));
     echo $html->div('info-message',__('To <b>view</b> or <b>edit</b> client information, please click on the corresponding action icon.',true));

    if($nodes){


     foreach ($nodes as $key => $node){

        $no_links = false;
        $actions = '<a href="/spud/nodes/details/'.$node['Node']['id'].'" title="Client details" onclick="Modalbox.show(this.href, {title: this.title, width: 950}); return false;"><img src="/spud/img/icons/view.png"/></a>&nbsp;';

        $actions .= $this->Html->image("icons/edit.png", array("alt" => __("Edit client",true),"title" => __("Edit client",true), "url" => array("controller" => "nodes", "action" => "edit", $node['Node']['id'])))."&nbsp;";

     $actions .= $this->Html->image("icons/delete.png", array("alt" => __("Delete client",true),"title" => __("Delete client",true), "url" => array("controller" => "nodes", "action" => "delete", $node['Node']['id']), 'onClick' => "return confirm('".__('Are you sure you wish to delete this client?',true)."');"));

   
        $row[$key][] = $actions; 
	$row[$key][] = $node['Node']['name'];
        $row[$key][] = $node['Node']['surname'];
        $row[$key][] = $node['Node']['address'];
        $row[$key][] = $node['Node']['ip_addr'];
        $row[$key][] = $node['Node']['lat'];
        $row[$key][] = $node['Node']['long'];
        $row[$key][] = ucfirst($node['Node']['type']);

        if(array_key_exists('Link', $node)){
           $no_links   = sizeof($node['Link']);
        } 
                     
        $row[$key][] = $no_links;
        $row[$key][] = $formatting->getLastSeen($node['Node']['last_seen']); 

     }
   

     echo $html->div('frameLeft');
     echo $html->div('paginator-right',$paginator->counter(array('format' => __("Clients:",true)." %start% ".__("-",true)." %end% ".__("of",true)." %count% ")));  
     echo $html->div('paginator-right', __("Entries per page ",true).$html->link('25','index/limit:25',null, null, false)." | ".$html->link('50','index/limit:50',null, null, false)." | ".$html->link('100','index/limit:100',null, null, false));

     echo "<table class='blue'>";
     echo $html->tableHeaders(array(
                        __("Actions",true),
                        $paginator->sort(__("Name",true), 'Node.name'),
                        $paginator->sort(__("Surname",true), 'Node.surname'),
                        $paginator->sort(__("Address",true), 'Node.address'),
                        $paginator->sort(__("IP address",true), 'Node.ip_addr'),
                        $paginator->sort(__("Latitude",true), 'Node.lat'),
                        $paginator->sort(__("Longitude",true), 'Node.long'),
                        $paginator->sort(__("Type",true), 'Node.type'),
                        __("No links",true),
                        $paginator->sort(__("Last seen",true), 'Node.last_seen'),
                                        ));
     echo $html->tableCells($row, array('class'=> 'blue'),array('class'=> 'blue'));
     echo "</table>";

   if($paginator->counter(array('format' => '%pages%'))>1){                                                           
           echo $html->div('paginator', $paginator->prev('«'.__('Previous',true), array( 'class' => 'PrevPg'), null, array('class' => 'PrevPg DisabledPgLk')).' '.$paginator->numbers().' '.$paginator->next(__('Next',true).'»',array('class' => 'NextPg'), null, array('class' => 'NextPg DisabledPgLk')));                               
    }



     echo "</div>";
     } else {

            echo $html->div('info-message', __('There are no clients in the system.',true));

     }

?>

