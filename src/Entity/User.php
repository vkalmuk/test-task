<?php

namespace App\Entity;

use App\Repository\UserRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Security\Core\User\PasswordAuthenticatedUserInterface;
use Symfony\Component\Security\Core\User\UserInterface;

/**
 * @ORM\Entity(repositoryClass=UserRepository::class)
 * @ORM\HasLifecycleCallbacks
 */
class User implements UserInterface, PasswordAuthenticatedUserInterface
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=180, unique=true)
     */
    private $username;

    /**
     * @ORM\Column(type="json")
     */
    private $roles = [];

    /**
     * @var string The hashed password
     * @ORM\Column(type="string")
     */
    private $password;

    /**
     * @ORM\Column(type="datetime_immutable")
     */
    private $createdAt;

    /**
     * @ORM\Column(type="datetime_immutable")
     */
    private $updatedAt;

    /**
     * @ORM\Column(type="string", length=100, nullable=true)
     */
    private $firstName;

    /**
     * @ORM\Column(type="string", length=100, nullable=true)
     */
    private $lastName;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $email;

    /**
     * @ORM\Column(type="date", nullable=true)
     */
    private $dayOfBirth;

    /**
     * @ORM\OneToMany(targetEntity=Address::class, mappedBy="user", cascade={"all"}, orphanRemoval=true)
     */
    private $Addresses;

    /**
     * @ORM\OneToMany(targetEntity=PhoneNumber::class, mappedBy="user", cascade={"all"}, orphanRemoval=true)
     */
    private $PhoneNumbers;

    public function __construct()
    {
        $this->Addresses = new ArrayCollection();
        $this->PhoneNumbers = new ArrayCollection();
    }

    public static function getRoleList(): array
    {
        return ["ROLE_USER" => "User", "ROLE_ADMIN" => "Admin"];
    }

    public function getRolesWithName(): array
    {
        return array_filter(self::getRoleList(), function ($key){
            return in_array($key, $this->getRoles());
        }, ARRAY_FILTER_USE_KEY);
    }

    /**
     * @ORM\PrePersist
     */
    public function onPrePersist()
    {
        $this->createdAt = new \DateTimeImmutable("now");
    }

    /**
     * @ORM\PreUpdate
     * @ORM\PrePersist
     */
    public function onPreUpdate()
    {
        $this->updatedAt = new \DateTimeImmutable("now");
    }

    /**
     * A visual identifier that represents this user.
     *
     * @see UserInterface
     */
    public function getUserIdentifier(): string
    {
        return (string) $this->username;
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getUsername(): string
    {
        return (string) $this->username;
    }

    public function setUsername(string $username): self
    {
        $this->username = $username;

        return $this;
    }

    public function getRoles(): array
    {
        $roles = $this->roles;
        $roles[] = 'ROLE_USER';

        return array_unique($roles);
    }

    public function setRoles(array $roles): self
    {
        $this->roles = array_unique($roles);

        return $this;
    }

    /**
     * @see PasswordAuthenticatedUserInterface
     */
    public function getPassword(): string
    {
        return $this->password;
    }

    public function setPassword(string $password): self
    {
        $this->password = $password;

        return $this;
    }

    /**
     * Returning a salt is only needed, if you are not using a modern
     * hashing algorithm (e.g. bcrypt or sodium) in your security.yaml.
     *
     * @see UserInterface
     */
    public function getSalt(): ?string
    {
        return null;
    }

    /**
     * @see UserInterface
     */
    public function eraseCredentials()
    {
        // If you store any temporary, sensitive data on the user, clear it here
        // $this->plainPassword = null;
    }

    public function getCreatedAt(): ?\DateTimeImmutable
    {
        return $this->createdAt;
    }


    public function setCreatedAt(\DateTimeImmutable $createdAt): self
    {
        $this->createdAt = $createdAt;

        return $this;
    }

    public function getUpdatedAt(): ?\DateTimeImmutable
    {
        return $this->updatedAt;
    }

    public function setUpdatedAt(\DateTimeImmutable $updatedAt): self
    {
        $this->updatedAt = $updatedAt;

        return $this;
    }

    public function getFirstName(): ?string
    {
        return $this->firstName;
    }

    public function setFirstName(?string $firstName): self
    {
        $this->firstName = $firstName;

        return $this;
    }

    public function getLastName(): ?string
    {
        return $this->lastName;
    }

    public function setLastName(?string $lastName): self
    {
        $this->lastName = $lastName;

        return $this;
    }

    public function getEmail(): ?string
    {
        return $this->email;
    }

    public function setEmail(?string $email): self
    {
        $this->email = $email;

        return $this;
    }

    public function getDayOfBirth(): ?\DateTimeInterface
    {
        return $this->dayOfBirth;
    }

    public function setDayOfBirth(?\DateTimeInterface $dayOfBirth): self
    {
        $this->dayOfBirth = $dayOfBirth;

        return $this;
    }

    /**
     * @return Collection|Address[]
     */
    public function getAddresses(): Collection
    {
        return $this->Addresses;
    }

    public function addAddress(Address $address): self
    {
        if (!$this->Addresses->contains($address)) {
            $this->Addresses[] = $address;
            $address->setUser($this);
        }

        return $this;
    }

    public function removeAddress(Address $address): self
    {
        if ($this->Addresses->removeElement($address)) {
            // set the owning side to null (unless already changed)
            if ($address->getUser() === $this) {
                $address->setUser(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection|PhoneNumber[]
     */
    public function getPhoneNumbers(): Collection
    {
        return $this->PhoneNumbers;
    }

    public function addPhoneNumber(PhoneNumber $phoneNumber): self
    {
        if (!$this->PhoneNumbers->contains($phoneNumber)) {
            $this->PhoneNumbers[] = $phoneNumber;
            $phoneNumber->setUser($this);
        }

        return $this;
    }

    public function removePhoneNumber(PhoneNumber $phoneNumber): self
    {
        if ($this->PhoneNumbers->removeElement($phoneNumber)) {
            // set the owning side to null (unless already changed)
            if ($phoneNumber->getUser() === $this) {
                $phoneNumber->setUser(null);
            }
        }

        return $this;
    }
}
