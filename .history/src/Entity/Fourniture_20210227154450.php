<?php declare(strict_types=1);
namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping AS ORM;
use App\Repository\FournitureRepository;
use Doctrine\ORM\Mapping\OneToMany;


/**
 * Class Fourniture
 * @package App\Entity
 * @ORM\Entity(repositoryClass=FournitureRepository::class)
 */
class Fourniture
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private ?int $id;

    /**
     * @ORM\Column(type="string",length=255)
     */
    private string $name;

    /**
     * @ORM\Column(type="float")
     */
    private float $buyPrice;

    /**
     * @ORM\Column (type="boolean")
     */
    private  bool $isPriceUpdatable;

    /**
     * @OneToMany (targetEntity="ProduitFourniture",mappedBy="fourniture")
     */
    private  $fournitureProduit;


    /**
     * Fourniture constructor.
     */
    public function __construct()
    {
        $this->fournitureProduit = new ArrayCollection();
    }




    /**
     * @return string
     */
    public function getName(): string
    {
        return $this->name;
    }

    /**
     * @param string $name
     */
    public function setName(string $name): void
    {
        $this->name = $name;
    }

    /**
     * @return float
     */
    public function getBuyPrice(): float
    {
        return $this->buyPrice;
    }

    /**
     * @param float $buyPrice
     */
    public function setBuyPrice(float $buyPrice): void
    {
        $this->buyPrice = $buyPrice;
    }

    /**
     * @return bool
     */
    public function isPriceUpdatable(): bool
    {
        return $this->isPriceUpdatable;
    }

    /**
     * @param bool $isPriceUpdatable
     */
    public function setIsPriceUpdatable(bool $isPriceUpdatable): void
    {
        $this->isPriceUpdatable = $isPriceUpdatable;
    }

    public function getId() : ?int
    {
        return $this->id;
    }

    __tost
}