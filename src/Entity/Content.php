<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\ContentRepository")
 */
class Content
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $title;

    /**
     * @ORM\Column(type="text")
     */
    private $content;

    /**
     * @ORM\Column(type="datetime")
     */
    private $createdAt;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\User", inversedBy="list_content")
     */
    private $user;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\comment", mappedBy="content")
     */
    private $list_comment;

    public function __construct()
    {
        $this->list_comment = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getTitle(): ?string
    {
        return $this->title;
    }

    public function setTitle(string $title): self
    {
        $this->title = $title;

        return $this;
    }

    public function getContent(): ?string
    {
        return $this->content;
    }

    public function setContent(string $content): self
    {
        $this->content = $content;

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

    public function getUser(): ?User
    {
        return $this->user;
    }

    public function setUser(?User $user): self
    {
        $this->user = $user;

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
            $listComment->setContent($this);
        }

        return $this;
    }

    public function removeListComment(comment $listComment): self
    {
        if ($this->list_comment->contains($listComment)) {
            $this->list_comment->removeElement($listComment);
            // set the owning side to null (unless already changed)
            if ($listComment->getContent() === $this) {
                $listComment->setContent(null);
            }
        }

        return $this;
    }
}
