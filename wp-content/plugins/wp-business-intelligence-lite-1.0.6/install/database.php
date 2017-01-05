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


//include_once('settings.php');

$qy_table_databases = '
CREATE TABLE IF NOT EXISTS `'.$wpbi_sql['tname']['databases'].'` (
  `DB_ID` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `DB_NAME` varchar(256) NOT NULL,
  `DB_HOST` varchar(256) NOT NULL,
  `DB_USER` varchar(256) NOT NULL,
  `DB_PASS` varchar(2048) NOT NULL,
  PRIMARY KEY (`DB_ID`)
) -- ENGINE = INNODB DEFAULT CHARACTER SET utf8 COLLATE utf8_bin
';

$qy_table_queries = '
CREATE TABLE IF NOT EXISTS `'.$wpbi_sql['tname']['queries'].'` (
  `QUERY_ID` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `DATABASE_ID` int(10) unsigned NOT NULL,
  `QUERY_NAME` varchar(256) NOT NULL,
  `QUERY_STATEMENT` text NOT NULL,
  PRIMARY KEY (`QUERY_ID`)
) -- ENGINE = INNODB DEFAULT CHARACTER SET utf8 COLLATE utf8_bin
';

$qy_table_views = '
CREATE TABLE IF NOT EXISTS `'.$wpbi_sql['tname']['tables'].'` (
`TABLE_ID` int(11) NOT NULL AUTO_INCREMENT,
  `QUERY_ID` int(11) NOT NULL,
  `NAME` varchar(64) NOT NULL,
  `TITLE` varchar(64) NOT NULL,
  `ROWS_PER_PG` int(11) NOT NULL,
  `STYLE_ID` varchar(64) NOT NULL,
  `HAS_HEADER` int(11) NOT NULL,
  `HAS_FOOTER` int(11) NOT NULL,
  `TABLE_KEY` varchar(32) NOT NULL,
  `ENCODE_HTML` int(11) NOT NULL,
  PRIMARY KEY (`TABLE_ID`),
  UNIQUE KEY `TABLE_KEY` (`TABLE_KEY`) 
) -- ENGINE = INNODB DEFAULT CHARACTER SET utf8 COLLATE utf8_bin
';

$qy_tb_cols = '
CREATE TABLE IF NOT EXISTS `'.$wpbi_sql['tname']['cols'].'` (
  `COL_ID` int(11) NOT NULL AUTO_INCREMENT,
  `TB_ID` int(11) NOT NULL,
  `COL_LABEL` varchar(64) NOT NULL,
  `IS_VISIBLE` int(11) NOT NULL,
  PRIMARY KEY (`COL_ID`),
  KEY `TB_ID` (`TB_ID`)
) -- ENGINE = INNODB DEFAULT CHARACTER SET utf8 COLLATE utf8_bin
';

$qy_chart_views = "
CREATE TABLE IF NOT EXISTS ".$wpbi_sql['tname']['charts']." (
CHART_ID int(11) NOT NULL AUTO_INCREMENT,
  QUERY_ID int(11) NOT NULL,
  CHART_KEY varchar(32) NOT NULL,
  CHART_NAME varchar(64) NOT NULL,
  CHART_TYPE int(2) NOT NULL,
  CHART_TITLE varchar(64) NOT NULL,
  CHART_TITLE_SIZE int(11) NOT NULL,
  CHART_TITLE_COLOR varchar(7) NOT NULL,
  CHART_BG_COLOR varchar(7) NOT NULL,
  CHART_WIDTH int(11) NOT NULL,
  CHART_WIDTH_PERCENT int(1) NOT NULL,
  CHART_HEIGHT int(11) NOT NULL,
  CHART_HEIGHT_PERCENT int(1) NOT NULL,
  CHART_X_COLOR varchar(7) NOT NULL,
  CHART_X_PRECISION int(11) NOT NULL,
  CHART_X_THICKNESS int(11) NOT NULL,
  CHART_X_GRID_COLOR varchar(7) NOT NULL,
  CHART_X_GRID_LINES int(11) NOT NULL,
  CHART_X_LABELS_COLOR varchar(7) NOT NULL,
  CHART_X_LABELS_SIZE int(11) NOT NULL,
  CHART_X_LABELS_ROTATION int(11) NOT NULL,
  CHART_X_LEGEND varchar(64) NOT NULL,
  CHART_X_LEGEND_COLOR varchar(7) NOT NULL,
  CHART_X_LEGEND_SIZE int(11) NOT NULL,
  CHART_Y_COLOR varchar(7) NOT NULL,
  CHART_Y_PRECISION int(11) NOT NULL,
  CHART_Y_THICKNESS int(11) NOT NULL,
  CHART_Y_GRID_COLOR varchar(7) NOT NULL,
  CHART_Y_GRID_LINES int(11) NOT NULL,
  CHART_Y_LABELS_COLOR varchar(7) NOT NULL,
  CHART_Y_LABELS_SIZE int(11) NOT NULL,
  CHART_Y_LABELS_ROTATION int(11) NOT NULL,
  CHART_Y_LEGEND varchar(64) NOT NULL,
  CHART_Y_LEGEND_COLOR varchar(7) NOT NULL,
  CHART_Y_LEGEND_SIZE int(11) NOT NULL,
  PRIMARY KEY (CHART_ID),
  UNIQUE KEY CHART_KEY (CHART_KEY)
) -- ENGINE = INNODB DEFAULT CHARACTER SET utf8 COLLATE utf8_bin
";

