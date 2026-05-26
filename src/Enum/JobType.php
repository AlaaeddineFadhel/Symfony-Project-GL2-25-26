<?php

namespace App\Enum;

enum JobType: string
{
    case PartTime   = 'part-time';
    case FullTime   = 'full-time';
    case Internship = 'internship';
}
