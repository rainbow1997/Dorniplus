<?php
namespace App\Enum;

enum MilitaryStatus:string
{
    case TEMPORARY_EXEMPTION = 'temporary_exemption';
    case PERMANENT_EXEMPTION = 'permanent_exemption';
    case DONE = 'done';
    
}