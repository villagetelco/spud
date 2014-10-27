<?php                                                                                                                 
/****************************************************************************                                         
 * edit.ctp    - Edit Limits
 * version     - 1.0                                                                     
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
                                                                              
     echo $html->addCrumb('Limits', '/limits/edit');   

     echo "<h1>".__("Limits",true)."</h1>";

     echo $this->Html->div('info-message', __("The B.A.T.M.A.N metric is a numeric value beteween 1-99. A perfect link has the value 1.",true));

     echo $this->Session->flash();   


     if ($messages = $session->read('Message.multiFlash')) {
           foreach($messages as $k=>$v) $session->flash('multiFlash.'.$k);
     }


     echo $form->create('Limit', array('type' => 'post', 'action' => 'edit','enctype' => 'multipart/form-data') );
     $labels = array('min'=>__('Poor',true),'med' => __('Good',true), 'max' =>__('Excellent',true));

       foreach($this->data as $key => $limit){

           echo $form->hidden('Limit.'.$key.'.id', array('value' => $limit['Limit']['id']));  
           echo $form->hidden('Limit.'.$key.'.name', array('value' => $limit['Limit']['name']));  
           
            if($limit['Limit']['name']=='max'){ 
                $min = '&#8805;1';

            } else {
                $min = $form->input('Limit.'.$key.'.min',  array('type' => 'text', 'label'=>'&#8805; ','size' => 3, 'value' => $limit['Limit']['min']));


            }
            
       $row[] = array($labels[$limit['Limit']['name']],
                    $min,
                    $form->input('Limit.'.$key.'.color',array('type' => 'text', 'label'=>'# ',  'size' => 6, 'value' => $limit['Limit']['color']))

                    );

                          
       }


     echo "<table cellspacing = 0 class='stand-alone'>";
     echo $html->tableHeaders(array(__('Link quality',true),__('B.A.T.M.A.N metric',true), __('Color [RGB]',true)));                                                       
     echo $html->tableCells($row, array('class'=> 'stand-alone'), array('class' => 'stand-alone'));
     echo "</table>";   
     echo $form->end(__('Save',true));                       


?>