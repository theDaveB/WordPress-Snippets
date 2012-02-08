/*
This code was written for WordPress and is to be placed inside a shortcode using Shortcode Exec PHP plugin by Marcel Bokhorst.
You need to remove the opening <? and closing ?> before pasting it into the WordPress plugin.
This code is for using the MediFusion XML feeds for price comparison.
You call it from a Page or Post using [nameofshortcode ASIN="ASIN ID"].
The way i used it was to write a description about the product and then stick the shortcode at the bottom of the description.
The code goes through the XML for the given ASIN, display details about the product and then displays a price comparison table.
*/

<?

extract(shortcode_atts(array('asin' => 'default'), $atts));
$xml = simplexml_load_file("http://www.find-game.co.uk/services/gameprices.asp?site=YOUR-MEDIFUSION-ID&mode=heavy&id=" . $asin);
echo '<table id="hor-minimalist-b" summary="Item details"><tr><td>';
echo '<img src="' . $xml->imageURL . '" alt="Thumbnail image for "' . $xml->title . '></td><td>';
echo 'Title - ' . $xml->title . '<br />';
echo 'Platform - ' . $xml->platformName . '<br />';
echo 'Category - ' . $xml->category . '<br />';
echo 'Released - ' . $xml->released . '<br />';
echo 'RRP - ' . $xml->rrp . '<br />';
echo 'Price Now - ' . $xml->minimumPrice . '<br />';
echo 'Prices Last Checked - ' . $xml->pricesLastCached . '<br />';
echo '</td></tr></table>';
echo '<table id="hor-minimalist-b" summary="Price results">';
echo '<tr><th scope="col">Retailer</th><th scope="col">Availability</th><th scope="col">Price</th><th scope="col">Postage</th><th scope="col">Total</th><th scope="col">Link</th></tr>';
foreach ($xml->retailers->children() as $retailer)
{
	if(!empty($retailer->availability))
	{
		echo '<tr><td><a href="' . $retailer->homePageURL . '" target="_blank" rel="nofollow" title="Visit homepage of store"><img src="/images/' . $retailer->name . '.gif" alt="' . $retailer->name . '" /></a></td><td>';
		if($retailer->availability=='')
		{
			echo 'No information available';
		}	else {
			echo $retailer->availability;
		}
		echo '</td><td>£' . $retailer->price . '</td>';
		if($retailer->postage=='0.00')
		{
			echo '<td>FREE';
		}	else {
			echo '<td>£' . $retailer->postage;
		}
		echo '</td><td>£' . $retailer->total . '</td><td><a href="' . $retailer->productURL . '" target="_blank" rel="nofollow" title="Visit store page to buy game">Buy Now</a></td></tr>';
	}
}
echo '</table>';
?>
