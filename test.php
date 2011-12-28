<?php


/**
 * @file
 * The PHP page that serves all page requests on a Drupal installation.
 *
 * The routines here dispatch control to the appropriate handler, which then
 * prints the appropriate page.
 *
 * All Drupal code is released under the GNU General Public License.
 * See COPYRIGHT.txt and LICENSE.txt.
 */

/**
 * Root directory of Drupal installation.
 */
define('DRUPAL_ROOT', getcwd());

require_once DRUPAL_ROOT . '/includes/bootstrap.inc';
drupal_bootstrap(DRUPAL_BOOTSTRAP_FULL);




echo 'Starting checking available products <br />';

$xml = new DOMDocument();
$xml->load('test.xml');

$xpath = new DOMXPath($xml);
$products = $xpath->query('/store/product[available[@value="yes"]]/identification');

for ($i = 0; $i < $products->length; $i++)
{
if ($products->item($i) && !$products->item($i)->hasChildNodes()) continue;

$childs = $products->item($i)->childNodes;

echo "<br />Full name: ".$childs->item(1)->nodeValue."<br />";
echo "Model: ".$childs->item(3)->nodeValue."<br />";
}

//$game = $xml->xpath("//game");
//
//$count = count($game);
//
//$i = 0;
//
//while($i < $count)
//{
//
//echo '<h1>'.$game[$i]['name'].'</h1>';
//echo 'Kick Off on '.$game[$i]['date'].' @ '.$game[$i]['time'];
//echo '<br/>' . $game[$i] . '<br/>';
//
//$i++;
//
//}




	
$speciality[1] = "Editorials";
$speciality[2] = "Review Article";
$speciality[3] = "Aspects of Current Management";
$speciality[4] = "Annotation";
$speciality[5] = "Operative technique";
$speciality[6] = "Hip";
$speciality[7] = "Knee";
$speciality[8] = "Lower limb";
$speciality[9] = "Upper limb";
$speciality[10] = "Spine";
$speciality[11] = "Trauma";
$speciality[12] = "Arthroplasty";
$speciality[13] = "Oncology";
$speciality[14] = "Children's Orthopaedics";
$speciality[15] = "General Orthopaedics";
$speciality[16] = "Case Reports";
$speciality[17] = "Research";
$speciality[18] = "Foot and Ankle";



$courses_meeting_type[1] = "Conference";
$courses_meeting_type[2] = "Seminar";
$courses_meeting_type[3] = "Workshop";
$courses_meeting_type[4] = "Course";
$courses_meeting_type[5] = "Meeting";
$courses_meeting_type[6] = "Symposium";
$courses_meeting_type[7] = "Other";

