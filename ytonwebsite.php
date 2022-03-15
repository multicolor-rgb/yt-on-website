<?php

# get correct id for plugin
$thisfile=basename(__FILE__, ".php");
 
# register plugin
register_plugin(
	$thisfile, //Plugin id
	'YT on website', 	//Plugin name
	'1.0', 		//Plugin version
	'Mateusz Skrzypczak (multicolor)',  //Plugin author
	'https://multicolor.stargar.pl', //author website
	'Yt on shortcode', //Plugin description
	'pages', //page type - on which admin tab to display
	'ytplayersettings'  //main function (administration)
);


# menu
add_action( 'pages-sidebar', 'createSideMenu', array( $thisfile, 'YT on website settings' ) );


# activate filter 
add_action('theme-footer','yt'); 
add_action('theme-header','ytstyle'); 
# functions


function ytstyle(){
	
	$folder        = GSDATAOTHERPATH . '/ytplayersettings/';
$widthyt      = $folder . 'width.txt';
$heightyt     = $folder . 'height.txt';

	echo'
	
	<style>
	
	.ytplayer{
		width:'.file_get_contents($widthyt).';
		height:'.file_get_contents($heightyt).';
	}
	
	</style>
	
	
	';
	
}


	
function yt(){
echo <<< END

<script>
 function doitman(){
	 for (let i=0; i<100; i++){
document.body.innerHTML =  document.body.innerHTML.replace('{% ','<div class="ytdiv">').replace(' %}','</div>');; 
 }
 
 document.querySelectorAll('.ytdiv').forEach(
	(i)=>{
		let ytDivContent = i.innerHTML;
	i.innerHTML = '<iframe class="ytplayer" src="https://www.youtube.com/embed/'+ytDivContent+'" frameborder="0" allow="accelerometer; autoplay; encrypted-media; gyroscope; picture-in-picture" allowfullscreen></iframe>'
	
	}
 );
 
 };
 
 doitman();

 </script>

END;
}





function ytplayersettings() {
	// Set up the data
$widthcontent = $_POST['widthytplayer'];
$heightcontent = $_POST['heightytplayer'];

// Set up the folder name and its permissions
// Note the constant GSDATAOTHERPATH, which points to /path/to/getsimple/data/other/
$folder        = GSDATAOTHERPATH . '/ytplayersettings/';
$widthyt      = $folder . 'width.txt';
$heightyt     = $folder . 'height.txt';
$chmod_mode    = 0755;
$folder_exists = file_exists($folder) || mkdir($folder, $chmod_mode);
 
	
echo '
<h3>YT Player Settings</h3>

<h5 class="whatnow">Your settings Width:'.file_get_contents($widthyt).' height:'.file_get_contents($heightyt).'</h5>
<p>How to use this plugin?</p>
<b>Full url your movie:</b><br>
https://www.youtube.com/watch?v=<span style="color:red">rr0gvSS1OzE</span>
<br>
<br>
<b>Id for place on your content page  with special {% shortcode %}</b><br>
<br>
{% <span style="color:red">rr0gvSS1OzE</span> %}
<br><br>
 <form action="" method="POST">
 Width all player px or %:
 <input type="text" name="widthytplayer" class="widthytplayer" style="width:100%;padding:5px;margin:10px 0;"><br>
 Height all player px or %: <br>
 <input type="text" name="heightytplayer" class="heightytplayer"  style="width:100%;padding:5px;margin:10px 0;"><br>
  <input type="submit" style="background:#000;padding:10px;border:solid 1px #000;padding:10px 15px;color:#fff;" value="save">
  
</form> 



';






// Save the file (assuming that the folder indeed exists)
if ($folder_exists) {
file_put_contents($widthyt, $widthcontent);
file_put_contents($heightyt, $heightcontent);


};
	
	
}
?>