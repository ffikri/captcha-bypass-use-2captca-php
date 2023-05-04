<?php

$key2CAPTCHA = "key2captcha";
$urlWEB = "link website";
$googlekey = "google key";

$getID = curlGET('https://2captcha.com/in.php?key=' . $key2CAPTCHA . '&method=userrecaptcha&googlekey=' . $googlekey . '&pageurl=' . $urlWEB);

$pecahID    = explode("|", $getID);
$aidi = $pecahID[1];
if (strpos($getID, "ERROR_WRONG_GOOGLEKEY") !== false) {
    echo "\e[\033[0;31mGAGAL GET ID!! GOOGLE KEY SALAH / APIKEY SALAH!!\e[0m\n";
    die;
} elseif (strpos($getID, "OK") !== false) {
    echo "\033[0;32mBERHASIL MENDAPATKAN ID\e[0m : $aidi ~>> ";
    cekULANGgetID: // HASIL OUTPUT 0 AKAN MENCOBA KEMBALI DARI SINI 

    //# GET RESPONSE CAPTCHA
    $GETresult = curlGET('https://2captcha.com/res.php?key=' . $key2CAPTCHA . '&action=get&id=' . $aidi);
    if (strpos($GETresult, "CAPCHA_NOT_READY") !== false) {
        // echo "\e[\033[0;31mGAGAL GET RESPON ID!! MENCOBA ULANG... \e[0m\n";
        sleep(5);
        goto cekULANGgetID;
    } elseif (strpos($GETresult, "ERROR_ZERO_CAPTCHA_FILESIZE") !== false) {
        echo "\033[0;32mERROR!!\e[0m\n";
        die;
    } elseif (strpos($GETresult, "OK") !== false) {
        echo "\033[0;32mBERHASIL BYPASS CAPTCHA!!\e[0m\n";
        $pecahRESULT    = explode("|", $GETresult);
        $response = $pecahRESULT[1];
    } else {
        echo $GETresult;
        die;
    }
}

function curlGET($url)
{
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, $url);
    curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'GET');
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
    curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);
    $output = curl_exec($ch);
    curl_close($ch);
    return $output;
}
