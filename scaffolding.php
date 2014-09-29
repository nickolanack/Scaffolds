<?php

/**
 * Requires php 5
 * 
 * Scaffolds are a really quick and simple way to create reusable consitent content. Scaffolds are very loosly defined. 
 * generally scaffolds are files with some html structure that is filled with content and printed to the 
 * page. scaffolds can be called recursively 
 * 

 * 
 * @author Nick Blackwell
 * 
 */

class Scaffolding{

	
	/**
	 * an array of paths that are searched for files matching a dot notation file naming where '.' can 
	 * represent a directory seperator or an actual dot character it allows organization of files to 
	 * be developed progressively.
	 * @var array<string> search directories
	 */
	private $paths=array();
	
	/**
	 * keeps track of the current list of scaffolds called (depth)
	 * @var array<string> of recursively included files 
	 */
	private $_stack=array();
	
	
	
	public function Scaffolding(){
		$default=__DIR__.DS.'scaffolds';
		if(file_exists($default))$this->setPath($default);
		
	}
	
	/**
	 * @param string $name uses dot notation to search paths
	 * @param array $args parameters defined by the scaffold
	 * @param string $path an additional path to use along with the current list of paths
	 */
	public function build($name, $params, $path=null){
		
		if(!(is_null($path)||empty($path)))$this->setPath($path);
		
		$names=$this->_names($name);
		foreach($this->_paths() as $p){
			foreach($names as $file){
		
		
		
				if(file_exists($p.DS.$file)){
					array_push($this->_stack, $name);
						
					$scaffold_start_time=microtime(true);
					
					$closure=function($file, $name, $params)use($params, $name){
						return include $file;
					};
					
					$result = $closure($p.DS.$file, $name, $params);
					$scaffold_end_time=microtime(true);
					$scaffold_run_time_total=$scaffold_end_time-$scaffold_start_time;
						

					$this->_profile($p.DS.$file, $scaffold_run_time_total, $this->_stack);
					
					array_pop($this->_stack);
					$this->_remove($path); 
					return $result;
				}
		
			}
		}
		if(!file_exists(GEOLIVE::ScaffoldsDIR())){
			throw new Exception("Expected to find Scaffold file at:".GEOLIVE::ScaffoldsDIR().' for Scaffold: '.$name);
		}
		echo "invalid form: ".$name;
		$this->_remove($path);
			
	}
	
	public function setPath($path){
		
		if(is_array($path)){
			foreach($path as $p){
				$this->setPath($p);
			}
		}
		elseif(is_string($path)){
			$this->paths[]=$path;
		}else{
			throw new Exception('Invalide $path:('.gettype($path).') '.$path);
		}
		
		
		
		
	}

	/**
	 * @param string $path optional additional path, is searched first
	 * @return array<string>
	 */
	private function _paths(){
		return array_reverse($this->paths);
	}
	
	private function _names($name){
		
		$names=array();
		$parts=explode('.', $name);
		
		$i=0;
		for($i=0;$i<(count($parts));$i++){
			$j=0;
			$strPath='';
			for($j=0;$j<(count($parts)-1);$j++){
				if($j<(count($parts)-1-$i)){
					$strPath.=$parts[$j].DS;
				}else{
					$strPath.=$parts[$j].'.';
				}
		
			}
			$names[]=DS.$strPath.$parts[count($parts)-1].".php";
		}
		return $names;
		
	}
	
	private function _remove($path){
		
		if($this->paths[count($this->paths)-1]==$path){
			array_pop($this->paths);
		}
		
		if(is_array($path)){
			foreach(array_reverse($path) as $p){
				$this->_remove($p);
			}
		}
		
		
	}
	
	private function _profile($file, $time, $stack){
		file_put_contents($file.'.profile', date_format(date_create(),'Y-m-d H:i:s').' '.$time.' '.(implode('>', $stack))."\n", FILE_APPEND);
	}
	
}

if(!defined('DS')){
	define('DS', DIRECTORY_SEPARATOR); //I'm lazy
}

