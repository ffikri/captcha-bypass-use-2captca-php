<?php

$key2CAPTCHA = "key2captcha";
$urlWEB = "link website";
$googlekey = "google key";

$getID = json_decode(curlGET('https://2captcha.com/in.php?key=' . $key2CAPTCHA . '&method=userrecaptcha&googlekey=' . $googlekey . '&pageurl=' . $urlWEB . '&json=1'));
$resID = $getID->request;

if ($getID->status == "0") {
    echo "\e[\033[0;31mGAGAL GET ID!! GOOGLE KEY SALAH / APIKEY SALAH!!\e[0m\n";
    die;
} elseif ($getID->status == "1") {
    echo "\033[0;32mBERHASIL MENDAPATKAN ID\e[0m : $resID ~>> ";
    cekULANGgetID: // HASIL OUTPUT 0 AKAN MENCOBA KEMBALI DARI SINI 

    //# GET RESPONSE CAPTCHA
    $getRESPONSE = json_decode(curlGET('https://2captcha.com/res.php?key=' . $key2CAPTCHA . '&action=get&id=' . $resID . '&json=1'));
    if ($getRESPONSE->status == "0") {
        echo "\e[\033[0;31mGAGAL!! MENCOBA ULANG!!\e[0m\n";
        sleep(2);
        goto cekULANGgetID; //JIKA STATUS HASIL / OUTPUT 0 ATAU GAGAL, MAKA DIA AKAN MENCOBA KEMBALI
    } elseif ($getRESPONSE->status == "1") {
        $response = $getRESPONSE->request;
        echo "\033[0;32mBERHASIL BYPASS CAPTCHA!!\e[0m\nRESPONSE : $response";
        //JIKA KAMU INGIN MENGGUNAKAN HASIL REPONSE DENGAN VARIABLE SENDIRI, MAKAN BUAT SAJA CONTOH : $reponse = $getRESPONSE->request;
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
