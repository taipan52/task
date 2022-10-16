<?

namespace Task\Api;

require_once 'base/DB.php';
require_once 'models/TableAbstract.php';
require_once 'models/ActionInterface.php';
require_once 'models/SessionSubscribe.php';

/**
 * Route class 
 *
 * Класс маршрутизации
 * 
 * @author  Taipan <beetle52net@gmail.com>
 * @since   2022-10-16
 */
class Route {

    private $method = '';
    private $path = '';

    private $action = '';
    private $params = [];

    function __construct() {

        $this->method = $_SERVER['REQUEST_METHOD'];

        $ar_url = parse_url($_SERVER['REQUEST_URI']);
        $this->path = $ar_url['path'];

        $ar_path = explode('/', $this->path);
        //наименование обработчика
        $this->action = $ar_path[2];

        $this->getDataRequest();

    }

    public function getMethod(){
        return $this->method;
    }

    public function getAction(){
        return $this->action;
    }

    public function getParams(){
        return $this->params;
    }

	/**
	 * Получение экземпляра обработчика
     * 
	 * @return object
	 */
    public function getHandler() {

        try {
            
            if($this->action === '') throw new RouteException('Empty action', 500);

            $class = __NAMESPACE__."\\".$this->action;

            if( class_exists($class) ) {

                return new $class( $this->params );
            }
            else {
                throw new RouteException('Missing action', 404);
            }


        } catch (RouteException $e) {

            $this->responce(
                $e->getCode(), 
                $e->getMessage()
            );

        }
        
        
    }


	/**
	 * Получение параметров запроса
     * 
	 */
    private function getDataRequest() {

        if ($this->method === 'POST' && !empty($_POST)) {

            $this->params = filter_input_array(INPUT_POST, FILTER_DEFAULT);

        }

    }

	/**
	 * Отображение ответа
     * 
     * @param int $code
     * @param string $mess
     * @param array $responce
	 * @return void
	 */
    public function responce($code = 200, $mess = '', $data = array()) {

        $status = $code === 200 ? 'ok' : 'error';
        $res = array(
            'status' => $status,
        );
        if($mess) $res['message'] = $mess;
        if($data) $res['payload'] = $data;

        header('HTTP/1.1 '.$code.' '.$mess);
        die( json_encode($res, JSON_UNESCAPED_UNICODE) );

    }


}


class RouteException extends \Exception {}