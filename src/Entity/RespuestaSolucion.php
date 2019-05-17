<?php



namespace TDW\GCuest\Entity;
use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;

/**
 * RespuestaSolucion
 *
 * @ORM\Table(name="respuesta_solucion", indexes={@ORM\Index(name="fk_respuesta_solucion_soluciones1_idx", columns={"soluciones_idsoluciones"}), @ORM\Index(name="fk_respuesta_solucion_usuarios1_idx", columns={"usuarios_id"})})
 * @ORM\Entity
 */
class RespuestaSolucion
{
    /**
     * @var int
     *
     * @ORM\Column(name="idrespuesta_solucion", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $idrespuestaSolucion;

    /**
     * @var bool|null
     *
     * @ORM\Column(name="respuesta", type="boolean", nullable=true)
     */
    private $respuesta;

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
