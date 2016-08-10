<?php
/**
 * Plugin Name: CSS3 Transitions
 * Plugin URI: http://celloexpressions.com/plugins/css3-transitions
 * Description: Automatically adds CSS3 transitions to your website/blog and the WordPress admin. Links, etc. get animated transitions between their normal and hover states.
 * Version: 1.3
 * Author: Nick Halsey
 * Author URI: http://celloexpressions.com/
 * Tags: css3, transitions, eye candy, ui, ux, effects, smooth, automatic, auto, animate, animations
 * License: GPL

=====================================================================================
Copyright (C) 2013 Nick Halsey

This program is free software; you can redistribute it and/or
modify it under the terms of the GNU General Public License
as published by the Free Software Foundation; either version 2
of the License, or (at your option) any later version.

This program is distributed in the hope that it will be useful,
but WITHOUT ANY WARRANTY; without even the implied warranty of
MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
GNU General Public License for more details.

You should have received a copy of the GNU General Public License
along with WordPress; if not, write to the Free Software
Foundation, Inc., 51 Franklin Street, Fifth Floor, Boston, MA  02110-1301, USA.
=====================================================================================
*/

add_action('wp_head', 'cxnh_css3_transitions');
add_action('admin_head', 'cxnh_css3_transitions');

function cxnh_css3_transitions(){ ?>
	<style type="text/css">
	/* From CSS3 Transitions Plugin.
		target several selectors which are most likely to have 
		hover states defined in the theme
	*/
		a, li {
			/* Unfortunately, it doesn't seem posible to do exclude background-position from all, so just don't use any sprites */
			transition: all .18s cubic-bezier(0.64,0.20,0.02,0.35);
			-webkit-transition: all .18s cubic-bezier(0.64,0.20,0.02,0.35);
		}
		img {
			transition: all .3s cubic-bezier(0.64,0.20,0.02,0.35);
			-webkit-transition: all .3s cubic-bezier(0.64,0.20,0.02,0.35);
		}
		input, textarea, button, label, option, select, .button, .hndle {
			transition: all .25s cubic-bezier(0.64,0.20,0.02,0.35);
			-webkit-transition: all .25s cubic-bezier(0.64,0.20,0.02,0.35);
		}
		
		/* transitions mess all of these up in the WordPress Core */
		#wpwrap #nav-menus-frame #menu-management-liquid li, 
		.wp-picker-holder a {
			transition: none;
			-webkit-transition: none;
		}
	</style>
<?php }
// Yup, that's it!