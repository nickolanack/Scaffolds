<?php 


/**
 * Article scaffold (html.article) renders an html5 article using microdata 
 * this scaffold accepts varios microdata schema arguments to create Search Engine Optimized content. 
 * ('html.article', array("title"=>"...", "text"=>["..."], "author"=>"...", ... )
 */




$config=array_merge(array(
		'title'=>'An Example Article $params["title"]',
		'heading'=>1,
		'text'=>array(
				'The first paragraph if $params["text"] is an array otherwise the only paragraph is $params["text"] is a string',
				'The second paragraph if $params["text"] is an array.'
		),
		'footer'=>false,
		'timestamps'=>array(),
		'author'=>array('Created By'=>'Nick Blackwell'),
		'authorLink'=>false,
		'link'=>false,
		'linkTitle'=>'view the full article',
		'images'=>false,
		'schema'=>array()
	),$params);

	$config['schema']=array_merge(array(
			'article'=>'itemscope itemtype="http://schema.org/Thing"',
			'h'=>'itemprop="name"',
			'p0'=>'itemprop="description"',
			'author'=>'itemscope itemtype="http://schema.org/Person"',
			'link'=>'itemprop="url"',
			'authorName'=>'itemprop="name"',
			'imageLink'=>'itemscope itemtype="http://schema.org/Photograph"',
			'image'=>'itemprop="image"'
			),$config['schema']);

	$h1='h'.$config['heading'];

	
	$schema=function($name)use(&$config){
		if(key_exists('schema', $config)&&key_exists($name, $config['schema'])){
			echo ' '.$config['schema'][$name].' ';
		}
	}
	
?><article<?php $schema('article');?> title="<?php echo htmlspecialchars($config['title']);?>">
  <header>
    <<?php echo $h1; $schema('h');?>><?php echo $config['title'];?></<?php echo $h1; ?>>
    <?php 
    foreach($config['timestamps'] as $label=>$datetime){
		$datetimeText=$datetime;
		if(is_array($datetimeText)){
			$datatimeText=array_values($datetimeText);
			$datetime=$datetimeText[0];
			$datetimeText=array_pop($datetimeText);
		}
    	?>
    <time datetime="<?php echo $datetime; ?>"><label><?php echo $label?> </label><?php echo $datetimeText;?></time>
    	<?php 	
    }
    $authors=false;
    if($config['author']){
		if(is_string($config['author'])){
			$authors=array('Author'=>$config['author']);
		}
		if(is_array($config['author'])&&count($config['author'])){
			$authors=$config['author'];
		}
	}

	if($authors){	
		foreach($authors as $authorLabel=>$author){
	?>
	
	<p class="author"<?php $schema('author');?>>
	<?php 
	
		if($config['authorLink']){
				?>
		<label><?php echo $authorLabel?> </label><a<?php $schema('authorName');?> href="<?php echo $config['authorLink'];?>"><?php 
		
		echo $author;?> </a>
			<?php 
		}else{
		?>
		<label><?php echo $authorLabel?> </label><span<?php $schema('authorName');?>><?php echo $author;?> </span>
		<?php
		}
		?>
    </p>
	<?php 
	}
	}else{
		?>
	<!-- $params['author'] and possibly $params['authorLink'] -->
		<?php 
	}
    ?>
   
  </header>
  <?php 
 	 $images=array();
  	if(is_string($config['images'])){
  		$images=array($config['images']);
  	}
	if(is_array($config['images'])){
  		$images=$config['images'];
  	}
  	$iStr=array("One", "Two", "Three", "Four", "Five", "Six", "Seven", "Eight", "Nine", "Ten");
  	foreach($images as $i=>$image){
		
  		?>
  		<a <?php $schema('imageLink')?> href="<?php echo $image; ?>">
  		<img<?php $schema('image')?> src="<?php echo $image; ?>"  alt="Photo <?php echo $iStr[$i]." - ".htmlspecialchars($config['title']);?>" width="" height="" />
  		</a>
  		<?php 
  	}
  
  
  	$texts=array();
  	if(is_string($config['text'])){
  		$texts=array($config['text']);
  	}
  	
  	if($config['text'] instanceof Closure){
  		$texts=array($config['text']);
  	}
  	
  	if(is_array($config['text'])){
  		$texts=$config['text'];
  	}
  	?>
  	 <div>
  	<?php 
  	if(count($texts)){
  		$i=0;
	  	foreach($texts as $p){


		$t_start='p';
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
  	<!-- $params['text'] //string or array of strings -->
  		<?php 
  	}
  	?>
  	<?php 
	if($config['link']){
  		?>
  		<a<?php $schema('link')?> href="<?php echo $config['link']; ?>"><?php echo $config['linkTitle'];?></a>
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
 

 
</article>
