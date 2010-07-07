<?

require_once WEBROOT . "/libraries/libraries_lib.inc";
require_once LIBDIR . "/LibraryInfo.php";

if ($_COOKIE['mitcertificate'] === 'yes') {

  $ask_expert_url = 'ask-form.php?page=expert';
  $ask_appointment_url = 'ask-form.php?page=appointment';

} else {

  $ask_expert_url = '../home/certcheck.php?' 
    . http_build_query(Array(
       'ref' => '../libraries/ask-form.php?page=expert',
       'name' => 'MIT Libraries: Ask Us',
       'image' => 'libraries',
       ));

  $ask_appointment_url = '../home/certcheck.php?'
    . http_build_query(Array(
       'ref' => '../libraries/ask-form.php?page=appointment',
       'name' => 'MIT Libraries: Ask Us',
       'image' => 'libraries',
       ));
}

require "$page->branch/ask.html";

$page->output();

?>
