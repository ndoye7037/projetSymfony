<?php

namespace App\Entity;

use Symfony\Component\Validator\Constraints as Assert;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity]
class Recipe
{
    #[ORM\Id]
    #[ORM\GeneratedValue(strategy: "AUTO")]
    #[ORM\Column(type: "integer")]
    private int $id;

    #[Assert\NotBlank(message: "Le titre du plat ne doit pas être vide !")]
    #[Assert\Length(
        min: 10,
        max: 150,
        minMessage: "Le titre du plat doit faire plus de 10 caractères.",
        maxMessage: "Le titre du plat doit faire moins de 150 caractères."
    )]
    #[ORM\Column(unique: true)]
    private string $title;

    #[Assert\NotBlank(message: "La description du plat ne doit pas être vide !")]
    #[Assert\Length(
        min: 10,
        max: 150,
        minMessage: "La description du plat doit faire plus de 10 caractères.",
        maxMessage: "La description du plat doit faire moins de 150 caractères."
    )]
    #[ORM\Column(type: "text")]
    private string $description;
    #[ORM\Column(type: "text")]
    private string $ingredients;
    #[ORM\Column(type: "text")]
    private string $steps;
    #[ORM\Column(nullable: true)]
    private ?string $image;

    public function getId(): int
    {

        return $this->id;
    }

    public function setId(int $id): void
    {
        $this->id = $id;
    }

    public function getTitle(): string
    {
        return $this->title;
    }

    public function setTitle(string $title): void
    {
        $this->title = $title;
    }

    public function getDescription(): string
    {
        return $this->description;
    }

    public function setDescription(string $description): void
    {
        $this->description = $description;
    }

    public function getIngredients(): string
    {
        return $this->ingredients;
    }

    public function setIngredients(string $ingredients): void
    {
        $this->ingredients = $ingredients;
    }

    public function getSteps(): string
    {
        return $this->steps;
    }

    public function setSteps(string $steps): void
    {
        $this->steps = $steps;
    }

    public function getImage(): ?string
    {
        return $this->image;
    }

    public function setImage(?string $image): void
    {
        $this->image = $image;
    }

}
