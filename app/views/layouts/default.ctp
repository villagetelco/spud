<?php
/****************************************************************************
 * default.ctp	- Default Solanum layout
 * version 	- 1.0
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
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<title><?php echo $title_for_layout?></title>

    <?php echo $html->charset('UTF-8'); ?>

    <?=$html->css('style');?>	     		<!-- Freedom Fone -->
    <?=$html->css('flash_messages');?>	     	<!-- Flash messages -->
    <?=$html->css('vimeo');?>	     		<!-- Main menu -->
    <?=$html->css('modalbox');?>	        <!-- Modalbox cluetip -->
    <?=$html->meta('icon');?>

    <?=$html->meta('keywords','Village Telco, Mesh Potato, GoogleMaps, Low cost GSM telephony, A2Billing, B.A.T.M.A.N, mesh network, mesh, wireless, social enterprise');?>

    <?php echo $javascript->link('prototype');?>
    <?php echo $javascript->link('scriptaculous.js?load=builder,effects');?>
    <?php echo $javascript->link('modalbox');?>
    <?php echo $javascript->link('cakemodalbox');?>
 
</head>

<body>
<div id="wrapper">
	 <?php echo $html->image('logo/vt_logo.png'); ?>
	 <div class="header"></div>
	 <div id="top_nav"><?php echo $this->element('menu'); ?></div>		<!-- horizonal menu -->
        <?php echo $html->div('breadcrumb', $html->getCrumbs(' > ',__('Home',true))); ?>
        	 <div id="content_wrap">


		<div id="main_content">
    		<?php 
                echo $content_for_layout; ?>  
		</div>								<!--main_content end-->
	 </div>									<!--content_wrap end-->
	 
	 <div class="footer"><?php echo VERSION_NAME." ".VERSION; ?>
         <?php echo "( Memory: ".round(memory_get_peak_usage()/1000000).' MB)'; ?>         
         </div>
</div>										<!--wrapper end-->
</body>
</html>
