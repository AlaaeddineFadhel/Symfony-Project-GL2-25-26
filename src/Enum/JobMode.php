<?php

namespace App\Enum;

enum JobMode: string
{
    case Remote  = 'remote';
    case Onsite  = 'onsite';
    case Hybrid  = 'hybrid';
}
