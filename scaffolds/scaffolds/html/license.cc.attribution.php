<?php 
$config=array_merge(array(
		'holder'=>'Nick Blackwell | https://people.ok.ubc.ca/nblackwe',
		'title'=>'This Creative Work',
		'basedOnUrl'=>'https://people.ok.ubc.ca/nblackwe'
), $params);

?>
<a rel="license" href="http://creativecommons.org/licenses/by/4.0/"> <img
	alt="Creative Commons License" style="border-width: 0"
	src="https://i.creativecommons.org/l/by/4.0/80x15.png" />
</a>
<br />
<span xmlns:dct="http://purl.org/dc/terms/"
	href="http://purl.org/dc/dcmitype/StillImage" property="dct:title"
	rel="dct:type"> <?php echo $config['title'];?></span>
by
<a xmlns:cc="http://creativecommons.org/ns#"
	href="https://people.ok.ubc.ca/nblackwe" property="cc:attributionName"
	rel="cc:attributionURL"> <?php echo $config['holder'];?></a>
is licensed under a
<a rel="license" href="http://creativecommons.org/licenses/by/4.0/">Creative
	Commons Attribution 4.0 International License</a>
.
<br />
Based on a work at
<a xmlns:dct="http://purl.org/dc/terms/"
	href="<?php echo $config['basedOnUrl'];?>" rel="dct:source"><?php echo $config['basedOnUrl'];?></a>
.
