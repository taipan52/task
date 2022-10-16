<?php

namespace Task\Api;
use \Task\Api\TableAbstract;

/**
 * Session class 
 *
 */
class Session extends TableAbstract {

    function __construct($params = []) {

        $this->setTable('session');

        if(isset($params['id']) && intval( $params['id'] ) > 0) {
            //запрос по id
            $res = $this->getById( intval( $params['id'] ) );
            $this->setResult( $this->structured($res) );
        }
        else {

            //запрос без параметров
            $res = $this->getList();
            $this->setResult( $this->structured($res) );
        }

    }


    /**
     * Получить весь список
     * 
     * @return array $list
     */
    public function getList() {
        return $this->custom(
        'SELECT 
            t.ID,
            t.Name,
            t.TimeOfEvent,
            t.Description,
            s.ID AS speaker_id,
            s.Name AS speaker_name
        FROM '.$this->getTableName().' t 
            LEFT JOIN  session_speaker r ON t.ID=r.session_id 
            LEFT JOIN speaker s ON s.ID=r.speaker_id');
    }


    /**
     * Получить элемент по ID
     * 
     * @param int $id 
     * @return array $elem
     */
    public function getById($id) {
        $sql = 
        'SELECT 
            t.ID,
            t.Name,
            t.TimeOfEvent,
            t.Description,
            s.ID AS speaker_id,
            s.Name AS speaker_name
        FROM '.$this->getTableName().' t 
            LEFT JOIN  session_speaker r ON t.ID=r.session_id 
            LEFT JOIN speaker s ON s.ID=r.speaker_id WHERE t.ID='.$id;

        return $this->custom($sql);

    }


    private function structured($res){

        $key = 0;
        foreach ($res as $line) {

            if($line['ID'] === $key) {
                $list[ $line['ID'] ]['Speakers'][] = array(
                    'id' => $line['speaker_id'],
                    'name' => $line['speaker_name'],
                ); 
            }
            else {

                $item = array(
                    'ID' => $line['ID'],
                    'Name' => $line['Name'],
                    'TimeOfEvent' => $line['TimeOfEvent'],
                    'Description' => $line['Description'],
                    'Speakers' => array(),
                );

                if($line['speaker_id']) {
                    $item['Speakers'] = array(
                        'id' => $line['speaker_id'],
                        'name' => $line['speaker_name']
                    );
                }

                $list[ $line['ID'] ] = $item; 
            }

            $key = $line['ID'];
            unset($item);
        }

        return $list;

    }

}