<?php
declare(strict_types=1);

namespace App\Repository\User;

use App\Entity\User;
use App\Repository\UserRepositoryInterface;
use App\Security\Role;
use Symfony\Component\PasswordHasher\Hasher\PasswordHasherFactoryInterface;
use Symfony\Component\Security\Core\User\PasswordAuthenticatedUserInterface;

class RuntimeUserRepository implements UserRepositoryInterface
{

    private $db = [
        'admin' => ['name' => 'Admin', 'password' => 'master', 'roles' => [Role::ROLE_ADMIN]],
        'rec1' => ['name' => 'Recruiter 1', 'password' => 'master', 'roles' => [Role::ROLE_RECRUITER]],
        'can1' => ['name' => 'Candidate 1', 'password' => 'master', 'roles' => [Role::ROLE_CANDIDATE]],
    ];

    public function __construct(private PasswordHasherFactoryInterface $passwordHasherFactory)
    {
    }

    public function findByLogin(string $login): ?User
    {
        if (!isset($this->db[$login])) {
            return null;
        }

        $passHasher = $this->passwordHasherFactory->getPasswordHasher(PasswordAuthenticatedUserInterface::class);

        $dbUser = $this->db[$login];

        return new User($dbUser['name'], $login, $passHasher->hash($dbUser['password']), $dbUser['roles']);
    }
}