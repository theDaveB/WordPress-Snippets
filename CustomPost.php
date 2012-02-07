/*
This code was written for WordPress and is to be placed inside a shortcode using Shortcode Exec PHP plugin by Marcel Bokhorst.
You need to remove the opening <? and closing ?> before pasting it into the WordPress plugin.
You call it from a Page or Post using [nameofshortcode URL="URL to XML feed"].
The way I used it was, I placed it on a hidden page and then when I wanted to insert new posts, I viewed the hidden page
from inside the WP admin interface.
The code basically goes through the XML and builds up a post, also in the XML is field (imageURL), which used to post a image to WP.

This is a sample of the XML I was using -

<games>
<game>
<id>B000B5KMSE</id>
<platform>xbox360</platform>
<platformName>XBox 360</platformName>
<category>Accessories</category>
<title>Xbox LIVE Gold 12-Month Membership Card (Xbox 360)</title>
<titleRefNo>11873</titleRefNo>
<groupTitle>Xbox LIVE Gold 12 Month Membership Card</groupTitle>
<released>02/12/2005</released>
<rrp>40.84</rrp>
<minimumPrice>28.85</minimumPrice>
<minimumPrice_inStock>28.85</minimumPrice_inStock>
<description>A world of entertainment is yours with Xbox LIVE 12 Month Gold Membership.Watch live sports and TV from Sky with Sky Player1 on Xbox LIVE. Jump rightin to online games with friends around the world. Plus, enjoy personalisedmusic with a Zune Pass and Last.fm3, update your status on Facebook and bepart of whats happening on Twitter right on your TV. And Kinect makesyour entertainment even more extraordinary. Imagine controlling moviesand music with the wave of a hand or the sound of your voice, or chattingon your TV with Video Kinect2. Upgrade today for moregames, entertainment and fun. Windows Phone 7 featuringXbox LIVE lets you connect and play games with your friends4.Use your Xbox LIVE profile to access your avatar, gamerscore,and achievements. Share scores and earn recognition for youraccomplishments across the phone, web, and Xbox. You caneven earn achievements on Windows Phone that add to yourXbox LIVE gamerscore.1 BSkyB Ltd All Rights Reserved. Sky Player is sold separately, and subject toseparate terms and conditions. Sky Player requires a recommended broadbandspeed of 2mpbs. Sky Player subscriptions costs apply. For full details www.xbox.com/skyplayer2 Video Kinect available November 2010.3 Zune Pass requires Zune Pass Subscription and Xbox LIVE Gold Membership.Avaliable November 2010.4 Mobile network access required; carrier fees may apply. :: Customer Review = 4.898</description>
<thumbnailURL>http://www.find-game.co.uk/thumbs/B000B5KMSE.jpg</thumbnailURL>
<imageURL>http://www.find-game.co.uk/pictures/B000B5KMSE.jpg</imageURL>
</game>
</games>

*/

<?
extract(shortcode_atts(array('url' => 'default'), $atts));
require_once('wp-admin/includes/media.php');
require_once('wp-admin/includes/file.php');
require_once('wp-admin/includes/image.php');
echo "Arg=" . $url . PHP_EOL;
$xml = simplexml_load_file(html_entity_decode($url));

foreach ($xml->children() as $item)
{

	// Create post object
	$my_post = array(
		'post_title' => $item->groupTitle . ' on ' . $item->platformName,
		'post_content' => $item->description . 'Category: ' . $item->category . '[get_details ASIN="' . $item->id . '"]',
    	'post_status' => 'draft',
    	'post_author' => 1
	);

	// Insert the post into the database
	$new_post = wp_insert_post( $my_post );

	// If there is a imageURL, upload it and associate it with $new_post (This is the WP ID of the post)
	if(!empty($item->imageURL))
	{
		$file_url = media_sideload_image($item->imageURL,$new_post);
		echo $new_post . ' ' . $item->imageURL . ' ' . $file_url;
	}
	else
	{
		echo $new_post;
	}

	echo '<br />';

}
?>
