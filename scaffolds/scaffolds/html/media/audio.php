<?php
	$config=array_merge(array(
		'controls'=>true,
		'src'=>false
	),$params);
	
	
	if($config['src']===false&&key_exists(0, $config)&&is_string($config[0])){
		$config['src']=array();
		$i=0;
		while(key_exists($i, $config)&&is_string($cofing[$i])){
			$config['src'][]=$config[$i++];
		}
	}

	if(empty($config['src']))throw new Exception('Expected $params[\'src\'] to be an array or string containing at least one value url');
	if(is_string($config['src'])){
		$config['src']=array($config['src']);
	}
	
	if(!is_array($config['src'])){
		throw new Exception('Expected $params[\'src\'] to be an array or string containing at least one value url: '.gettype($config['src']));
	}else{
		//TODO: sort preffered types 	
	}
	
?>
<audio <?php if($config['controls']){ ?>controls="controls"<?php } ?>>
	<?php foreach($config['src'] as $src){
		
		?><source src="<?php echo $src;?>" type="audio/<?php echo substr($src, strrpos($scr, '.')+1);?>">
		<?php 
		
	}?>
</audio>	