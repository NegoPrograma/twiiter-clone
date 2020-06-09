<?php


class PictureModel extends Model {

    public function getPictures(){
        $result = array();

        $result = $this->db->query("SELECT * FROM users");
        if($result->rowCount() > 0){
            $result = $result->fetchAll();
        }
        return $result;
    }
}