<?php
 
// ==== Control Vars =======
$strFromNumber = "+14356593159";
$strToNumber = "+918759034233";
$strMsg = "Test SMS for our System! Its RIGHT OR NOT?"; //Olivier accidentally pulled up a porn site on a projector 
$aryResponse = array();
 

    // include the Twilio PHP library - download from 
    // http://www.twilio.com/docs/libraries/
    require_once ("inc/Services/Twilio.php");
 
    // set our AccountSid and AuthToken - from www.twilio.com/user/account
    $AccountSid = "AC7d20ae852e5bb8b9c57be5bca25074b6";
    $AuthToken = "ab91e4187f272d67c546ff21fbaf9f8c";
 
    // ini a new Twilio Rest Client
    $objConnection = new Services_Twilio($AccountSid, $AuthToken);


    // Send a new outgoinging SMS by POSTing to the SMS resource */
    $bSuccess = $objConnection->account->sms_messages->create(
        
        $strFromNumber, 	// number we are sending From 
        $strToNumber,           // number we are sending To
        $strMsg			// the sms body
    );

		
    $aryResponse["SentMsg"] = $strMsg;
    $aryResponse["Success"] = true;
    
    
   // echo json_encode($aryResponse);
