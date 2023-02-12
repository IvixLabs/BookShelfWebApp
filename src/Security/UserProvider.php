<?php
declare(strict_types=1);

namespace App\Security;

use App\Entity\User;
use App\Repository\UserRepositoryInterface;
use Symfony\Component\Security\Core\Exception\UnsupportedUserException;
use Symfony\Component\Security\Core\Exception\UserNotFoundException;
use Symfony\Component\Security\Core\User\PasswordAuthenticatedUserInterface;
use Symfony\Component\Security\Core\User\PasswordUpgraderInterface;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Security\Core\User\UserProviderInterface;

class UserProvider implements UserProviderInterface, PasswordUpgraderInterface
{

    public function __construct(private UserRepositoryInterface $userRepository)
    {
    }

    public function refreshUser(UserInterface $user)
    {
        throw new UnsupportedUserException();
    }

    public function supportsClass(string $class)
    {
        return User::class === $class || is_subclass_of($class, User::class);
    }

    public function loadUserByIdentifier(string $identifier): UserInterface
    {
        $user = $this->userRepository->findByLogin($identifier);

        if ($user !== null) {
            return $user;
        }

        throw new UserNotFoundException();

    }

    public function upgradePassword(PasswordAuthenticatedUserInterface $user, string $newHashedPassword): void
    {
        throw new \Exception('Method is not implemented');
    }
}