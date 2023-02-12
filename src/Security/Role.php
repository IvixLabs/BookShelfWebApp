<?php

namespace App\Security;

enum Role
{
    case ROLE_ADMIN;
    case ROLE_RECRUITER;
    case ROLE_CANDIDATE;
}