/*
This code was written for WordPress and is to be placed inside a shortcode using Shortcode Exec PHP plugin by Marcel Bokhorst.
You need to remove the opening <? and closing ?> before pasting it into the WordPress plugin.
This code is for using the Buyat XML feeds.
You call it from a Page or Post using [nameofshortcode].
*/

<?
$xml = simplexml_load_file("https://users.buy.at/ma/index.php/affiliateVoucherCodes/list?handle=0&filter_status=y&include_pending=1&include_active=1&include_expired=0&prog_id=0&vertical_id=0&orderby=date_added&dir=desc&format=xml&email=YOUR-EMAIL&password=YOUR-PASSWORD");

echo '<table>';

echo '<tr>
        	<th scope="col">Retailer</th>
            <th scope="col">Description</th>
            <th scope="col">Voucher Code</th>
            <th scope="col">Start Date</th>
            <th scope="col">End Date</th>
            <th scope="col">Link</th>
        </tr>';

foreach($xml->body->children() as $child)
{
		if($child->status=='Active')
		{
			echo '<tr>';
			echo '<td>' . $child->programme . "</td>";
			echo '<td>' . $child->description . "</td>";
			echo '<td>' . $child->offer_code . "</td>";
			echo '<td>' . $child->start . "</td>";
			echo '<td>' . $child->end . "</td>";
			echo '<td><a href="' . $child->url . '" target="_blank" rel="nofollow" title="Visit website to use voucher code">Use Code</a></td>';
			echo '</tr>';
		}
}

echo '</table>';

?>