<?php

/******************************************************************************
	WP Business Intelligence Lite
	Author: WP Business Intelligence
	Website: www.wpbusinessintelligence.com
	Contact: http://www.wpbusinessintelligence.com/contactus/

	This file is part of WP Business Intelligence Lite.

    WP Business Intelligence Lite is free software; you can redistribute it and/or modify
    it under the terms of the GNU General Public License as published by
    the Free Software Foundation; either version 2 of the License, or
    (at your option) any later version.

    WP Business Intelligence Lite is distributed in the hope that it will be useful,
    but WITHOUT ANY WARRANTY; without even the implied warranty of
    MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
    GNU General Public License for more details.

    You should have received a copy of the GNU General Public License
    along with WP Business Intelligence Lite; if not, write to the Free Software
    Foundation, Inc., 51 Franklin St, Fifth Floor, Boston, MA  02110-1301  USA
	
	You can find a copy of the GPL licence here:
	http://www.gnu.org/licenses/gpl-3.0.html
******************************************************************************/


/***********************/
/***  SET TEMPLATE   ***/
/***********************/
$template_site->set_filenames(array(
	'header' => $wpbi_url['tpl']['root-path'].$wpbi_url['tpl']['header'],
	'footer' => $wpbi_url['tpl']['root-path'].$wpbi_url['tpl']['footer']
	)
);

$template_site->assign_vars(array(
'PG_TITLE' => $wpbi_dialog['page']['wpbi']['title'],
'PG_DESCRIPTION' => $wpbi_dialog['page']['wpbi']['description'].'<hr>'.$wpbi_dialog['disclaimer']['license']['gpl']
)
);
$pg_output = '';
ob_start();
$template_site->pparse('header');
$template_site->pparse('footer');
$pg_output = ob_get_contents();
ob_end_clean();
echo $pg_output;


?>