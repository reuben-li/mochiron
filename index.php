<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml"
      xmlns:og="http://ogp.me/ns#"
      xmlns:fb="http://www.facebook.com/2008/fbml">
<link rel="icon" 
      type="image/png" 
      href="http://mochiron.net/favicon.png">
<head>
<meta name="viewport" content="user-scalable=yes, initial-scale=1.0, maximum-scale=2.0, width=device-width" /> 
<meta name="description" content="Mochiron.net is a site aimed at helping users find natural sounding phrases or sentences to aid in achieving natural written or spoken Japanese. It is also perfect for students looking for example sentences for grammar points.">
<meta name="google-site-verification" content="70vUskvH5XSFPhtrTntV0124HiCzMC-VJg4diVX9itg" />
<meta charset="UTF-8">
<!-- Start of StatCounter Code for Default Guide -->
<script type="text/javascript">
var sc_project=10027588; 
var sc_invisible=1; 
var sc_security="61a6ac63"; 
var scJsHost = (("https:" == document.location.protocol) ?
	"https://secure." : "http://www.");
document.write("<sc"+"ript type='text/javascript' src='" +
	scJsHost+
	"statcounter.com/counter/counter.js'></"+"script>");
</script>
	<noscript><div class="statcounter"><a title="shopify traffic
	stats" href="http://statcounter.com/shopify/"
	target="_blank"><img class="statcounter"
	src="http://c.statcounter.com/10027588/0/61a6ac63/1/"
	alt="shopify traffic stats"></a></div></noscript>
	<!-- End of StatCounter Code for Default Guide -->

<title>Mochiron - natural sounding phrases, not machine translations</title>
<meta property="og:title" content="Mochiron - natural sounding phrases, not machine translations">
<meta property="og:type" content="website">
<meta property="og:url" content="http://mochiron.net">
<meta property="og:image" content="http://mochiron.net/logo.png">
<meta property="og:site_name" content="Mochiron">
<meta property="og:description" content="Mochiron.net is a site aimed at helping users find natural sounding phrases or sentences to aid in achieving natural written or spoken Japanese.">



<meta charset="UTF-8">
<link rel="stylesheet" href="http://code.jquery.com/mobile/1.4.4/jquery.mobile-1.4.4.min.css" />
<script src="//code.jquery.com/jquery-1.11.0.min.js"></script>
<script src="//code.jquery.com/jquery-migrate-1.2.1.min.js"></script>
<!--<script src="http://code.jquery.com/mobile/1.4.4/jquery.mobile-1.4.4.min.js"></script>-->
<link rel="stylesheet" href="style.css" type="text/css">
<link rel="stylesheet" href="http://qtip2.com/v/2.2.0/basic/jquery.qtip.min.css" type="text/css">
<link rel="stylesheet" href="http://ajax.googleapis.com/ajax/libs/jqueryui/1.10.1/themes/base/minified/jquery-ui.min.css" type="text/css" /> 
<script type="text/javascript" src="http://code.jquery.com/jquery-1.9.1.min.js"></script>
<script type="text/javascript" src="http://code.jquery.com/ui/1.10.1/jquery-ui.min.js"></script>
<script src="http://qtip2.com/v/2.2.0/basic/jquery.qtip.min.js"></script>
<script src="js/jquery.endless-scroll.js"></script>
<script src="js/jquery.hoverIntent.js"></script>
<script>

function tog(v){return v?'addClass':'removeClass';} 

$(document).on('input', '.clearable', function() {
	    $(this)[tog(this.value)]('x');
}).on('mousemove', '.x', function(e) {
	    $(this)[tog(this.offsetWidth-18 < e.clientX-this.getBoundingClientRect().left)]('onX');   
}).on('click', '.onX', function(){
	    $(this).removeClass('x onX').val('').change();
});

$( document ).ready(function() {

$('.voice').on('mouseenter',function(){
		
	$(this).css('height','25px');
	
	});
$('.voice').on('mouseleave',function(){

	$(this).css('height','20px');
}
);

$('.voice').on('tap click',function(){
	var speech = $(this).prev().text().replace(/ /g,'');
	var id = $(this).attr('id');
	//console.log(id);
	var $this = $(this);
	//$.get("search.php",
	//{speech: speech, id: id});
	var wav = new Audio('speech/'+ id + '.wav');
	$.ajax({
	 type: "GET",
	 url: "search.php",
	 data: {speech:speech,id:id},
	 async: false,
	
	});
	wav.play();
});


$('#key').focus(function(){
		$('.logo').animate({ marginTop: '30px'}, 400);
	});
	$('span.jpn').each(function(){
		var selected = $(this).text();
		var $this = $(this);
			$.get("search.php",
			{term: selected},
			function( data ) {
				$this.text(data);
				$this.html($this.text().split(' ')
					.map(function(x){
					x = x.split(',');
					var delim = ' ';
					if (x[2] == '助詞-接続助詞' || x[2]== '動詞-接尾' || x[2]=='名詞-非自立-一般' ){
						return x[0];
					}
					else {
					var type = '/';
					if (x[2] == '助動詞'  ){ type = 'aux'}
					if (x[2].indexOf('助詞') > -1){type ='prt'}
					if (x[2].indexOf('副詞') > -1){type = 'adv'}
						return "</span> <span type="+type+" read="+x[1]+" class='word'>"+x[0];
					}	
					})
					.join(''));

				$this.children().on('mouseenter', function() {
					$(this).css("color","red");
				});
				$this.children().on('tap vclick click',function(){
					
				if (!$(this).attr('data-toggled') || $(this).attr('data-toggled') == 'off'){	
					var $this = $(this);
					var lookup = $(this).text();
					var type = $(this).attr("type");
					$(this).css("color","red");	
					$.get("search.php",
					{lookup: lookup, type: type},
					function( data ) {
						if (data!=''){
					//	var lookup = $this.text();
						$this.parent().parent().append('<div class="tip" id="'+lookup+'">'+data+'</div>')
						}	
						//$this.qtip({
						//	content: {
						//		text: data
						//	}
						//});
					});
					$(this).attr('data-toggled','on');
				}
				else if ($(this).attr('data-toggled') == 'on'){
					var lookup = $(this).text();
					$(this).attr('data-toggled','off');
					console.log('#'.lookup);
					 $('#'+lookup).remove();
					$(this).css("color","#555");

				}
				});
				$this.children().on('mouseleave', function() {
				 if (!$(this).attr('data-toggled') || $(this).attr('data-toggled') == 'off'){
					$(this).css("color","#555");
					//$('.tip').remove();
				 }
				});

			});
									
	});
$
});
	$('span.word').mouseenter(function() {
		$(this).css("color","red");
		var lookup = $(this).text();
		console.log(lookup);
		$.get("search.php",
			{lookup: lookup},
			function( data ) {
				console.log(  data );
		});
	});

