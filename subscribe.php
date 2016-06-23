<?php
$api_key = "5068ba911fa94940cddcc6b7c6545b8b-us12"; - // How get your Mailchimp API KEY - http://kb.mailchimp.com/article/where-can-i-find-my-api-key
$list_id = 'a6989412c9'; - // How to get your Mailchimp LIST ID - http://kb.mailchimp.com/article/how-can-i-find-my-list-id
 
require('Mailchimp.php');
$Mailchimp = new Mailchimp( $api_key );
$Mailchimp_Lists = new Mailchimp_Lists( $Mailchimp );
$subscriber = $Mailchimp_Lists->subscribe( $list_id, array( 'email' => htmlentities($_POST['email']) ) );
 
if ( ! empty( $subscriber['leid'] ) ) {
echo "success";
}
else
{
echo "fail";
}
 
?>