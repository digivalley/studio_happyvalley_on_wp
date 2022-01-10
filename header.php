<?php
/**
 * The header for our theme
 * This is the template that displays all of the <head> section and everything up until <div id="content">
 * @link https://developer.wordpress.org/themes/basics/template-files/#template-partials
 * @package WordPress
 * @subpackage shv
 * @since 1.0.0
 * この箇所の空行はそのままHTMLソースに反映される
 */
//Set-Cookie: key=value; path=/; domain= home_url(); HttpOnly; SameSite=Lax;
$vnum = date("mdhis");
global $slug_name;
global $post_type;
global $path;
global $svgpath;
global $title;
global $cat_slug;
global $pagetitle;
if( is_search() ){$slug_name = 'search';}
if(!$slug_name){
	$slug_name = $post->post_name;
}
$path = dirname( __FILE__ ) . '/indv/' . $slug_name;
$cat_name = '';
$category = get_the_category();
if(!empty($category))$cat_name = $category[0]->cat_name;
$seotitle = CFS()->get( 'title4seo' ); 
$subtitle = '';
$status = CFS()->get( 'status' ); 
$cardstatus = '';
if(!empty($status)) $cardstatus = implode(" ", $status);
$optGoogle = '';
if(strpos($cardstatus,'reference') !== false){
	$optGoogle = '<meta name="robots" content="noindex">'; 
}
$title = single_post_title( '', false );
if(!empty($seotitle)) {
	$subtitle = $seotitle;
}else if(!empty($cat_name)){
	$subtitle = $cat_name;
}

?>
<!DOCTYPE html>
<html dir="ltr" lang="ja">
<head data-date="<?php echo $vnum?>">
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width,initial-scale=1.0,minimum-scale=1.0,maximum-scale=2.0,user-scalable=1">
<meta content="yes" name="apple-mobile-web-app-capable" >
<?php 
echo $optGoogle; 
if(is_search() ){ $title = '『' . $pagetitle . '』を探してみたよ';}
?>
<!-- 専用$seotitle || $subtitle -->
<title><?php echo $title; ?> | <?php echo $subtitle; ?>『 <?php bloginfo('name'); ?> | <?php bloginfo('description'); ?> 』</title>

<!-- WPHEADER こっから /wp-includes/default-filters.php -->
<!-- _wp_render_title_tag: 1267Line:/wp-includes/general-template.php -->
<!-- functions.php 50line add_theme_support( 'title-tag' );をコメントアウト -->
<?php wp_head(); ?>
<!-- WPHEADER ここまで -->
<!-- CSS +++++++++++++++++ -->
<link rel="stylesheet" href="/assets/shv/css/base.css?id=<?php echo $vnum?>">
<link href="/assets/shv/css/footer.css?id=<?php echo $vnum?>" rel="stylesheet">

 <?php
$body_id= '';
$bread_cr= '';
$structured_data_search_box= '';

