<?php

namespace App\Enums;

enum LiveAccess: string
{
    case Free = 'free';
    case SubscribersOnly = 'subscribers_only';
    case PayPerView = 'ppv';
}
