<?php

namespace App\Enums;

enum Role: string
{
    case SuperAdmin = 'SuperAdmin';
    case Admin = 'Admin';
    case Member = 'Member';
  

   
    public static function values(): array
    {
        return array_column(self::cases(), 'value');
    }

    // Team invite 
    public static function invitable(): array
    {
        return [self::Admin, self::Member];
    }
}