<?php 


$config=array_merge(array(
		'header'=>null,
		'body'=>null,
		'buffered'=>true, 
		
		//the following optional params can be set by the header callback function 
		'title'=>false,
		'description'=>false,
		'keywords'=>false,
		'base'=>false,
		'icon'=>false,
		'generator'=>false
	),$params);

if(!($config['header']&&$config['header'] instanceof Closure)){
	throw new Exception('Expected $params[\'header\']=function(){} in '.__FILE__);
}


if(!($config['body']&&$config['body'] instanceof Closure)){
	throw new Exception('Expected $params[\'body\']=function(){} in '.__FILE__);
}


$body=function()use($config){
	
	$config['body']();
	
};

if($config['buffered']){
	ob_start();
	$body();
	$body=ob_get_contents();
	ob_end_clean();
}




?><!DOCTYPE HTML>
<html>
	<head>
		<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
		<?php
			$config['header']();
		
		if($config['title']){
			?><title><?php echo htmlspecialchars($config['title']);?></title>
			<?php 
		}

		if($config['description']){
			?><meta name="description" content="<?php echo htmlspecialchars($config['description']);?>" />
			<?php 
		}
		
		if($config['keywords']){
			?><meta name="keywords" content="<?php echo htmlspecialchars($config['keywords']);?>" />
			<?php
		}
		
		if($config['generator']){
			?><meta name="generator" content="<?php echo htmlspecialchars($config['generator']);?>" />
			<?php
		}
		
		if($config['icon']){
			?><link rel="icon" type="image/<?php echo end(explode('.', ($config['icon'])));?>" href="<?php echo $config['icon']?>"/>
			<?php
		}

		 if($config['base']){
			?><base href="<?php $config['base']; ?>" />
			<?php
		}?>
		
	</head>
	<body>
		<?php
			if($config['buffered']){
				echo $body;
			}else{
				$body();
			}
		?>
	</body>
</html><?php 
?>