if ( is_front_page() ) {
	$post_type= 'top';
    $body_class = 'shv top';
	//echo '<link rel="stylesheet" href="/assets/shv/css/lay2021.css?id='.$vnum.'">';
	echo '<link rel="stylesheet" href="/assets/shv/css/contents_information.css?id='.$vnum.'">';

	$structured_data_search_box=
	'<script type="application/ld+json">
    {
		"@context": "https://schema.org",
		"@type": "WebSite",
		"name": "『WEB制作事業所 スタジオ・ハッピィバリー』の検索ボックス",
		"image": "https://studio-happyvalley.com/assets/shv/images/slider/top.webp",
		"url": "https://studio-happyvalley.com/",
		"potentialAction": {
			"@type": "SearchAction",
			"target": {
				"@type": "EntryPoint",
				"urlTemplate": "https://studio-happyvalley.com/?s={search_term_string}"
			},
			"query-input": "required name=search_term_string"
		}
    }
</script>';
	
	
} else if(is_search() ){
	$post_type= 'search';
    $body_id= 'search';
	$body_class = 'lower search';
    $slug_name = 'search';
	$svgpath = '/indv/setSvg4' . $slug_name .'.js';
}else{
    $body_class = 'lower';
	echo '<link rel="stylesheet" href="/assets/shv/css/contents_information.css?id='.$vnum.'">';

	if ( is_page() ){
		$post_type= 'page';
		$body_class .= ' page';
		if($slug_name == 'contact' || $slug_name == 'confirm' || $slug_name == 'complete' || $slug_name == 'error'){
			echo '<link type="text/css" rel="stylesheet" href="/assets/shv/css/formParts.css?id=9991">
			<link rel="stylesheet" href="/assets/shv/css/nSetHtml.css?id='.$vnum.'">
			<link rel="stylesheet" href="/assets/shv/css/nSetHtml.css?id='.$vnum.'">
			<link href="https://use.fontawesome.com/releases/v5.0.13/css/all.css?id='.$vnum.'" rel="stylesheet">';
		}
		if($slug_name == 'devilsworkshop' || $slug_name == 'labo' || $slug_name == 'webhealer' || $slug_name == 'creation' || $slug_name == 'happydeveloper'){
				$svgpath = '/indv/setSvg4' . $slug_name .'.js';
		}
	} else if ( is_single() ){
		$post_type= 'single';
		$cat_slug = get_the_category()[0]->category_nicename.'';
		$body_class .= ' single';
		$body_class .= ' '.$cat_slug;
		$decoratypes = CFS()->get( 'decoratype' ); 
		$decoratype = implode(" ", $decoratypes);
		$body_class .= ' '.$decoratype;
		$columntype = '';
		$columntypes = CFS()->get( 'columntype' ); 
		if(!empty($columntypes) ){ $columntype = implode(" ", $columntypes);}
		$body_class .= ' '.$columntype;
	} else if ( is_category() ) {
		$category = get_the_category();
		$body_id .= ' category_'.$category[0]->category_nicename.'';
	} else if ( is_404() ){
		$body_class .= ' notfound';
		$slug_name= 404;
	}

	$pagetitle = CFS()->get('pagetitle'); 
	if(!$pagetitle)$pagetitle = $slug_name;
	$bc_current_positopn= 2;
	$second_title= '';
	if($cat_slug){
		$second_title= 
'		{
			"@type": "ListItem",
			"position": 2,
			"name": "' . $cat_slug . '",
			"item": "'.esc_url( get_home_url() ).'/'.$cat_slug.'"
		},';
		$bc_current_positopn= 3;
		$svgpath = '/indv/setSvg4' . $cat_slug .'.js';
	}
	$bread_cr= 
'<script type="application/ld+json">
{
	"@context": "https://schema.org",
	"@type": "BreadcrumbList",
	"name": "『'. $title .'』のパンくずリスト",
	"itemListElement": 
	[
		{
			"@type": "ListItem",
			"position": 1,
			"name": "Top",
			"item": "'.esc_url( get_home_url() ).'"
		},
		'.$second_title.'
		{
			"@type": "ListItem",
			"position": "'.$bc_current_positopn.'",
			"name": "'.$pagetitle.'"
		}
	]
}
</script>';
}

?>

