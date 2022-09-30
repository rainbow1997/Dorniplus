<?php

use App\Models\Detector;
use Carbon\Carbon;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Request as RequestFacade;
use Illuminate\Support\Facades\Storage;
use Morilog\Jalali\Jalalian;

if (!function_exists('captchaMaking')) {

    function captchaMaking()
    {
        refreshSession();
        setCaptchaSession();
        if (app()->getLocale() == 'fa_IR')
            return captchaImageMaking();

        return createEnCaptcha();


    }

    function refreshSession()
    {
        if (session()->exists('captcha_num'))
            session()->forget('captcha_num');
        session()->regenerate();
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

    function createEnCaptcha()
    {
        $pass = getCaptchaCode();
        $width = 168;
        $height = 50;
        $layer = imagecreatetruecolor($width, $height);
        $captcha_bg = imagecolorallocate($layer, 135,62,35);
        imagefill($layer, 0, 0, $captcha_bg);
        $captcha_text_color = imagecolorallocate($layer, 238,238,228);
        imagestring($layer, 5, 15, 15, implode(" ",str_split(getCaptchaCode(),1)), $captcha_text_color);
        header('content-type', 'image/png');
        return imagepng($layer);

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

    function convertDateForDBFromJalalian(string $date): Carbon
    {
        $date = convertToEngNums($date);
        $date = explode('/', $date);

        return
            $date = (new Jalalian($date[0], $date[1], $date[2]))->toCarbon();

    }

    function convertDateForDB(string $date): Carbon
    {
        $date = convertToEngNums($date);
        $date = explode('/', $date);
        return
            $date = Carbon::create($date[0], $date[1], $date[2]);

    }

    function removeFiles($files)
    {
        Storage::disk('public')->delete($files);
    }

    function apartSearchParameters(Collection $data, array $searchParams): Collection
    {
        $searchValues = collect();
        $data->each(function ($item, $key) use ($searchValues, $searchParams) {
            foreach ($searchParams as $searchParam)
                if ($key == $searchParam) {

                    $searchValues->put($searchParam, $item);
                }

        });

        return $searchValues;

    }

    function str_to_slug(string $string, string $separator = '-')
    {
        $string = convertToEngNums(trim(mb_strtolower($string)));
        $string = preg_replace('![' . preg_quote($separator === '-' ? '_' : '-') . ']+!u', $separator, $string);

        return preg_replace(
            '/\\' . $separator . '{2,}/',
            $separator,
            preg_replace('/[^A-Za-z0-9\x{0620}-\x{064A}\x{0698}\x{067E}\x{0686}\x{06AF}\x{06CC}\x{06A9}]/ui', $separator, $string)
        );
    }

    function hasUserDetectionCookie()
    {
        if (RequestFacade::hasCookie('detection_id'))
            return decrypt(RequestFacade::cookie('detection_id'));
        return false;
    }

    function isAuthenticatedUser()
    {
        $user = auth()->user();
        if ($user)
            return $user;
        return null;

    }

    function getAuthenticatedUserId()
    {
        if (isAuthenticatedUser())
            return isAuthenticatedUser()->id;
    }

    function registerDetectionCookieForUser()
    {
        $detector = Detector::create()->id;
        cookie()->queue(cookie()->forever('detection_id', encrypt($detector), 365 * 24 * 60));
        return $detector;
    }

    function givingUserDetector()
    {
        $request = RequestFacade::all();
        $user['cookie'] = hasUserDetectionCookie();

        if (!$user['cookie'])
            $user['cookie'] = registerDetectionCookieForUser();

        return $user['cookie'];

    }

    function givingNormalUserData()
    {
        $user['ip'] = RequestFacade::ip();
        $user['agent'] = RequestFacade::userAgent();
        return $user;
    }

    function giveUserData()
    {
        $user['detector'] = givingUserDetector();
        $user ['normal'] = givingNormalUserData();
        return $user;

    }
}

