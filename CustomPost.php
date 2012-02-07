//*
This code was written for WordPress and is to be placed inside a shortcode using Shortcode Exec PHP plugin by Marcel Bokhorst.
You need to remove the opening <? and closing ?> before pasting it into the WordPress plugin.
You call it from a Page or Post using [nameofshortcode URL="URL to XML feed"].
The way I used it was, I placed it on a hidden page and then when I wanted to insert new posts, I viewed the hidden page
from inside the WP admin interface.
The code basically goes through the XML and builds up a post, also in the XML is field (imageURL), which used to post a image to WP.
*//

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

	// Insert the post and image into the database
	$new_post = wp_insert_post( $my_post );

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
