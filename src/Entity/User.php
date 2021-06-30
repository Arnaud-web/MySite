<?php

namespace App\Entity;

use App\Repository\UserRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Security\Core\User\UserInterface;

/**
 * @ORM\Entity(repositoryClass=UserRepository::class)
 */
class User implements UserInterface
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
    private $email;

    /**
     * @ORM\Column(type="json")
     */
    private $roles = [];

    /**
     * @var string The hashed password
     * @ORM\Column(type="string")
     */
    private $password;
    private $confirm_password;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $name;

    /**
     * @ORM\Column(type="datetime")
     */
    private $createdAt;

    /**
     * @ORM\Column(type="datetime", nullable=true)
     */
    private $updatedAt;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $fullName;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $job;

    /**
     * @ORM\OneToMany(targetEntity=UserPhoto::class, mappedBy="user")
     */
    private $userPhotos;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $photo;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $tel;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $adress;

    /**
     * @ORM\ManyToMany(targetEntity=User::class, inversedBy="myFrinds")
     */
    private $Frinds;

    /**
     * @ORM\ManyToMany(targetEntity=User::class, mappedBy="Frinds")
     */
    private $myFrinds;

    public function __construct()
    {
        $this->userPhotos = new ArrayCollection();
        $this->Frinds = new ArrayCollection();
        $this->myFrinds = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getEmail(): ?string
    {
        return $this->email;
    }

    public function setEmail(string $email): self
    {
        $this->email = $email;

        return $this;
    }

    /**
     * A visual identifier that represents this user.
     *
     * @see UserInterface
     */
    public function getUsername(): string
    {
        return (string) $this->email;
    }

    /**
     * @see UserInterface
     */
    public function getRoles(): array
    {
        $roles = $this->roles;
        // guarantee every user at least has ROLE_USER
//        $roles[] = 'ROLE_USER';

        return array_unique($roles);
    }

    public function setRoles(array $roles): self
    {
        $this->roles = $roles;

        return $this;
    }

    /**
     * @see UserInterface
     */
    public function getPassword(): string
    {
        return (string) $this->password;
    }

    public function setPassword(string $password): self
    {
        $this->password = $password;

        return $this;
    }  public function getConfirmPassword(): string
    {
        return (string) $this->confirm_password;
    }

    public function setConfirmPassword(string $password): self
    {
        $this->confirm_password = $password;

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

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(string $name): self
    {
        $this->name = $name;

        return $this;
    }

    public function getCreatedAt(): ?\DateTimeInterface
    {
        return $this->createdAt;
    }

    public function setCreatedAt(\DateTimeInterface $createdAt): self
    {
        $this->createdAt = $createdAt;

        return $this;
    }

    public function getUpdatedAt(): ?\DateTimeInterface
    {
        return $this->updatedAt;
    }

    public function setUpdatedAt(?\DateTimeInterface $updatedAt): self
    {
        $this->updatedAt = $updatedAt;

        return $this;
    }

    public function getFullName(): ?string
    {
        return $this->fullName;
    }

    public function setFullName(?string $fullName): self
    {
        $this->fullName = $fullName;

        return $this;
    }

    public function getJob(): ?string
    {
        return $this->job;
    }

    public function setJob(?string $job): self
    {
        $this->job = $job;

        return $this;
    }

    /**
     * @return Collection|UserPhoto[]
     */
    public function getUserPhotos(): Collection
    {
        return $this->userPhotos;
    }

    public function addUserPhoto(UserPhoto $userPhoto): self
    {
        if (!$this->userPhotos->contains($userPhoto)) {
            $this->userPhotos[] = $userPhoto;
            $userPhoto->setUser($this);
        }

        return $this;
    }

    public function removeUserPhoto(UserPhoto $userPhoto): self
    {
        if ($this->userPhotos->removeElement($userPhoto)) {
            // set the owning side to null (unless already changed)
            if ($userPhoto->getUser() === $this) {
                $userPhoto->setUser(null);
            }
        }

        return $this;
    }

    public function getPhoto(): ?string
    {
        return $this->photo;
    }

    public function setPhoto(?string $photo): self
    {
        $this->photo = $photo;

        return $this;
    }

    public function getTel(): ?string
    {
        return $this->tel;
    }

    public function setTel(?string $tel): self
    {
        $this->tel = $tel;

        return $this;
    }

    public function getAdress(): ?string
    {
        return $this->adress;
    }

    public function setAdress(?string $adress): self
    {
        $this->adress = $adress;

        return $this;
    }

    /**
     * @return Collection|self[]
     */
    public function getFrinds(): Collection
    {
        return $this->Frinds;
    }

    public function addFrind(self $frind): self
    {
        if (!$this->Frinds->contains($frind)) {
            $this->Frinds[] = $frind;
        }else{
            $this->Frinds->removeElement($frind);
        }

        return $this;
    }

    public function removeFrind(self $frind): self
    {
        $this->Frinds->removeElement($frind);

        return $this;
    }

    /**
     * @return Collection|self[]
     */
    public function getMyFrind(): Collection
    {
        return $this->myFrinds;
    }

    public function addMyFrind(self $user): self
    {
        if (!$this->myFrinds->contains($user)) {
            $this->myFrinds[] = $user;
            $user->addFrind($this);
        }

        return $this;
    }

    public function removeMyFrind(self $user): self
    {
        if ($this->myFrinds->removeElement($user)) {
            $user->removeFrind($this);
        }

        return $this;
    }

    public function isFrind( $user): bool {
        if ($this->Frinds->contains($user)) {
            return true;
        }else{
            return false;
        }
    }
}
