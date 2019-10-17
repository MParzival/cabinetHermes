<?php


namespace App\Entity;

use Symfony\Component\Validator\Constraints as Assert;
class PropertySearch
{
    /**
     * @var int|null
     */
    private $maxPrice;

    /**
     * @var int|null
     * @Assert\Range(min="10")
     */
    private $minSurface;

    /**
     * @var int|null
     */
    private $numeroRef;

    /**
     * @return int|null
     */
    public function getMaxPrice(): ?int
    {
        return $this->maxPrice;
    }

    /**
     * @param int|null $maxPrice
     * @return PropertySearch
     */
    public function setMaxPrice(int $maxPrice): PropertySearch
    {
        $this->maxPrice = $maxPrice;
        return $this;
    }

    /**
     * @return int|null
     */
    public function getMinSurface(): ?int
    {
        return $this->minSurface;
    }

    /**
     * @param int|null $minSurface
     * @return PropertySearch
     */
    public function setMinSurface(int $minSurface): PropertySearch
    {
        $this->minSurface = $minSurface;
        return $this;
    }

    /**
     * @return int|null
     */
    public function getNumeroRef(): ?int
    {
        return $this->numeroRef;
    }

    /**
     * @param int|null $numeroRef
     * @return PropertySearch
     */
    public function setNumeroRef(int $numeroRef): PropertySearch
    {
        $this->numeroRef = $numeroRef;
        return $this;
    }
}