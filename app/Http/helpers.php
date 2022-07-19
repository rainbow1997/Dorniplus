<?php
if(!function_exists('captchaMaking'))
{

    function captchaMaking()
    {
        refreshSession();
        setCaptchaSession();
        return captchaImageMaking();


    }
    function refreshSession()
    {
        if(session()->exists('captcha_num'))
            session()->forget('captcha_num');
    }
    function getCaptchaCode()
    {
        return session('captcha_num');
    }
    function setCaptchaSession()
    {
        $captcha_num = rand(100000,99999999);
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
}   