$qy_ch_cols = '
CREATE TABLE IF NOT EXISTS  `'.$wpbi_sql['tname']['chart-cols'].'` (
 `COL_ID` int(11) NOT NULL AUTO_INCREMENT,
  `CHART_ID` int(11) NOT NULL,
  `COL_LABEL` varchar(64) NOT NULL,
  `COL_COLOR` varchar(7) NOT NULL,
  `IS_LABEL` int(11) NOT NULL,
  `IS_VALUE` int(11) NOT NULL,
  `IS_TIME` int(11) NOT NULL,
  PRIMARY KEY (`COL_ID`)
) -- ENGINE = INNODB DEFAULT CHARACTER SET utf8 COLLATE utf8_bin
';

$qy_table_vars = '
CREATE TABLE  IF NOT EXISTS  `'.$wpbi_sql['tname']['vars'].'` (
`VAR_ID` INT NOT NULL AUTO_INCREMENT ,
`VAR_NAME` VARCHAR( 32 ) NOT NULL ,
`VAR_VALUE` VARCHAR( 256 ) NULL ,
PRIMARY KEY (  `VAR_ID` ),
UNIQUE (`VAR_NAME`)
)
';

$qy_fk = '
ALTER TABLE `'.$wpbi_sql['tname']['cols'].'` ADD CONSTRAINT `fk_tb_id` FOREIGN KEY `fk_tb_id` (`TB_ID`)
    REFERENCES `'.$wpbi_sql['tname']['tables'].'` (`TABLE_ID`)
    ON DELETE RESTRICT
    ON UPDATE RESTRICT
;
ALTER TABLE `'.$wpbi_sql['tname']['chart-cols'].'` ADD CONSTRAINT `fk_chart_id` FOREIGN KEY `fk_chart_id` (`CHART_ID`)
    REFERENCES `'.$wpbi_sql['tname']['charts'].'` (`CHART_ID`)
    ON DELETE RESTRICT
    ON UPDATE RESTRICT
;
ALTER TABLE `'.$wpbi_sql['tname']['charts'].'` ADD CONSTRAINT `fk_ch_query_id` FOREIGN KEY `fk_ch_query_id` (`QUERY_ID`)
    REFERENCES `'.$wpbi_sql['tname']['queries'].'` (`QUERY_ID`)
    ON DELETE CASCADE
    ON UPDATE CASCADE
;
ALTER TABLE `'.$wpbi_sql['tname']['tables'].'` ADD CONSTRAINT `fk_tb_query_id` FOREIGN KEY `fk_tb_query_id` (`QUERY_ID`)
    REFERENCES `'.$wpbi_sql['tname']['queries'].'` (`QUERY_ID`)
    ON DELETE CASCADE
    ON UPDATE CASCADE
;
ALTER TABLE `'.$wpbi_sql['tname']['queries'].'` ADD CONSTRAINT `fk_db_id` FOREIGN KEY `fk_db_id` (`DATABASE_ID`)
    REFERENCES `'.$wpbi_sql['tname']['databases'].'` (`DB_ID`)
    ON DELETE CASCADE
    ON UPDATE CASCADE
;
';

?>