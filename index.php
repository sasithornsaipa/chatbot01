<?php
    $accesstoken = "l/WuR3bdR68j+HYeWkj9ngr2sAc5TT/f/7J/7oKM/MFuk2LPKD/GzhQ6aU7jvlQ3nR7rxOFdhSylL2KX23/
                    AE8EFpLQOM6cR5xzP6R/GkQhw549L8rNSvBdsNPGB5E715R87W9KsXgRrPAS0kKEZYwdB04t89/1O/w1cDnyilFU=";
    
    $content = file_get_contents('php://input');
    $arrayJson = jason_decode($content, true);

    $arrayHeader = array();
    $arrayHeader[] = "Content-Type: application/jason";
    $arrayHeader[] = "Authorization: Bearer {$accesstoken}";

    $message = $arrayJson['events'][0]['message']['text'];

    if ($message=='สวัสดี') {
        $arrayPostData['replyToken'] = $arrayJson['events'][0]['replyToken'];
        $arrayPostData['messages'][0]['type'] = "text";
        $arrayPostData['messages'][0]['text'] = "สวัสดี เป็นยังไงบ้าง";
        replyMsg($arrayHeader,$arrayPostData);
    }
    elseif ($message=='เหนื่อยจัง') {
        $arrayPostData['replyToken'] = $arrayJson['events'][0]['replyToken'];
        $arrayPostData['messages'][0]['type'] = "sticker";
        $arrayPostData['messages'][0]['packageID'] = "2";
        $arrayPostData['messages'][0]['stickerID'] = "157";
        replyMsg($arrayHeader,$arrayPostData);    
    }

    function replyMsg($arrayHeader, $arrayPostData){
        $strURL = "https://api.line.me/v2/bot/message/reply";
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL,$strUrl);
        curl_setopt($ch, CURLOPT_HEADER, false);
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_HTTPHEADER, $arrayHeader);    
        curl_setopt($ch, CURLOPT_POSTFIELDS,json_encode($arrayPostData));
        curl_setopt($ch, CURLOPT_RETURNTRANSFER,true);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        $result = curl_exec($ch);
        curl_close ($ch);
    }

    exit;
?>