<?php
/**
 * PHP version 7.2
 * apiTDWUsers - src/Controller/PropuestaSolucionController.php
 */

namespace TDW\GCuest\Controller;

use OpenApi\Annotations as OA;
use Psr\Container\ContainerInterface;
use Slim\Http\Request;
use Slim\Http\Response;
use Slim\Http\StatusCode;
use TDW\GCuest\Entity\Usuario;
use TDW\GCuest\Entity\Soluciones;
use TDW\GCuest\Entity\PropuestaSolucion;

use TDW\GCuest\Error;
use TDW\GCuest\Utils;

/**
 * Class PropuestaSolucionController
 */
class PropuestaSolucionController
{
    /** @var string ruta api gestión cuestiones  */
    public const PATH_USUARIOS = '/propuestasolucion';

    /** @var ContainerInterface $container */
    protected $container;

    /** @var \Firebase\JWT\JWT */
    protected $jwt;

    /** @var \Monolog\Logger $logger */
    protected $logger;

    // constructor receives container instance
    public function __construct(ContainerInterface $container)
    {
        $this->container = $container;
        $this->jwt = $this->container->get('jwt');
        $this->logger = $this->container->get('logger');
    }
    /**
     * Summary: Creates a new question
     *
     * @OA\Post(
     *     path        = "/propuestasolucion",
     *     tags        = { "PropuestaSolucion" },
     *     summary     = "Creates a new propuesta de solucion",
     *     description = "Creates a new propuesta de solucion",
     *     operationId = "tdw_post_propuestaSolucion",
     *     @OA\RequestBody(
     *         description = "`PropuestaSolucion` properties to add to the system",
     *         required    = true,
     *         @OA\JsonContent(
     *             ref = "#/components/schemas/PropuestaSolucionData"
     *         )
     *     ),
     *     security    = {
     *          { "TDWApiSecurity": {} }
     *     },
     *     @OA\Response(
     *          response    = 201,
     *          description = "`Created`: propuestaSolucion created",
     *          @OA\JsonContent(
     *              ref  = "#/components/schemas/PropuestaSolucion"
     *         )
     *     ),
     *      * @OA\Response(
     *          response    = 400,
     *          description = "`Bad Request`:insert valid data",
     *          @OA\JsonContent(
     *              ref ="#/components/schemas/Message",
     *              example = {
     *                  "code"    = 400,
     *                  "message" = "`Bad Request`: insert valid data"
     *              }
     *         )
     *     ),
     *     @OA\Response(
     *          response    = 401,
     *          ref         = "#/components/responses/401_Standard_Response"
     *     ),
     *     @OA\Response(
     *          response    = 403,
     *          ref         = "#/components/responses/403_Forbidden_Response"
     *     ),
     *     @OA\Response(
     *          response    = 409,
     *          description = "`Conflict`: solucionesIdsoluciones does not exist.",
     *          @OA\JsonContent(
     *              ref  = "#/components/schemas/Message",
     *              example          = {
     *                   "code"      = 409,
     *                   "message"   = "`Conflict`: solucionesIdsoluciones does not exist."
     *              }
     *         )
     * )
     * )
     * @param Request $request
     * @param Response $response
     * @return Response
     */
    public function post(Request $request, Response $response): Response
    {
        if ($this->jwt->isMaestro) {
            
            
            return Error::error($this->container, $request, $response, StatusCode::HTTP_FORBIDDEN);
        }
        $req_data = $request ->getParsedBody() ?? json_decode($request->getBody(),true);
        $entity_manager = Utils::getEntityManager();
        
        //buscar que no haya una propuesta por ese mismo usuario y para esa misma solucion. 
        $propuestaIgual = $entity_manager-> 
            getRepository(PropuestaSolucion::class)->
            findOneBy(['usuariosId'=>$this->jwt->user_id,'solucionesIdsoluciones'=>$req_data['solucionesIdsoluciones']]);
        
        if($propuestaIgual!=null){
            return Error::error($this->container, $request, $response, StatusCode::HTTP_BAD_REQUEST);
        }
        if(!isset($req_data['descripcion']) || !isset($req_data['solucionesIdsoluciones'])){
            
            return Error::error($this->container, $request, $response, StatusCode::HTTP_BAD_REQUEST);
        }

        //verifico que la solucion existe si no existe tiro 409.
        $solucion = $entity_manager-> 
            getRepository(Soluciones::class)->
            findOneBy(['idSoluciones'=>$req_data['solucionesIdsoluciones']]);
        if($solucion==null){
            return Error::error($this->container, $request, $response, StatusCode::HTTP_CONFLICT);
        }

        $propuesta = new PropuestaSolucion(
            $req_data['descripcion'],
            $req_data['solucionesIdsoluciones'],
            $this->jwt->user_id
        );

        $entity_manager -> persist($propuesta);
        $entity_manager->flush();
        $this->logger->info(
            $request->getMethod() . ' ' . $request->getUri()->getPath(),
            [ 'uid' => $this->jwt->user_id, 'status' => StatusCode::HTTP_CREATED ]
        );

        //201
        return $response->withJson($propuesta, StatusCode::HTTP_CREATED); // 201
    }
}