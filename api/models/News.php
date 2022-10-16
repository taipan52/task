<?

namespace Task\Api;
use \Task\Api\TableAbstract;

/**
 * News class 
 *
 */
class News extends TableAbstract {

    function __construct($params = []) {

        $this->setTable('news');

        if(isset($params['id']) && intval( $params['id'] ) > 0) {
            //запрос по id
            $this->setResult( $this->getById( intval( $params['id'] ) ) );
        }
        else {
            //запрос без параметров
            $this->setResult( $this->getList() );   
        }

    }

}