<?php

namespace App\Enums;

enum LiveMode: string
{
    case Public = 'public';
    case Group = 'group';
    case OneToOne = 'one_to_one';
}
