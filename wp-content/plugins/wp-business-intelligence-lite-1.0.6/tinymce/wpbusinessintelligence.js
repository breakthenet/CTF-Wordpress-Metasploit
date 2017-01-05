
/***************************************************************************

	WP Business Intelligence
	Author: WP Business Intelligence
	Website: www.wpbusinessintelligence.com
	Contact: http://www.wpbusinessintelligence.com/contactus/

	This file is part of WP Business Intelligence.

    WP Business Intelligence is free software; you can redistribute it and/or modify
    it under the terms of the GNU General Public License as published by
    the Free Software Foundation; either version 2 of the License, or
    (at your option) any later version.

    WP Business Intelligence is distributed in the hope that it will be useful,
    but WITHOUT ANY WARRANTY; without even the implied warranty of
    MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
    GNU General Public License for more details.

    You should have received a copy of the GNU General Public License
    along with WP Business Intelligence; if not, write to the Free Software
    Foundation, Inc., 51 Franklin St, Fifth Floor, Boston, MA  02110-1301  USA
	
	You can find a copy of the GPL licence here:
	http://www.gnu.org/licenses/gpl-3.0.html
	
******************************************************************************/



// Add button to the editor
 
(function() {
 
 
tinymce.create('tinymce.plugins.wpbusinessintelligence', {
 
init : function(ed, url) {
 
 
ed.addButton('wpbusinessintelligence', {
 
title : 'WP Business Intelligence',
 
image : null,
 
onclick : function() {
 
ed.selection.setContent('[wpbusinessintelligence]' + ed.selection.getContent() + '[/wpbusinessintelligence]');
 
}
 
});
 
},
 
createControl : function(n, cm) {
 
return null;
 
},
 
});
 
 
tinymce.PluginManager.add('wpbusinessintelligence', tinymce.plugins.wpbusinessintelligence);
 
})();