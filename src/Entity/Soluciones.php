<?php
/**
 * PHP version 7.2
 * src\Entity\Soluciones.php
 */

namespace TDW\GCuest\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use OpenApi\Annotations as OA;

/**
 * Soluciones
 *
 * @ORM\Table(name="soluciones", indexes={@ORM\Index(name="fk_soluciones_cuestiones_idx", columns={"cuestiones_idCuestion"})})
 * @ORM\Entity
 */
class Soluciones implements \JsonSerializable
{
    /**
     * @var int
     *
     * @ORM\Column(name="idsoluciones", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $idSoluciones;

    /**
     * @var string|null
     *
     * @ORM\Column(name="descripcion", type="string", length=225, nullable=true)
     */
    private $descripcion;

    /**
     * @var bool
     *
     * @ORM\Column(
     * name="correcta",
     * type="boolean",
     * options={ "default"=false })
     */
    private $correcta;

    /**
     * @var int
     *
     * @ORM\Column(name="cuestiones_idCuestion", type="integer", nullable=false)
     */
    private $cuestionesIdcuestion;
    
        /**
     * Soluciones constructor.
     *
     * @param string  $descripcion
     * @param bool $correcta
     * @param int  $cuestionesIdcuestion
     *
     * @throws \Doctrine\ORM\ORMException
     */
        public function __construct(
        string $descripcion,
        bool $correcta,
        int $cuestionesIdcuestion
    ) {
        $this->idSoluciones = 0;
        $this->descripcion = $descripcion;
        $this->correcta = $correcta;
        $this->cuestionesIdcuestion = $cuestionesIdcuestion;
        
    }
    /**
     * @return int
     */
    public function getIdSolucion(){
        return $this->idSoluciones;
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
     * @return int
     */
    public function getIdCuestion(){
        return $this->cuestionesIdcuestion;
    }
    /**
     * @param string $descripcion
     * @return Soluciones
     */
    public function setDescripcion(string $descripcion): Soluciones
    {
        $this->descripcion = $descripcion;
        return $this;
    }
    /**
     * @param bool $correcta
     * @return Soluciones
     */
    public function setCorrecta(bool $correcta): Soluciones
    {
        $this->correcta = $correcta;
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
        return '[ cuestion ' .
            '(idSoluciones=' . $this->getIdSolucion() . ', ' .
            'descripcion="' . $this->getDescription() . '", ' .
            'correcta=' . (int) $this->isCorrecta() . ', ' .
            'cuestionesIdcuestion=' . (int)$this->getIdCuestion() . ', ' .
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
            'soluciones' => [
                'idSoluciones' => $this->getIdSolucion(),
                'descripcion' => $this->getDescription(),
                'correcta' => $this->isCorrecta(),
                'cuestionesIdcuestion' => $this->getIdCuestion(),
            ]
        ];
    }

}
/**
 * Solution definition
 *
 * @OA\Schema(
 *     schema = "Solution",
 *     type   = "object",
 *     required = { "descripcion","cuestionesIdcuestion" },
 *     
 *      @OA\Property(
 *          property    = "descripcion",
 *          description = "Soluciones description",
 *          type        = "string"
 *      ),
 *      @OA\Property(
 *          property    = "correcta",
 *          description = "Denotes if solution is correct",
 *          type        = "boolean"
 *      ),
 *      @OA\Property(
 *          property    = "cuestionesIdcuestion",
 *          description = "Solutions parent question",
 *          format      = "int64",
 *          type        = "integer"
 *      ),
 *      
 *      example = {
 *              "descripcion" = "Solution description",
 *              "correcta"  = true,
 *              "cuestionesIdcuestion"              = 7
 *          }
 *     
 * )
 */
/**
 * Soluciones data definition
 *
 * @OA\Schema(
 *      schema          = "SolucionesData",
 *      @OA\Property(
 *          property    = "descripcion",
 *          description = "Soluciones descripcion",
 *          type        = "string"
 *      ),
 *      @OA\Property(
 *          property    = "correcta",
 *          description = "Denotes if solucion is correct",
 *          type        = "boolean"
 *      ),
 *      
 *      
 *      example = {
 *          "descripcion" = "Solucion description",
 *          "correcta"  = true
 *      }
 * )
 */

/**
 * Solution array definition
 *
 * @OA\Schema(
 *     schema           = "SolutionsArray",
 *     @OA\Property(
 *          property    = "soluciones",
 *          description = "Solutions array",
 *          type        = "array",
 *          @OA\Items(
 *              ref     = "#/components/schemas/Solution"
 *          )
 *     )
 * )
 */