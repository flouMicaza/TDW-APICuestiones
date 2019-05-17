<?php


namespace TDW\GCuest\Entity;
use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;

/**
 * Soluciones
 *
 * @ORM\Table(name="soluciones", indexes={@ORM\Index(name="fk_soluciones_cuestiones_idx", columns={"cuestiones_idCuestion"})})
 * @ORM\Entity
 */
class Soluciones
{
    /**
     * @var int
     *
     * @ORM\Column(name="idsoluciones", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $idsoluciones;

    /**
     * @var string|null
     *
     * @ORM\Column(name="descripcion", type="string", length=225, nullable=true)
     */
    private $descripcion;

    /**
     * @var bool|null
     *
     * @ORM\Column(name="correcta", type="boolean", nullable=true)
     */
    private $correcta;

    /**
     * @var \Cuestion
     *
     * @ORM\ManyToOne(targetEntity="Cuestion")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="cuestiones_idCuestion", referencedColumnName="idCuestion")
     * })
     */
    private $cuestionescuestion;


}
