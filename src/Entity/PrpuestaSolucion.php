<?php



namespace TDW\GCuest\Entity;
use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;

/**
 * PrpuestaSolucion
 *
 * @ORM\Table(name="prpuesta_solucion", indexes={@ORM\Index(name="fk_prpuesta_solucion_soluciones1_idx", columns={"soluciones_idsoluciones"}), @ORM\Index(name="fk_prpuesta_solucion_usuarios1_idx", columns={"usuarios_id"})})
 * @ORM\Entity
 */
class PrpuestaSolucion
{
    /**
     * @var int
     *
     * @ORM\Column(name="idprpuesta_solucion", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $idprpuestaSolucion;

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
