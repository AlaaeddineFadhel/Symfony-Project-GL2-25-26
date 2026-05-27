<?php


namespace App\Enum;

enum AchievementType: string
{
    case Award = 'award';
    case Honour = 'honour';
    case Publication = 'publication';
    case Competition = 'competition';
    case Other = 'other';
}
