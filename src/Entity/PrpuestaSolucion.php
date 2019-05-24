<?php
/**
 * PHP version 7.2
 * src\Entity\PropuestaSolucion.php
 */

namespace TDW\GCuest\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use OpenApi\Annotations as OA;

/**
 * PrpuestaSolucion
 *
 * @ORM\Table(name="prpuesta_solucion", indexes={@ORM\Index(name="fk_prpuesta_solucion_soluciones1_idx", columns={"soluciones_idsoluciones"}), @ORM\Index(name="fk_prpuesta_solucion_usuarios1_idx", columns={"usuarios_id"})})
 * @ORM\Entity
 */
class PropuestaSolucion implements \JsonSerializable
{
    /**
     * @var int
     *
     * @ORM\Column(name="idprpuesta_solucion", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $idpropuestaSolucion;

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
     * @var int
     *
     * @ORM\Column(name="soluciones_idsoluciones", type="integer", nullable=false)
     */
    private $solucionesIdsoluciones;

    /**
     * @var int
     *
     * @ORM\Column(name="usuarios_id", type="integer", nullable=false)
     */
    private $usuariosId;

   /**
     * PropuestaSolucion constructor.
     *
     * @param string  $descripcion
     * @param bool $correcta
     * @param string  $error
     * @param int  $solucionesIdsoluciones
     * @param int  $usuariosId
     *
     * @throws \Doctrine\ORM\ORMException
     */
    public function __construct(
        string $descripcion,
        int $solucionesIdsoluciones,
        int $usuariosId
    ) {
        $this->idpropuestaSolucion = 0;
        $this->descripcion = $descripcion;
        $this->correcta = null;
        $this->error = null;
        $this->solucionesIdsoluciones = $solucionesIdsoluciones;
        $this->usuariosId = $usuariosId;
    }
 /**
     * @return int
     */
    public function getIdPropuestaSolucion(){
        return $this->idpropuestaSolucion;
    }
    /**
     * @return string
     */
    public function getDescription(){
        return $this->descripcion;
    }
    /**
     * @return bool
     */
    public function isCorrecta(){
        return $this->correcta;
    }
    /**
     * @return string
     */
    public function getError(){
        return $this->error;
    }
    /**
     * @return int
     */
    public function getIdSolucion(){
        return $this->solucionesIdsoluciones;
    }
    /**
     * @return int
     */
    public function getIdUsuario(){
        return $this->usuariosId;
    }
    /**
     * @param string $descripcion
     * @return PropuestaSolucion
     */
    public function setDescripcion(string $descripcion): PropuestaSolucion
    {
        $this->descripcion = $descripcion;
        return $this;
    }
    /**
     * @param bool $correcta
     * @return PropuestaSolucion
     */
    public function setCorrecta(bool $correcta): PropuestaSolucion
    {
        $this->correcta = $correcta;
        return $this;
    }
    /**
     * @param string $error
     * @return PropuestaSolucion
     */
    public function setError(string $error): PropuestaSolucion
    {
        $this->error = $error;
        return $this;
    }
    /**
     * The __toString method allows a class to decide how it will react when it is converted to a string.
     *
     * @return string
     * @link http://php.net/manual/en/language.oop5.magic.php#language.oop5.magic.tostring
     */
    public function __toString()
    {
        return '[ propuestaSolucion ' .
            '(idPropuestaSolucion=' . $this->getIdPropuestaSolucion() . ', ' .
            'descripcion="' . $this->getDescription() . '", ' .
            'correcta=' . (int) $this->isCorrecta() . ', ' .
            'error=' . $this->getError() . ', ' .
            'solucionesIdsoluciones=' . (int)$this->getIdSolucion() . ', ' .

            'usuariosId=' . (int)$this->getIdUsuario() . ', ' .
            ') ]';
    }

    /**
     * Specify data which should be serialized to JSON
     * @link http://php.net/manual/en/jsonserializable.jsonserialize.php
     * @return mixed data which can be serialized by <b>json_encode</b>,
     * which is a value of any type other than a resource.
     * @since 5.4.0
     */
    public function jsonSerialize()
    {
        return [
            'propuestaSolucion' => [
                'idPropuestaSolucion' => $this->getIdPropuestaSolucion(),
                'descripcion' => $this->getDescription(),
                'correcta' => $this->isCorrecta(),
                'error' => $this->getError(),
                'solucionesIdsoluciones' => $this->getIdPropuestaSolucion(),
                'usuariosId' => $this->getIdUsuario()
            ]
        ];
    }
}

/**
 * PropuestaSolucion definition
 *
 * @OA\Schema(
 *     schema = "PropuestaSolucion",
 *     type   = "object",
 *     required = { "descripcion","solucionesIdsoluciones", "usuariosId"},
 *     
 *     @OA\Property(
 *          property    = "idPropuestaSolucion",
 *          description = "Propuesta solucion id",
 *          type        = "integer"
 *      ),
 *      @OA\Property(
 *          property    = "descripcion",
 *          description = "Propuesta solucion description",
 *          type        = "string"
 *      ),
 *      @OA\Property(
 *          property    = "correcta",
 *          description = "Denotes if propuesta de solucion is correct",
 *          type        = "boolean"
 *      ),
 * @OA\Property(
 *          property    = "error",
 *          description = "Propuesta solucion error",
 *          type        = "string"
 *      ),
 *      @OA\Property(
 *          property    = "solucionesIdsoluciones",
 *          description = "propuesta solucion parent solution",
 *          format      = "int64",
 *          type        = "integer"
 *      ),
 * @OA\Property(
 *          property    = "usuariosId",
 *          description = "user who created propuesta solucion",
 *          format      = "int64",
 *          type        = "integer"
 *      )
 * )
 *      
 *      example = {
 *              "idPropuestaSolucion" = 3,
 *              "descripcion" = "Solution description",
 *              "correcta"  = true,
 *              "error" = "Corrección del maestro",
 *              "solucionesIdsoluciones" = 7,
 *              "usuariosId" = 3
 *          }
 *     
 * )
 */

 /**
 * PropuestaSolucionData definition
 *
 * @OA\Schema(
 *     schema = "PropuestaSolucionData",
 *     type   = "object",
 *     required = { "descripcion","solucionesIdsoluciones"},
 *     
 *    
 *      @OA\Property(
 *          property    = "descripcion",
 *          description = "Propuesta solucion description",
 *          type        = "string"
 *      ),
 *      
 * @OA\Property(
 *          property    = "solucionesIdsoluciones",
 *          description = "propuesta solucion parent solution",
 *          format      = "int64",
 *          type        = "integer"
 *      ),
 * 
 * )
 *      
 *      example = {
 *              
 *              "descripcion" = "Solution description",
 *              "correcta"  = true,
 *              "error" = "Corrección del maestro",
 *              "solucionesIdSolucion" = 5
 *          }
 *     
 * )
 */