<p align="center"><a href="https://laravel.com" target="_blank"><img src="https://raw.githubusercontent.com/laravel/art/master/logo-lockup/5%20SVG/2%20CMYK/1%20Full%20Color/laravel-logolockup-cmyk-red.svg" width="400"></a></p>

<p align="center">
<a href="https://travis-ci.org/laravel/framework"><img src="https://travis-ci.org/laravel/framework.svg" alt="Build Status"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/dt/laravel/framework" alt="Total Downloads"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/v/laravel/framework" alt="Latest Stable Version"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/l/laravel/framework" alt="License"></a>
</p>

## About Dorniplus
<div class="flex flex-col leading-8">
<div>
 Dorniplus is relatively an advanced user registration system. It is built with Laravel,Inertia.js and Vuejs. To clone and use the project, it should be noted you must read about h4cc/wkhtmltopdf-amd64 0.12.x installation with composer and how to handle it. for example in Debian-based Linux you should run these commands after installing that:
</div>
<div>
Commands : 
<pre>
1 - run : git clone https://github.com/rainbow1997/Dorniplus.git
2 - set database and email settings in the .env file first. (do not run any commands)
3 - it would be best if you were sure you had installed PHP modules before. like :
    mysql,pdo_mysql,mbstring,fileinfo,curl,gd
4 - run : php composer install (if you have an error, run : rm composer.lock or delete composer.lock)
5 - run : php artisan key:generate 
6 - run : php artisan Storage:link
7 - run : php artisan migrate
8 - run : php artisan db:seed --force
9 - run : npm install
10 - run : npm run dev
11 - download wkhtmltopdf software from under link based on your system:
      11-1 :https://wkhtmltopdf.org/downloads.html
    11-2 : go to config/snappy.php and edit binary element of pdf element 
        in the file and set your whk installation path.
12 - run : php artisan serve
</pre>

Programmer : Mostafa Jamali (https://mostafajamali.ir).
Good luck.
</div>
</div>
