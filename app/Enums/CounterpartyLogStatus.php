<?php

namespace App\Enums;

enum CounterpartyLogStatus: string
{
    case COMPLETED = 'completed';
    case ERROR = 'error';
}