</script>
</head>
<?php
if (!empty($_GET['key'])){ ?>

<style>
.logo{margin-top:30px;}
</style>
<?php
}
?>
<body>   
<div id="fb-root"></div>
<script>(function(d, s, id) {
  var js, fjs = d.getElementsByTagName(s)[0];
		   if (d.getElementById(id)) return;
		   js = d.createElement(s); js.id = id;
		     js.src = "//connect.facebook.net/en_US/sdk.js#xfbml=1&appId=1470461789888881&version=v2.0";
		     fjs.parentNode.insertBefore(js, fjs);
		     }(document, 'script', 'facebook-jssdk'));</script>

<div class="navbar">
<!--<img class="small" src="/logosmall.png" />-->
<a href=""><span class="pre">mochiron.net </span></a><span class="label">by <a href="http://spacedotworks.com"><span class="spd">spacedotworks</span></a></span> 
<a href="https://twitter.com/share" class="twitter-share-button" data-url="http://mochiron.net/" data-text="Mochiron - natural sounding phrases, not machine translations" data-hashtags="mochiron">Tweet</a>
<script>!function(d,s,id){var js,fjs=d.getElementsByTagName(s)[0],p=/^http:/.test(d.location)?'http':'https';if(!d.getElementById(id)){js=d.createElement(s);js.id=id;js.src=p+'://platform.twitter.com/widgets.js';fjs.parentNode.insertBefore(js,fjs);}}(document, 'script', 'twitter-wjs');</script>
	<div class="buttons">
		<div class="fb-share-button" data-href="http://mochiron.net/"></div>
	</div>
</div>

<div class="content">
    	<a href="." ><img class="logo" src="logo.png" /></a>
	<form id="form" action="" method="GET">
	<input placeholder="e.g. I'm sorry for being late" value="<?php echo $_GET['key'] ?>" id="key" name="key" class="auto clearable" type="text" size="25" data-clear-btn="true" />
	<div class="after">*supports English, Japanese and Romaji input</div>
        <input id="hit" name="hit" type="hidden" value="submit" />
    </form>
</div>

<!--<div id="pop" class="tooltiptext"></div>-->
<script type="text/javascript">
 $(function(){
	 $("#key").autocomplete({
		 source: "autocomplete.php",
	         minLength: 1,
		 position: {my:"top",at:"bottom",of:"#key"},
		 select: function(event, ui) {
			 	console.log("haha");
				$("#key").val(ui.item.label); 
				$("#form").submit();
				document.getElementById("form").submit();
		 },
	 	 
	 	});

	    });
 
 </script>


<?php 

if (!empty($_GET['key'])){

$config = parse_ini_file('../../sql.ini');
$con=mysqli_connect($config['host'],$config['username'],$config['password'],$config['dbname']);
if (mysqli_connect_errno()) {
	  echo "Failed to connect to MySQL: " . mysqli_connect_error();
}
$key=mysqli_real_escape_string($con,$_GET['key']);

if (preg_match('/[\x{4E00}-\x{9FBF}\x{3040}-\x{309F}\x{30A0}-\x{30FF}]/u', $key)){
     putenv('LANG=en_US.UTF-8');
     $key=exec( 'echo '.$key.' | mecab  -O wakati');
};

mysqli_set_charset($con,"utf8");
$dt = date('Y-m-d H:i:s');
$ip = $_SERVER['REMOTE_ADDR'];
//echo $ip;
mysqli_query($con,'INSERT INTO shizen_queries (term,date,ip)
	VALUES ("'.$key.'","'.$dt.'","'.$ip.'")');

$query="SELECT id,jpn,eng,match(jpn,eng,jpn_s,yomi,romaji) against ('".$key."') from allonly7 where match(jpn,eng,jpn_s,yomi,romaji) against ('".$key."') LIMIT 50";
//echo $query;

echo '<div><div class="guide">click or tap on Japanese characters</div></div>';
$result = mysqli_query($con,$query);
echo '<div><div class="results" id="results">';
$i=0;
while($row = mysqli_fetch_array($result)) {
	$i+=1;
	if ($i == count($row)){$extend = "end";} else {$extend = "";}
	  echo "<div class='one-result' id='$extend'><div><span class='jpn'>".$row['jpn'] . "</span><img class='voice' id='".$row['id'] ."' src='images/sound.png' style='vertical-align:middle' height='20px'></img><br /><span class='eng'>" . $row['eng']."</span></div></div>";
 }
echo '</div></div>';
mysqli_close($con);
}
?> 
</body>
</html>

