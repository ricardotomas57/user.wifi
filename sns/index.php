<?php

require ("../common.php");

$emailreq = new emailRequest();

$json = file_get_contents('php://input');
$data = json_decode($json, true);
if (isset($data['SubscribeURL'])) 
{
    file_get_contents($data['SubscribeURL']);
    error_log("AWS SNS SubscribeURL confirmed");
} else 
{
    error_log("AWS SNS EMAIL: From : " . $data['mail']['commonHeaders']['from'][0]);
    $pattern = "/([a-zA-Z\.\-]+@[a-zA-Z\.\-]+)/";
    preg_match_all($pattern,$data['mail']['commonHeaders']['from'][0],$matches);
    $emailreq->setEmailFrom($matches[0]);
    preg_match_all($pattern,$data['mail']['commonHeaders']['to'][0],$matches);
    $emailreq->setEmailTo($matches[0]);
    $emailreq->setEmailSubject($data['mail']['commonHeaders']['subject']);
    $emailreq->setEmailBody($data['content']);

    switch ($emailreq->emailToCMD) {
        case "enroll":
            $emailreq->enroll();
        break;
        case "enrol":
            $emailreq->enroll();
        break;
        case "sponsor":
            $emailreq->sponsor();
        break;
        case "newsite":
            $emailreq->newsite();
        break;
        case "logrequest":
            $emailreq->logrequest();
        break;
    }
}

?>
