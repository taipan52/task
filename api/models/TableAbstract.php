<?php

namespace Task\Api;

require_once 'News.php';
require_once 'Session.php';

/**
 * TableAbstract class 
 * 
 * @author  Taipan <beetle52net@gmail.com>
 * @since   2022-10-16
 */
abstract class TableAbstract {

    private $table_name;
    private $result;

    public $last_error;

    public function setTable($table_name) {
        $this->table_name = $table_name;
    }

    public function setResult($result) {
        $this->result = $result;
    }

    public function getResult() {
        if(!$this->result) return array();
        return $this->result;
    }

    public function getTableName() {
        return $this->table_name;
    }

    /**
     * Получить весь список
     * 
     * @return array $list
     */
    public function getList() {
        return $this->custom('SELECT * FROM '.$this->table_name);
    }


    /**
     * Получить элемент по ID
     * 
     * @param int $id 
     * @return array $elem
     */
    public function getById($id) {

        $id = intval($id);
        return $this->custom('SELECT * FROM '.$this->table_name.' WHERE ID='.$id);

    }


    /**
     * Кастомный запрос
     * 
     * @return array $list
     */
    public function custom($sql) {

        $db = new DB();
        $list = $db->makeQuery($sql);

        if($db->last_error) {
            $this->last_error = 'DataBase connection error';
            $list = [];
        }

        if(empty($list)) {
            //$this->last_error = 'No result';
            //$list = []; 
        }

        return $list;

    }

    /**
     * Текстовый ответ
     * 
     * @return string
     */
    public function getMessage(){
        return '';
    }


}