<?php

namespace App\Entity;

use App\Entity\User;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Component\Security\Core\User\UserInterface;


/**
 * @ORM\Entity(repositoryClass="App\Repository\UserRepository")
 * @UniqueEntity("email")
 */
class User implements UserInterface
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     * @Assert\NotBlank(message="Le prénom ne peut pas être vide")
     * @Assert\Length(min="2", minMessage="Le prénom est trop petit",
     *      max="255", maxMessage="Le prénom est trop long")
     */
    private $firstName;

    /**
     * @ORM\Column(type="string", length=255)
     * @Assert\NotBlank(message="Le nom de famille ne peut pas être vide")
     */
    private $lastName;

    /**
     * @ORM\Column(type="string", length=255)
     * @Assert\Email(message="L'email est invalide")
     * @Assert\NotBlank(message="L'email ne peut pas être vide")
     */
    private $email;

    /**
     * @ORM\Column(type="string", unique=true)
     * @Assert\NotBlank(message="Le mot de passe ne peut pas être vide")
     */
    private $password;

    /**
     * @ORM\Column(type="date", nullable=true)
     * @Assert\Type(type="DateTime")
     */
    private $birthDate;

    /**
     * @ORM\Column(type="date")
     */
    private $createdAt;
    
    /**
     * @ORM\Column(type="simple_array")
     */
    private $roles;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\content", mappedBy="user")
     */
    private $list_content;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\comment", mappedBy="user")
     */
    private $list_comment;


    public function __construct()
    {
        $this->roles = ['ROLE_USER'];
        $this->createdAt = new \DateTime();
        $this->list_content = new ArrayCollection();
        $this->list_comment = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getFirstName(): ?string
    {
        return $this->firstName;
    }

    public function setFirstName(string $firstName): self
    {
        $this->firstName = $firstName;

        return $this;
    }

    public function getLastName(): ?string
    {
        return $this->lastName;
    }

    public function setLastName(string $lastName): self
    {
        $this->lastName = $lastName;

        return $this;
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

    public function getRoles()
    {
        return $this->roles;
    }

    public function setRoles(array $roles): User
    {
        $this->roles = $roles;

        return $this;
    }

    public function getSalt()
    {
        return null;
    }
    public function getUsername()
    {
        return $this->email;
    }
    public function eraseCredentials()
    {
    }

    public function getPassword()
    {
        return $this->password;
    }

    public function setPassword(string $password)
    {
        $this->password = $password;

        return $this;
    }

    public function getBirthDate(): ?\DateTimeInterface
    {
        return $this->birthDate;
    }

    public function setBirthDate(?\DateTimeInterface $BirthDate): self
    {
        $this->birthDate = $BirthDate;

        return $this;
    }
    public function getCreatedAt(): ?\DateTimeInterface
    {
        return $this->createdAt;
    }
    public function setCreatedAt(?\DateTimeInterface $createdAt): self
    {
        $this->createdAt = $createdAt;
        return $this;
    }

    /**
     * @return Collection|content[]
     */
    public function getListContent(): Collection
    {
        return $this->list_content;
    }

    public function addListContent(content $listContent): self
    {
        if (!$this->list_content->contains($listContent)) {
            $this->list_content[] = $listContent;
            $listContent->setUser($this);
        }

        return $this;
    }

    public function removeListContent(content $listContent): self
    {
        if ($this->list_content->contains($listContent)) {
            $this->list_content->removeElement($listContent);
            // set the owning side to null (unless already changed)
            if ($listContent->getUser() === $this) {
                $listContent->setUser(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection|comment[]
     */
    public function getListComment(): Collection
    {
        return $this->list_comment;
    }

    public function addListComment(comment $listComment): self
    {
        if (!$this->list_comment->contains($listComment)) {
            $this->list_comment[] = $listComment;
            $listComment->setUser($this);
        }

        return $this;
    }

    public function removeListComment(comment $listComment): self
    {
        if ($this->list_comment->contains($listComment)) {
            $this->list_comment->removeElement($listComment);
            // set the owning side to null (unless already changed)
            if ($listComment->getUser() === $this) {
                $listComment->setUser(null);
            }
        }

        return $this;
    }
}