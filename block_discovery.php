<?php
// This file is part of Moodle - http://moodle.org/
//
// Moodle is free software: you can redistribute it and/or modify
// it under the terms of the GNU General Public License as published by
// the Free Software Foundation, either version 3 of the License, or
// (at your option) any later version.
//
// Moodle is distributed in the hope that it will be useful,
// but WITHOUT ANY WARRANTY; without even the implied warranty of
// MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
// GNU General Public License for more details.
//
// You should have received a copy of the GNU General Public License
// along with Moodle.  If not, see <http://www.gnu.org/licenses/>.

/**
 * Version details
 *
 * @package    block_admin_bookmarks
 * @copyright  1999 onwards Martin Dougiamas (http://dougiamas.com)
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

defined('MOODLE_INTERNAL') || die();

class block_discovery extends block_base {
    public function init() {
        $this->title = get_string('blocktitle', 'block_discovery');
    }

    public function applicable_formats() {
        return array('all' => true);
    }

    public function instance_allow_multiple() {
        return false;
    }

    function has_config() {
        return true;
    }

    public function hide_header() {
        return true;
    }

    public function get_content() {
        if ($this->content !== null) {
            return $this->content;
        }

        global $COURSE, $DB, $PAGE;

        $this->content =  new stdClass;
        $this->content->text = '';

        $this->content->header = get_string('blocktitle', 'block_discovery');

        // Search box section: Code extracted direct from Discovery.
        $this->content->text .= '<div class="row glossary-search">';
        $this->content->text .= '<div class="col-12 pt-3 pb-3">';
        $this->content->text .= '<div id="discovery-search-box" style="margin: 1em 0px 2em;">';
        $this->content->text .= '<link href="https://stackpath.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css" rel="stylesheet" integrity="sha384-wvfXpqpZZVQGK6TAh5PVlGOfQNHSoD2xbE+QkPxCAFlNEevoEH3Sl0sibVcOQVnN" crossorigin="anonymous">';
        $this->content->text .= '<style type="text/css">';
        $this->content->text .= '#discovery-search-box,#discovery-search-box *{box-sizing:border-box!important;margin:0;padding:0;text-align:left}';
        $this->content->text .= '#discovery-search-box .material-tab{display:inline-block;user-select:none;cursor:pointer;background-color:#545454;color:#fff;min-height:2em;min-width:1.5rem;padding:.5em;box-sizing:border-box;border-radius:.25em .25em 0 0;margin-right:.4em;z-index:2}';
        $this->content->text .= '#discovery-search-form{position:"relative";width:auto;padding:1.25em 2em 2em;background-color:#f2f2f2!important;color:#333!important;z-index:1;line-height:initial}';
        $this->content->text .= '#discovery-search-box .material-tab.active-tab{background-color:#f2f2f2!important;color:#333!important}';
        $this->content->text .= '#discovery-index-container{position:relative;height:3em;background-color:white;color:black}';
        $this->content->text .= '#discovery-index-container:after{content:"\f078";display:block;font-family:"FontAwesome",sans-serif;position:absolute;top:0;right:.5em;line-height:3em;z-index:5}';
        $this->content->text .= '#discovery-index-container #discovery-search-select{position:relative;z-index:10;height:100%;min-width:initial;font-size:1em;padding:0 2em 0 1em;background-color:transparent;border-top:1px solid #ccc;border-right:0;border-bottom:1px solid #ccc;border-left:1px solid #ccc;border-image:initial;border-radius:0;-webkit-appearance:none;-moz-appearance:none}';
        $this->content->text .= 'select::-ms-expand{display:none}';
        $this->content->text .= '</style>';
        $this->content->text .= '<div style="display: flex; font-size: 1.1em; box-sizing: border-box; text-align: center;"></div>';
        $this->content->text .= '<form id="discovery-search-form">';
        $this->content->text .= '<label for="discovery-search" style="display: inline-block; font-size: 1.3em; font-weight: normal; margin-bottom: 0.5em;">Search Library Discovery</label>';
        $this->content->text .= '<div style="display: flex; width: 100%;">';
        $this->content->text .= '<div style="display: flex; flex-grow: 1;">';
        $this->content->text .= '<input type="text" id="discovery-search" style="display: inline-block; width: 100%; height: 3em; font-size: 1em; padding: 0px 0.5em; margin-bottom: 0.5em; color: black; background-color: white; border: 1px solid rgb(204, 204, 204); box-shadow: none;" required="" autocomplete="off">';
        $this->content->text .= '</div>';
        $this->content->text .= '<div>';
        $this->content->text .= '<input type="submit" value="Search" style="padding: 0.75em 1.5em; font-size: 1em; width: auto; height: 3em; min-width: 8em; color: rgb(255, 255, 255); background-color: rgb(34, 120, 181); margin: 0px 0px 0px 0.5em; border-radius: 0.25em; border: medium none; background-image: none; float: none; text-align: center;">';
        $this->content->text .= '</div>';
        $this->content->text .= '</div>';
        $this->content->text .= '<div style="display: flex; justify-content: space-between;">';
        $this->content->text .= '</div>';
        $this->content->text .= '</form>';
        $this->content->text .= '<script type="text/javascript">';
        $this->content->text .= "(function(){var d,w,tabList,h,form,input,urlBase,active,facets,v,r,rt,a,f,select,query;d=document;w=window;r=(function(){try{return w.blank!==w.top;}catch(e){return true;}})();rt=r?'_blank':'_self';a=d.getElementById('discovery-advanced-search');if(a)a.setAttribute('target',rt);tabList=d.querySelectorAll('#discovery-search-box span.material-tab');tabList=[].slice.call(tabList);h=function(e){if(e.keyCode&&e.keyCode!==13)return;tabList.forEach(function(it){it.className='material-tab';});this.className='material-tab active-tab';};tabList.forEach(function(tab){tab.addEventListener('click',h);tab.addEventListener('keydown',h);});form=d.getElementById('discovery-search-form');input=d.getElementById('discovery-search');select=d.getElementById('discovery-search-select');urlBase='https://glos.on.worldcat.org/external-search?queryString=#T#&clusterResults=on&stickyFacetsChecked=on#F#';form.addEventListener('submit',function(e){e.preventDefault();e.stopPropagation();f='';active=d.querySelector('.material-tab.active-tab');if(active){facets=JSON.parse(active.getAttribute('data-facets')||'[]');facets.forEach(function(facet){console.log(facet);if(facet.key&&facet.value&&facet.value!=='all'){f+='&'+facet.key+'='+facet.value;}})}query=input.value;if(select){var index=select.options[select.selectedIndex].value
                        if(index!=='kw')query=select.options[select.selectedIndex].value+':'+query;}w.open(urlBase.replace('#T#',encodeURIComponent(query)).replace('#F#',f),rt);});})()";
        $this->content->text .= '</script>';
        $this->content->text .= '</div>';
        $this->content->text .= '</div>';
        $this->content->text .= '</div>';

        $this->content->footer = '';

        return $this->content;
    }

}
?>
