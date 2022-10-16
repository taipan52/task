<?

namespace Task\Api;

/**
 * SessionSubscribe class 
 *
 */
class SessionSubscribe implements ActionInterface {

    private $sessionId;
    private $userEmail;

    private $checked = false;
    private $message = '';

    function __construct($params = []) {

        if(isset($params['sessionId']) && isset($params['userEmail'])) {

            $this->sessionId = intval($params['sessionId']);
            $this->userEmail = htmlspecialchars ($params['userEmail']);

            $this->do();

        }

    }


    /**
     * Проведение операции   
     * 
     */
    private function do(){
        
        $db = new DB();
        $conn = $db->getInstance();

        try {

            $conn->beginTransaction();

            //наличие пользователя
            $user_sql = 'SELECT ID FROM participant p WHERE p.Email="'.$this->userEmail.'"';
            $user = $db->makeQuery($user_sql);

            //наличие свободного места в сессии
            $session_sql = 
            'SELECT 
                count(r.participant_id) AS `count`,
                s.participant_limit	AS `limit`
            FROM session s
                LEFT JOIN  session_participant r ON s.ID=r.session_id 
                LEFT JOIN participant p ON s.ID=r.participant_id
                WHERE s.ID='.$this->sessionId;
            $session = $db->makeQuery($session_sql);

            if(!empty($user) && ( $session[0]['limit'] > $session[0]['count'] ) ) {

                $this->checked = true;

                $write = $conn->exec(
                    'INSERT INTO 
                    session_participant 
                    (session_id, participant_id) 
                    VALUES ('.$this->sessionId.', '.$user[0]['ID'].')'
                );

                if($write) {
                    $this->message = 'Спасибо, вы успешно записаны!';
                }

            }
            else {
                $this->message = 'Извините, все места заняты';
            }

            $conn->commit();

        } catch (\PDOException $e) {
            
            $conn->rollBack();
            //echo $e->getMessage();
            $this->message = 'Вы уже записаны на данную сессию';

        }



    }

    /**
     * Получение результата
     * 
     * @return bool
     */
    public function getResult(){
        return [];
    }

    /**
     * Текстовый ответ
     * 
     * @return string
     */
    public function getMessage(){
        return $this->message;
    }


}