<?php

use Illuminate\Support\Facades\Storage;
use Morilog\Jalali\Jalalian;

use Carbon\Carbon;
if (!function_exists('captchaMaking')) {

    function captchaMaking()
    {
        refreshSession();
        setCaptchaSession();
        return captchaImageMaking();


    }

    function refreshSession()
    {
        if (session()->exists('captcha_num'))
            session()->forget('captcha_num');
    }

    function getCaptchaCode()
    {
        return session('captcha_num');
    }

    function setCaptchaSession()
    {
        $captcha_num = rand(100000, 99999999);
        session(['captcha_num' => $captcha_num]);
    }

    function captchaImageMaking()
    {
        $gdTool = new Quince\PersianGD\GDTool();
        $imageContent = $gdTool->setOutputImage(false)
            ->addLine(getCaptchaCode())
            ->setFont('fonts/Shabnam.ttf')
            ->setFontSize(15)
            ->setWidth(140)
            ->setLineHeight(15)
            ->setVerticalPosition(25)
            ->build();

        header('content-type', 'image/png');
        return $imageContent;
    }

    function convertToEngNums($string)
    {
        return strtr($string, array('۰' => '0', '۱' => '1', '۲' => '2', '۳' => '3', '۴' => '4', '۵' => '5', '۶' => '6', '۷' => '7', '۸' => '8', '۹' => '9', '٠' => '0', '١' => '1', '٢' => '2', '٣' => '3', '٤' => '4', '٥' => '5', '٦' => '6', '٧' => '7', '٨' => '8', '٩' => '9'));
    }

    function convertDateForDB(string $date) : Carbon
    {
        $date = convertToEngNums($date);
        $date = explode('/', $date);
        return
            $date = (new Jalalian($date[0],$date[1],$date[2]))->toCarbon();

    }
     function removeFiles($files)
    {

        Storage::disk('public')->delete($files);
    }
}
