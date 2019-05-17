<?php



namespace TDW\GCuest\Entity;
use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;

/**
 * Razonamiento
 *
 * @ORM\Table(name="razonamiento", indexes={@ORM\Index(name="fk_razonamiento_soluciones1_idx", columns={"soluciones_idsoluciones"})})
 * @ORM\Entity
 */
class Razonamiento
{
    /**
     * @var int
     *
     * @ORM\Column(name="idrazonamiento", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $idrazonamiento;

    /**
     * @var string|null
     *
     * @ORM\Column(name="descripcion", type="string", length=225, nullable=true)
     */
    private $descripcion;

    /**
     * @var bool|null
     *
     * @ORM\Column(name="justificado", type="boolean", nullable=true)
     */
    private $justificado;

    /**
     * @var string|null
     *
     * @ORM\Column(name="error", type="string", length=225, nullable=true)
     */
    private $error;

    /**
     * @var \Soluciones
     *
     * @ORM\ManyToOne(targetEntity="Soluciones")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="soluciones_idsoluciones", referencedColumnName="idsoluciones")
     * })
     */
    private $solucionessoluciones;


}
