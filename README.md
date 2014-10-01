Scaffolds
=========

Scaffolds is a php library for creating content from a directory of structural php files usually containing boilerplate html. Scaffolds are resolved by name using dot notation, so that for example html5.article might be found in a folder named html5 and the file named article.php. the purpose of Scaffolds is to create reusable html or other code quickly allowing organization of the code to be progressively applied 

Simple Website with Scaffolds
=========

This example works at (media.geolive.ca/placemark-tool)  
I have included an additional scaffold folder svn which is not included in the source files of this project this project also 
uses Imagick. ( something similar to: yum install imagick, yum install php54w-pecl-imagick ) 

```php
include_once 'lib/scaffolds/scaffolding.php';

global $scaffold;
$scaffold=new Scaffolding();


function SVG($name, $params=array()){
	
	global $scaffold;
	return $scaffold->build('svg.'.$name, $params);
	
}

function HTML($name, $params=array()){

	global $scaffold;
	return $scaffold->build('html.'.$name, $params);

}


HTML('document', array(
		'buffered'=>false,
		'title'=>'Placemark Icon Generator | By Nick Blackwell',
		'description'=>'The placemark generator tool was created by Nick Blackwell. The tool allows you to generate custom placemark icons by adjusting styles and overlays',
		'generator'=>'Nick Blackwell | https://people.ok.ubc.ca/nblackwe',
		'header'=>function(){
			?>
			<style>
			body, pre, h1{
				font-family: sans-serif;
				font-weight: 100;
			}
			</style>
			<?php 		
		},
		'body'=>function(){
			
			HTML('article', array(
				'author'=>'Nick Blackwell',
				'authorLink'=>'https://people.ok.ubc.ca/nblackwe',
				'title'=>'Placemark Icon Generator',
				'text'=>array(
					function(){
						?>
							Instructions: ... here ...
							
						<?php 
					},
					function(){

						$get_color=function($name, $default="123456"){
							if(key_exists($name, $_GET)){
								$c=$_GET[$name];
								 preg_replace('/[^0-9A-F]/', '', strtoupper($c));
								if(strlen($c)!=6)return $default;
								return ''.$c;
							}
							return $default;
						};
						$base='placemark';
						$files=array();
						foreach(array(256, 128, 64, 32, 24, 16) as $w){
							
							
							$fill=$get_color('fill','725f1e');
							$stroke=$get_color('stroke','a73e10');
							
							$file=$base.'-'.$fill.'-'.$stroke.'-'.$w.'.png';
							$files[]=$file;
							$zip=$base.'-'.$fill.'-'.$stroke.'.zip';
							
							if(!file_exists($file)){
							
								ob_start();
								SVG($base, array(
									'fill'=>'#'.$fill,
									'stroke'=>'#'.$stroke,
									'width'=>$w
								));
								$svg=ob_get_contents();
								ob_end_clean();
								$im=new Imagick();
								$im->readImageBlob('<?xml version="1.0" encoding="UTF-8"?>
<!DOCTYPE svg PUBLIC "-//W3C//DTD SVG 1.1//EN"
  "http://www.w3.org/Graphics/SVG/1.1/DTD/svg11.dtd">
<!-- Created by Nick Blackwell (https://people.ok.ubc.ca/nblackwe/) -->'.$svg);
							
								/*png settings*/
								$im->setImageFormat("PNG32");
								
								
								
								$im->writeImage($file);
								$im->clear();
								$im->destroy();
							}
							
							?><img src="<?php echo $file;?>" /><?php 
							

						}
						$zipFile=$base.'-'.$fill.'-'.$stroke.'.zip';
						if(!file_exists($zipFile)){
							$zip=new ZipArchive();
							if ($zip->open($zipFile, ZipArchive::CREATE)!==TRUE) {
								die('Failed to create file: '.$zipFile);
							}
							foreach($files as $f){
								$zip->addFile($f);
							}
							$zip->close();
	
						}
						
						?><a href="<?php echo $zipFile;?>">download</a><?php 
						
					},
					function(){
			
						HTML('license.mit');						

					}
					
				),
				'footer'=>'copyright Nick Blackwell '.date('Y')
			));
				
		}
));
