<?php
/**
 * PHP version 7.2
 * apiTDWUsers - src/Controller/RespuestaSolucionController.php
 */

namespace TDW\GCuest\Controller;

use OpenApi\Annotations as OA;
use Psr\Container\ContainerInterface;
use Slim\Http\Request;
use Slim\Http\Response;
use Slim\Http\StatusCode;
use TDW\GCuest\Entity\Usuario;
use TDW\GCuest\Entity\Soluciones;
use TDW\GCuest\Entity\RespuestaSolucion;

use TDW\GCuest\Error;
use TDW\GCuest\Utils;
/**
 * Class RespuestaSolucionController
 */
class RespuestaSolucionController
{
    /** @var string ruta api gestión cuestiones  */
    public const PATH_RESPUESTASOLUCION = '/respuestasolucion';

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
     * Summary: Returns a respuestaSolucion based on a single user ID
     *
     * @OA\Get(
     *     path        = "/respuestasolucion/{userId}",
     *     tags        = { "RespuestaSolucion" },
     *     summary     = "Returns an array of respuestaSoluion based on a single user ID",
     *     description = "Returns the respuestaSolucion identified by `userId`.",
     *     operationId = "tdw_get_respuestaSolucion",

    *      @OA\Parameter(
    *      ref =  "#/components/parameters/userId"),
     *     
     *      security    = {
     *          { "TDWApiSecurity": {} }
     *     },
     *     @OA\Response(
     *          response    = 200,
     *          description = "respuesta solucion ",
     *          @OA\JsonContent(
     *              ref  = "#/components/schemas/RespuestaSolucionArray"
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
     *          response    = 404,
     *          ref         = "#/components/responses/404_Resource_Not_Found_Response"
     *     )
     * )
     * @param Request $request
     * @param Response $response
     * @param array $args
     * @return Response
     */

    public function get(Request $request, Response $response, array $args): Response
    {
        //403
        if (0 === $this->jwt->user_id) {
            
            return Error::error($this->container, $request, $response, StatusCode::HTTP_FORBIDDEN);
        }

        //revisar que exista una solucion para esa cuestion hcha por ese usuario 
        $respuestaSolucion = Utils::getEntityManager()->getRepository(RespuestaSolucion::class)
                ->findBy(['usuariosId'=>$args['idu'] ]);
        
        //aun no responde
        if($respuestaSolucion==null){
            return Error::error($this->container, $request, $response, StatusCode::HTTP_NOT_FOUND);
        }
        $this->logger->info(
            $request->getMethod() . ' ' . $request->getUri()->getPath(),
            [ 'uid' => $this->jwt->user_id, 'status' => StatusCode::HTTP_OK ]
        );

        //200 
        return $response
            ->withJson(
                ['respuestaSolucion' => $respuestaSolucion],
                StatusCode::HTTP_OK // 200
            );
    }
    /**
     * Summary: Creates a new question
     *
     * @OA\Post(
     *     path        = "/respuestasolucion",
     *     tags        = { "RespuestaSolucion" },
     *     summary     = "Creates a new respuesta de solucion",
     *     description = "Creates a new respuesta de solucion",
     *     operationId = "tdw_post_respuestaSolucion",
     *     @OA\RequestBody(
     *         description = "`respuestaSolucion` properties to add to the system",
     *         required    = true,
     *         @OA\JsonContent(
     *             ref = "#/components/schemas/RespuestaSolucionData"
     *         )
     *     ),
     *     security    = {
     *          { "TDWApiSecurity": {} }
     *     },
     *     @OA\Response(
     *          response    = 201,
     *          description = "`Created`: respuestaSolucion created",
     *          @OA\JsonContent(
     *              ref  = "#/components/schemas/RespuestaSolucion"
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
        
        //buscar que no haya una respuesta por ese mismo usuario y para esa misma solucion. 
        $respuestaIgual = $entity_manager-> 
            getRepository(RespuestaSolucion::class)->
            findOneBy(['usuariosId'=>$this->jwt->user_id,'solucionesIdsoluciones'=>$req_data['solucionesIdsoluciones']]);
        
        if($respuestaIgual!=null){
            return Error::error($this->container, $request, $response, StatusCode::HTTP_BAD_REQUEST);
        }
        if(!isset($req_data['respuesta']) || !isset($req_data['solucionesIdsoluciones'])){
            
            return Error::error($this->container, $request, $response, StatusCode::HTTP_BAD_REQUEST);
        }

        //verifico que la solucion existe si no existe tiro 409.
        $solucion = $entity_manager-> 
            getRepository(Soluciones::class)->
            findOneBy(['idSoluciones'=>$req_data['solucionesIdsoluciones']]);
        if($solucion==null){
            return Error::error($this->container, $request, $response, StatusCode::HTTP_CONFLICT);
        }

        $respuesta = new RespuestaSolucion(
            $req_data['respuesta'],
            $req_data['solucionesIdsoluciones'],
            $this->jwt->user_id
        );

        $entity_manager -> persist($respuesta);
        $entity_manager->flush();
        $this->logger->info(
            $request->getMethod() . ' ' . $request->getUri()->getPath(),
            [ 'uid' => $this->jwt->user_id, 'status' => StatusCode::HTTP_CREATED ]
        );

        //201
        return $response->withJson($respuesta, StatusCode::HTTP_CREATED); // 201
    }
}