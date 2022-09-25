<?php
namespace App\Enum;

enum CommentStatus: string
{
    case PUBLIC = 'public';
    case HIDDEN = 'hidden';
    case USERS = 'users';

}
