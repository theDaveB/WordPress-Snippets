/*
This code was written for WordPress and is to be placed inside a shortcode using Shortcode Exec PHP plugin by Marcel Bokhorst.
You need to remove the opening <? and closing ?> before pasting it into the WordPress plugin.
This code is for using the Affiliate Window CSV Voucher Code feeds.
You call it from a Page or Post using [nameofshortcode].
*/

<?

$file_handle = fopen("http://www.affiliatewindow.com/affiliates/discount_vouchers.php?user=USER-ID&password=YOUR-PASSWORD&export=csv&voucherSearch=1&rel=1", "r");

echo '<table>';
echo '<tr>
        <th scope="col">Retailer</th>
            <th scope="col">Description</th>
            <th scope="col">Voucher Code</th>
            <th scope="col">Start Date</th>
            <th scope="col">End Date</th>
            <th scope="col">Link</th>
        </tr>';

while (!feof($file_handle) ) {

	$line_of_text = fgetcsv($file_handle);

	echo '<tr><td>' . $line_of_text[0] . "</td>";
	echo '<td>' . $line_of_text[3] . "</td>";
	echo '<td>' . $line_of_text[2] . "</td>";
	echo '<td>' . $line_of_text[5] . "</td>";
	echo '<td>' . $line_of_text[6] . "</td>";
	echo '<td><a href="' . $line_of_text[4] . '" target="_blank" rel="nofollow" title="Visit website to use voucher code">Use Code</a></td></tr>';

}

fclose($file_handle);

echo '</table>';

?>