<link rel="stylesheet" href="/assets/shv/css/header.css?id=<?php echo $vnum?>">
<link rel="stylesheet" href="/assets/shv/css/prism.css?id=<?php echo $vnum?>">
<link rel="stylesheet" href="/assets/shv/css/works.css?id=<?php echo $vnum?>">
<link rel="stylesheet" href="/assets/shv/css/layout4lw.css?id=<?php echo $vnum?>">
<link rel="stylesheet" href="/assets/shv/css/layout2.css?id=<?php echo $vnum?>">
<link rel="stylesheet" href="/assets/shv/css/response767.css?id=<?php echo $vnum?>">
<link rel="stylesheet" href="/assets/shv/css/contents.css?id=<?php echo $vnum?>">
<link href="/assets/shv/css/parascroll.css?id=<?php echo $vnum?>" rel="stylesheet">
<link href="/assets/shv/css/card.css?id=<?php echo $vnum?>" media="all" rel="stylesheet">
<link href="/assets/shv/css/searchform.css?id=<?php echo $vnum?>" media="all" rel="stylesheet">
<link rel="stylesheet" href="/assets/shv/css/parallax.css?id=<?php echo $vnum?>">
<link rel="stylesheet" href="/assets/shv/css/individual.css?id=<?php echo $vnum?>">
<link rel="preconnect" href="https://fonts.googleapis.com">
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
<noscript><link href="/assets/shv/css/noscript.css?id=<?php echo $vnum?>" rel="stylesheet"></noscript>

        <!-- link rel="apple-touch-icon" sizes="120x120" href="/favicon/apple-touch-icon.png" -->
        <link rel="icon" type="image/png" href="/favicon/favicon-32x32.png" sizes="32x32">
        <!-- link rel="icon" type="image/png" href="/favicon/favicon-16x16.png" sizes="16x16" -->
        <link rel="manifest" href="/favicon/manifest.json">
        <link rel="shortcut icon" href="/favicon/favicon.ico">
        <link rel="mask-icon" href="/favicon/safari-pinned-tab.svg" color="#5bbad5">
<?php echo $bread_cr; ?>
<?php echo $structured_data_search_box; ?>

</head>

<body id="<?php echo $slug_name; ?>" class="<?php echo $body_class; ?>" data-id="<?php if(is_single()){ echo $cat_slug;}else{echo $slug_name;} ?>">
<!-- div id="fb-root"></div>
<script async defer crossorigin="anonymous" src="https://connect.facebook.net/ja_JP/sdk.js#xfbml=1&version=v9.0&appId=572456542796595&autoLogAppEvents=1" nonce="ZHqMh7rL"></script-->

 <div id="container" data-scroll-container>
<header id="fixedMenu" class="top">
	<a href="<?php echo esc_url( get_home_url() ); ?>/"><h1 id="shvLogo"><span class="en">Studio <br class="underW768">Happyvalley</span><span class="jp ffyg"><!--em class="alp"></em-->WEB制作 スタジオ・<br class="underW400">ハッピィバリー</span></h1></a>
	<div id="hmbMn">
		<div></div>
		<div></div>
		<div></div>
	</div>
	<nav id="scrollNavi" class="nav-collapse clearFix">
		 <?php wp_nav_menu( array(  
			 'theme_location' => 'primary', 
			 'container' => "",
			'menu_id' => 'topNav',
			'menu' => $slug_name

		 ) );
		 ?>
	</nav>
	<?php  get_search_form();  ?>	

	<!-- VISUAL +++++++++++ -->
<?php if(is_home()): ?>	

<?php elseif( is_single() /*or is_singular()*/ ): ?>	
<?php elseif( is_404() /*or is_singular()*/ ): ?>	
	
<?php else:  //$slug_name = $post->post_name;
$slug_name = preg_replace('/\d/', '', $slug_name);
?>
	
<?php endif; ?>
	<!-- VISUAL END +++++++++++ -->
</header>

<?php	
/* <script>
  (function(d) {
    var config = {
      kitId: 'lug2rbm',
      scriptTimeout: 3000,
      async: true
    },
    h=d.documentElement,t=setTimeout(function(){h.className=h.className.replace(/\bwf-loading\b/g,"")+" wf-inactive";},config.scriptTimeout),tk=d.createElement("script"),f=false,s=d.getElementsByTagName("script")[0],a;h.className+=" wf-loading";tk.src='https://use.typekit.net/'+config.kitId+'.js';tk.async=true;tk.onload=tk.onreadystatechange=function(){a=this.readyState;if(f||a&&a!="complete"&&a!="loaded")return;f=true;clearTimeout(t);try{Typekit.load(config)}catch(e){}};s.parentNode.insertBefore(tk,s)
  })(document);
</script> */