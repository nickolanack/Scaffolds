<?php 


/**
 * Article scaffold (html.article) renders an html5 article using microdata 
 * this scaffold accepts varios microdata schema arguments to create Search Engine Optimized content. 
 * ('html.article', array("title"=>"...", "content"=>["..."], "author"=>"...", ... )
 */




$config=array_merge(array(
		'title'=>'An Example Section $params["title"]',
		'heading'=>1,
		'content'=>array(
				'The first content item if $params["content"] is an array otherwise the only paragraph is $params["content"] is a string',
				'The second content item if $params["content"] is an array.'
		),
		'footer'=>false,
		
		'schema'=>array(),
		'classnames'=>array()
		
	),$params);

	$config['schema']=array_merge(array(
			'h'=>'itemprop="name"',
			'span0'=>'itemprop="description"',
			),$config['schema']);
	
	$config['classnames']=array_merge(array(
			'section'=>'main',
	),$config['classnames']);
	

	$h1='h'.$config['heading'];

	
	$schema=function($name)use(&$config){
		if(key_exists('schema', $config)&&key_exists($name, $config['schema'])){
			echo ' '.$config['schema'][$name].' ';
		}
	};
	
	$classnames=function($name, $fmt='class="%"')use(&$config){
		
		if(is_array($name)){
			$names=$name;
			$name='';
			array_walk($names, function($name)use(&$n, $classnames){
				ob_start();
				$classnames($n, '%');
				$name.=' '.ob_get_contents();
				ob_end_clean();
			});
			echo ' '.str_replace('%', trim($name), $fmt).' ';
		}else{
			if(key_exists('classnames', $config)&&key_exists($name, $config['classnames'])){
				echo ' '.str_replace('%', $config['classnames'][$name], $fmt).' ';
			}
		}
		
		
		
	};
	
?><section<?php $schema('section');?><?php $classnames('section');?> title="<?php echo htmlspecialchars($config['title']);?>">
  <header>
    <<?php echo $h1; $schema('h');?>><?php echo $config['title'];?></<?php echo $h1; ?>>
  	<!-- add optional content to header -->
  </header>
  <?php   
  	$texts=array();
  	if(is_string($config['content'])){
  		$texts=array($config['content']);
  	}
  	
  	if(is_array($config['content'])){
  		$texts=$config['content'];
  	}
  	?>
  	 <div>
  	<?php 
  	if(count($texts)){
  		$i=0;
	  	foreach($texts as $p){


		$t_start='span';
		$t_end=$t_start;
		if(is_array($p)&&count($p)==2&&is_string($p[0])){
			$t_start=$p[0];
			$t_end=explode(' ',trim($t_start));
			$t_end=$t_end[0];
			$p=$p[1];
		}
		

		?>	  	
		<<?php echo $t_start.' '; $schema($t_end.$i)?>><?php 
			if($p instanceof Closure){
			$p();
		}else{
			echo $p;
		}
			
		?></<?php echo $t_end;?>>
		<?php 
		$i++;
	  	}
	  	
  	}else{
  		?>
  	<!-- $params['content'] //string or array of strings -->
  		<?php 
  	}
  	?> 	
  	</div>
  	<?php 
	if($config['footer']){
  		?>
  	<footer>
    	<p><?php 
    	if($config['footer'] instanceof Closure){
    		$config['footer']();
    	}else{
    		echo $config['footer']; 
    	}
    	
    	?></p>
  	</footer>
	  	<?php 
  	}else{
  		?>
  	<!-- $params['footer'] //string -->
  		<?php 
  	}
  ?>
 

 
</section>
