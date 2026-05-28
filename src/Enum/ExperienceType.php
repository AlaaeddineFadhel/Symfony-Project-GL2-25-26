<?php


namespace App\Enum;

enum ExperienceType: string
{
    case Job = 'job';
    case Certification = 'certification';
    case Internship = 'internship';
    case Freelance = 'freelance';
}
