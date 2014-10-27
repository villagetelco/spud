<?php
/****************************************************************************
 * menu.ctp	- Main horizontal menu
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

<div>
<ul id='menu'>


<li>
<?php echo $html->link(__("Home",true),'/'); ?>
</li>

<li>
<?php echo $html->link(__("Add Client",true),'/nodes/add'); ?>
</li>


<li>
<?php echo $html->link(__("Import data",true),'/nodes/import'); ?>
</li>

<li>
<?php echo $html->link(__("Clients",true),'/nodes/'); ?>
</li>

<li>
<?php echo $html->link(__("Limits",true),'/limits/edit/'); ?>
</li>


<li>
<?php echo $html->link(__("Map",true),'/nodes/map'); ?>
</li>

<li>
<?php echo $html->link(__("Installation",true),'/install'); ?>
</li>



</ul>
</div>