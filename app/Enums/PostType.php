<?php

namespace App\Enums;

enum PostType: string
{
    case Text = 'text';
    case Photo = 'photo';
    case Video = 'video';
    case Audio = 'audio';
    case Reel = 'reel';
}
