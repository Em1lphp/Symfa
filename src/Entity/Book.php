<?php

namespace App\Entity;

use App\Repository\BookRepository;

use DateTimeImmutable;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

use Symfony\Component\Serializer\Annotation\Groups;
use Symfony\Component\Validator\Constraints as Assert;

#[ORM\Entity(repositoryClass: BookRepository::class)]
class Book
{

    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    #[Groups(['author','book'])]
    private ?int $id = null;

    #[ORM\Column(type: Types::STRING, length: 50,nullable: false)]
    #[Groups(['author','book'])]
    private string $title;

    #[ORM\Column(type: Types::STRING, length: 50, nullable: true)]
    #[Groups(['author','book'])]
    private ?string $description = null;

    #[ORM\Column(type: Types::STRING, length: 255,unique: true, nullable: false)]
    #[Assert\File(
        maxSize: '2M',
        mimeTypes: ['image/jpeg', 'image/png'],
        mimeTypesMessage: 'Please upload the image in jpg or png format',
        uploadErrorMessage: 'Error uploading file'
    )]
    #[Groups(['author','book'])]
    private string $image;

    #[ORM\Column(type: Types::DATETIMETZ_IMMUTABLE,nullable: false)]
    #[Assert\DateTime]
    #[Groups(['author','book'])]
    private DateTimeImmutable $publishedAt;

    #[ORM\ManyToMany(targetEntity: Author::class, inversedBy: 'books')]
    #[Groups('book')]
    #[ORM\JoinTable(name: "author_book")]
    private Collection $authors;

    public function __construct()
    {
        $this->authors = new ArrayCollection();
    }

    /**
     * @return int|null
     */
    public function getId(): ?int
    {
        return $this->id;
    }


    /**
     * @return Collection<int, Author>
     */
    public function getAuthors(): Collection
    {
        return $this->authors;
    }

    /**
     * @param Author $author
     * @return Book
     */
    public function addAuthor(Author $author): self
    {
        if (!$this->authors->contains($author)) {
            $this->authors->add($author);
        }

        return $this;
    }

    /**
     * @param Author $author
     * @return Book
     */
    public function removeAuthor(Author $author): self
    {
        $this->authors->removeElement($author);

        return $this;
    }

    /**
     * @return string
     */
    public function getTitle(): string
    {
        return $this->title;
    }

    /**
     * @param string $title
     * @return Book
     */
    public function setTitle(string $title): self
    {
        $this->title = $title;

        return $this;
    }

    /**
     * @return string|null
     */
    public function getDescription(): ?string
    {
        return $this->description;
    }

    /**
     * @param string $description
     * @return Book
     */
    public function setDescription(string $description): self
    {
        $this->description = $description;

        return $this;
    }

    /**
     * @return string
     */
    public function getImage(): string
    {
        return $this->image;
    }

    /**
     * @param string $image
     * @return $this
     */
    public function setImage(string $image): self
    {
        $this->image = $image;

        return $this;
    }

    /**
     * @return DateTimeImmutable
     */
    public function getPublishedAt(): DateTimeImmutable
    {
        return $this->publishedAt;
    }

    /**
     * @param DateTimeImmutable $publishedAt
     * @return void
     */
    public function setPublishedAt(DateTimeImmutable $publishedAt): void
    {
        $this->publishedAt = $publishedAt;
    }
}
