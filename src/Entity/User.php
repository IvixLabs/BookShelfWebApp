<?php
declare(strict_types=1);

namespace App\Entity;

use ApiPlatform\Metadata\ApiResource;
use App\Security\Role;
use Ramsey\Uuid\Uuid;
use Symfony\Component\Security\Core\User\PasswordAuthenticatedUserInterface;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Validator\Constraints as Assert;

#[ApiResource(security: 'is_granted("ROLE_ADMIN")')]
class User implements UserInterface, PasswordAuthenticatedUserInterface
{

    /** The id of this user. */
    private string $id;

    /** The name of this user. */
    private string $name;

    /** The identifier of this user. */
    private string $login;

    /** The password of this user. */
    #[Assert\NotBlank]
    private string $password;

    /**
     * @var Role[]
     */
    private array $roles;

    public function __construct(string $name, string $login, string $password, array $roles)
    {
        $this->id = Uuid::uuid4()->toString();
        $this->name = $name;
        $this->login = $login;
        $this->password = $password;
        $this->roles = $roles;
    }

    public function getId(): string
    {
        return $this->id;
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function getLogin(): string
    {
        return $this->login;
    }

    public function getPassword(): string
    {
        return $this->password;
    }

    public function getRoles(): array
    {
        return array_map(function (Role $role) {
            return $role->name;
        }, $this->roles);
    }

    public function eraseCredentials()
    {
        // Do nothing
    }

    public function getUserIdentifier(): string
    {
        return $this->login;
    }
}