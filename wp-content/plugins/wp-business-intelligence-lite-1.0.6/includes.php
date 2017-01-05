<?php

/***************************************************************************


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

$filepath = realpath (dirname(__FILE__));

//Import here all the needed files
include_once($filepath.'/settings.php');
include_once($filepath.'/dialog/dialog.php');
include_once($filepath.'/install/database.php');
include_once($filepath.'/classes/backend/vo/vo_database.php');
include_once($filepath.'/classes/backend/vo/vo_query.php');
include_once($filepath.'/classes/backend/vo/vo_table.php');
include_once($filepath.'/classes/backend/vo/vo_tb_cols.php');
include_once($filepath.'/classes/backend/vo/vo_chart.php');
include_once($filepath.'/classes/backend/vo/vo_ch_cols.php');
include_once($filepath.'/classes/backend/vo/vo_vars.php');
include_once($filepath.'/classes/backend/dao/dao_database.php');
include_once($filepath.'/classes/backend/dao/dao_query.php');
include_once($filepath.'/classes/backend/dao/dao_table.php');
include_once($filepath.'/classes/backend/dao/dao_chart.php');
include_once($filepath.'/classes/backend/dao/dao_tb_cols.php');
include_once($filepath.'/classes/backend/dao/dao_ch_cols.php');
include($filepath.'/classes/backend/dao/dao_vars.php');
include_once($filepath.'/classes/backend/query.php');
include_once($filepath.'/classes/backend/styles.php');
include_once($filepath.'/classes/frontend/color.php');
include_once($filepath.'/classes/frontend/pagination.php');
include_once($filepath.'/classes/frontend/table.php');
include_once($filepath.'/resources/open-flash-chart/php-ofc-library/open-flash-chart.php');
include_once($filepath.'/classes/frontend/chart.php');
include_once($filepath.'/classes/frontend/table_form.php');
include_once($filepath.'/templates/template_site.php');
include_once($filepath.'/functions/functions.php');
include_once($filepath.'/resources/aes/wpbi_aes.php');

/*** nvd3 files ***/
include_once($filepath.'/resources/nvd3/nvd3_chart.php');
include_once($filepath.'/resources/nvd3/nvd3_dataseries.php');
include_once($filepath.'/resources/nvd3/nvd3_placeholder.php');
include_once($filepath.'/resources/nvd3/nvd3_utils.php');
include_once($filepath.'/resources/nvd3/nvd3_settings.php');
include_once($filepath.'/resources/nvd3/wrappers/nvd3_discreteBarChart.php');
include_once($filepath.'/resources/nvd3/wrappers/nvd3_lineChart.php');
include_once($filepath.'/resources/nvd3/wrappers/nvd3_pieChart.php');
?>