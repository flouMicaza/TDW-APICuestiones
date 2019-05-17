<?php


namespace TDW\GCuest\Entity;
use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
/**
 * RespuestaRazonamiento
 *
 * @ORM\Table(name="respuesta_razonamiento", indexes={@ORM\Index(name="fk_respuesta_razonamiento_usuarios1_idx", columns={"usuarios_id"}), @ORM\Index(name="fk_respuesta_razonamiento_razonamiento1_idx", columns={"razonamiento_idrazonamiento"})})
 * @ORM\Entity
 */
class RespuestaRazonamiento
{
    /**
     * @var int
     *
     * @ORM\Column(name="idrespuesta_razonamiento", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="NONE")
     */
    private $idrespuestaRazonamiento;

    /**
     * @var bool|null
     *
     * @ORM\Column(name="respuesta", type="boolean", nullable=true)
     */
    private $respuesta;

    /**
     * @var \Razonamiento
     *
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="NONE")
     * @ORM\OneToOne(targetEntity="Razonamiento")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="razonamiento_idrazonamiento", referencedColumnName="idrazonamiento")
     * })
     */
    private $razonamientorazonamiento;

    /**
     * @var \Usuario
     *
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="NONE")
     * @ORM\OneToOne(targetEntity="Usuario")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="usuarios_id", referencedColumnName="id")
     * })
     */
    private $usuario;


}
