<?php


namespace TDW\GCuest\Entity;
use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;


/**
 * PropuestaRazonamiento
 *
 * @ORM\Table(name="propuesta_razonamiento", indexes={@ORM\Index(name="fk_propuesta_razonamiento_soluciones1_idx", columns={"soluciones_idsoluciones"}), @ORM\Index(name="fk_propuesta_razonamiento_usuarios1_idx", columns={"usuarios_id"})})
 * @ORM\Entity
 */
class PropuestaRazonamiento
{
    /**
     * @var int
     *
     * @ORM\Column(name="idpropuesta_razonamiento", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $idpropuestaRazonamiento;

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

    /**
     * @var \Usuario
     *
     * @ORM\ManyToOne(targetEntity="Usuario")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="usuarios_id", referencedColumnName="id")
     * })
     */
    private $usuarios;


}
