<?php

$file_handle = fopen("fdtn_expense_categories.csv", "r");
/*
Taxonomy Vocabulary key
2 Vendors
3 Alumni Accts
4 Foundation Funds
7 Alumni Expense Categories
8 Foundation Expense Categories
*/
$vid = 8;
$tid = 1306;
while (!feof($file_handle) ) {
	$line= fgetcsv($file_handle);
	$acct_no = addslashes($line[0]);
	$acct_name = addslashes($line[1]);
	
	print  "INSERT INTO `taxonomy_term_data` (`tid`, `vid`, `name`, `description`, `format`, `weight`) 
VALUES($tid, $vid, '$acct_name', '', 'full_html', 0);<br>

INSERT INTO `taxonomy_term_hierarchy` (`tid`, `parent`) 
VALUES($tid, 0);<br>

INSERT INTO `field_data_field_code` (`entity_type`, `bundle`, `deleted`, `entity_id`, `revision_id`, `language`, `delta`, `field_code_value`) 
VALUES('taxonomy_term', 'payment_categories', 0, $tid, $tid, 'und', 0, '$acct_no');<br><br>";
	
	$tid++;
}
fclose($file_handle);
/*

INSERT INTO `taxonomy_term_data` (`tid`, `vid`, `name`, `description`, `format`, `weight`) VALUES
($tid, $vid, '$acct_name', '', 'full_html', 0);

INSERT INTO `taxonomy_term_hierarchy` (`tid`, `parent`) VALUES
($tid, 0);

INSERT INTO `field_data_field_account_number` (`entity_type`, `bundle`, `deleted`, `entity_id`, `revision_id`, `language`, `delta`, `field_account_number_value`, `field_account_number_format`) VALUES
('taxonomy_term', 'alumni_accounts', 0, $tid, $tid, 'und', 0, '$acct_no', NULL);

--------------------------------------------------------------------------

INSERT INTO `taxonomy_term_data` (`tid`, `vid`, `name`, `description`, `format`, `weight`) 
VALUES($tid, $vid, '$acct_name', '', 'full_html', 0);<br>

INSERT INTO `taxonomy_term_hierarchy` (`tid`, `parent`) 
VALUES($tid, 0);<br>

INSERT INTO `field_data_field_code` (`entity_type`, `bundle`, `deleted`, `entity_id`, `revision_id`, `language`, `delta`, `field_code_value`) 
VALUES('taxonomy_term', 'payment_categories', 0, $tid, $tid, 'und', 0, '$acct_no');<br><br>

--------------------------------------------------------------------------

UPDATE taxonomy_term_data
SET taxonomy_term_data.name = '$acct_no - $acct_name'
WHERE taxonomy_term_data.name = '$acct_name';

--------------------------------------------------------------------------

"INSERT INTO `taxonomy_term_data` (`tid`, `vid`, `name`, `description`, `format`, `weight`) 
VALUES($tid, $vid, '$acct_no', '', 'full_html', 0);<br>

INSERT INTO `taxonomy_term_hierarchy` (`tid`, `parent`) 
VALUES($tid, 0);<br><br>"

*/
?>


