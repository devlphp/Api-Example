<?php
declare(strict_types=1);

namespace ApiExample;

enum RegistryKeys: string
{
    case DATABASE = 'database';
    case START_TIME = 'start_time';
    case REQUEST = 'request';
}