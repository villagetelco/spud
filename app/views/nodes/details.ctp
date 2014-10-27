<?php                                                                                                                 
/****************************************************************************                                         
 * details.ctp  - Display node details
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

     echo $html->addCrumb('Clients', '/nodes');                                                                 
     echo $html->addCrumb('View', '/nodes/details');


        $links = array();

        if(array_key_exists('Link', $details)){

            $links = $details['Link'];

        }

        //*** Personal data ***//
        $table1[] = array(array($html->div('table_sub_header',__('Client data',true)),array('colspan'=> 2)));
        $table1[] = array(__('Name',true),$details['Node']['name']);
        $table1[] = array(__('Surame',true),$details['Node']['surname']);
        $table1[] = array(__('Address',true),$details['Node']['address']);
        $table1[] = array(__('Email',true),$details['Node']['email']);
        $table1[] = array(__('Mobile',true),$details['Node']['mobile']);
        $table1[] = array(__('Landline',true),$details['Node']['landline']);
        $table1[] = array(__('In system since',true),$details['Node']['created']);
        $table1[] = array(__('Last modified',true),$details['Node']['modified']);

        //*** Technical data ***//
        $table2[] = array(array($html->div('table_sub_header',__('Technical data',true)),array('colspan'=> 2)));
        $table2[] = array(__('IP address',true),$details['Node']['ip_addr']);   
        $table2[] = array(__('Latitude',true),$details['Node']['lat']);
        $table2[] = array(__('Longitude',true),$details['Node']['long']);
        $table2[] = array(__('MP firmware',true),$details['Node']['firmware']);
        $table2[] = array(__('Active links',true),sizeof($links));
        $table2[] = array(__('Type',true),$details['Node']['type']);
        $table2[] = array(__('Comment',true),$details['Node']['comment']);
        

        echo $html->div('frameLeft');
        echo "<table class='blue'>";
        echo $html->tableCells($table1,array('class'=> 'blue'),array('class'=> 'blue'));
        echo "</table></div>";

        echo $html->div('frameLeft');
        echo "<table class='blue' width='220px'>";
        echo $html->tableCells($table2,array('class'=> 'blue'),array('class'=> 'blue'));
        echo "</table></div>";

        echo $html->div('frameLeft');
        echo $html->div('table_sub_header',__('Active Links',true));


        //*** Links ***//
        if(sizeof($links)){

	echo $this->Html->div('info-message',__('Last updated',true).': '.$links[0]['modified']);
	echo $this->Html->div('information',__('- OUT represents the metric from the Client to the Neighbour.',true),array('style' =>'width:350px;'));
	echo $this->Html->div('information',__('- IN represents the metric from the Neighbour to the Client.',true),array('style' =>'width:350px;'));
	echo $this->Html->div('information',__('- Click on the Neighbour\'s IP address, so view its Client Details.',true),array('style' =>'width:350px;'));


        $min   = $limits[0];
        $max   = $limits[1];
        $color = $limits[2];

           foreach($links as $key => $link){

                  if($link['label'] < $min) { $color_in = $color['max'];} elseif($link['label']< $max) { $color_in = $color['med'];} else { $color_in = $color['min'];}
                  if($link['label_reverse']< $min) { $color_out = $color['max'];} elseif($link['label_reverse']< $max) { $color_out = $color['med'];} else { $color_out = $color['min'];}

                  $in  = $html->para(false,$link['label'], array('style' => 'color:#'.$color_in.';'));
                  $out = $html->para(false,$link['label_reverse'], array('style' => 'color:#'.$color_out.';'));
		  $distance = $this->Number->precision($link['distance'],2)." km";

                  $user_link  = $html->link($link['neighbour'], array('controller' => 'nodes', 'action' => 'details', $link['neighbour_id'] ), array('title' => 'Neighbour details', 'onclick' => "Modalbox.show(this.href, {title: this.title, width: 950}); return false;"),null,false,false);
                  $table3[] = array($in, $out, $distance, $user_link);   
           }

        echo "<table class='blue'>";
        echo $html->tableHeaders(array( __("OUT",true),__("IN",true),__("Distance",true),__("Neighbour",true) ));
        echo $html->tableCells($table3,array('class'=> 'blue'),array('class'=> 'blue'));
        echo "</table>";


        } else {

        echo $html->div('info-message',__("This client has no active links",true));

        }


        echo "</div>";


?>

