<?php
/**
 * This script handles the form processing
 *
 * PHP version 7.2
 *
 * @category Registration
 * @package  Registration
 * @author   Benson Imoh,ST <benson@stbensonimoh.com>
 * @license  GPL https://opensource.org/licenses/gpl-license
 * @link     https://stbensonimoh.com
 */
error_reporting(E_ALL);
ini_set('display_errors', 1);

// echo json_encode($_POST);

// Pull in the required files
require '../config.php';
require './DB.php';
require './Notify.php';
require './Newsletter.php';


//Capture the post data coming from the form
$firstname =$_POST['firstname'];
$lastname =$_POST['lastname'];
$phone =$_POST['phone'];
$email =$_POST['email'];
$groupName = htmlspecialchars($_POST['groupName']);
$groupType = $_POST['groupType'];
$numberofpersons =$_POST['numberofpersons'];

$details = array(
    "firstname" => $firstname,
    "lastname" => $lastname,
    "phone" => $phone,
    "email" => $email,
    "groupName" => $groupName,
    "groupType" => $groupType,
    "numberofpersons" => $numberofpersons
);


$db = new DB($host, $db, $username, $password);
$notify = new Notify($smstoken);


// First check to see if the user is in the Database
if ($db->userExists($email, "heforshe_group")) {
    echo json_encode("user_exists");
} else {
    // Insert the user into the database
    $db->getConnection()->beginTransaction();
    $db->insertUser("heforshe_group", $details);
    // Send SMS
    $notify->viaSMS(
        "HeForShe",
        "Dear {$groupName}, welcome to the AWLO HeForShe Africa Summit! You registration and accreditation was successful! Enjoy the event!
        - The AWLO Team",
        $phone
    );
    $db->getConnection()->commit();
    echo json_encode("success");
}