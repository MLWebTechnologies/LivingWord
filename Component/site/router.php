<?php
/* *************************************************************************************
Title          LivingWord Component for Joomla
Author         Mike Leeper
License        This program is free software: you can redistribute it and/or modify
               it under the terms of the GNU General Public License as published by
               the Free Software Foundation, either version 3 of the License, or
               (at your option) any later version.
               This program is distributed in the hope that it will be useful,
               but WITHOUT ANY WARRANTY; without even the implied warranty of
               MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
               GNU General Public License for more details.
               You should have received a copy of the GNU General Public License
               along with this program.  If not, see <http://www.gnu.org/licenses/>.
Copyright      2008-2014 - Mike Leeper (MLWebTechnologies) 
****************************************************************************************
No direct access*/
defined('_JEXEC') or die('Restricted access'); 
function LivingWordBuildRoute ( &$query )
{
  $segments = array();
  if (isset($query['task'])) {
    $segments[] = $query['task'];
    unset($query['task']);
  }
  if(isset($query['plan'])){
//    $segments[] = $query['plan'];
    unset($query['plan']);
  }
  if(isset($query['bibleversion'])){
//    $segments[] = $query['bibleversion'];
    unset($query['bibleversion']);
  }
  if(isset($query['Itemid']) && isset($query['alias'])){
    unset($query['Itemid']);
  }
  return $segments;
}
function LivingWordParseRoute($segments)
{
	$vars = array();
	$count = count($segments);
	if($count)
	{
		$count--;
		$segment = array_shift($segments);
		$vars['task'] = $segment;
	}
	if($count)
	{
		$count--;
		$segment = array_shift($segments);
		$vars['plan'] = $segment;
	}
	if($count)
	{
		$count--;
		$segment = array_shift($segments);
		$vars['bibleversion'] = $segment;
	}
//  $vars['Itemid'] = null;
	return $vars;
}
?>