<?php

/**
 * Optionally include this file, instead of including scaffold.php
 * it includes and initializes Scaffolds, and creates HTML() method
 */

include_once __DIR__.'/Scaffolding.php';

global $scaffold;
if(is_null($scaffold)){
	$scaffold=new Scaffolding();
}



/**
 * Helper method to load scaffolds meant to render html. Looks for scaffolds either prefixed with 'html.' or within the folder named 'html'
 * in the scaffolds folder.
 * 
 * @param string $name scaffold name, uses dot notation to resolve scaffold file path. 
 * @param array $params an associative array of arguments for the scaffold. Read the description for the specific scaffold for information on the 
 * parameters 
 */
function HTML($name, $params=array()){

	global $scaffold;
	return $scaffold->build('html.'.$name, $params);

}