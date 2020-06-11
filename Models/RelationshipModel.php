<?php 

class RelationshipModel extends Model{


    public function __construct(){
        parent::__construct();
    }

    public function follow($id_follower,$id_followed){
        $stmt = "INSERT INTO relationships SET id_follower = {$id_follower}, id_followed = {$id_followed}";
        $sql = $this->db->query($stmt);
    }

    public function unfollow($id_follower,$id_followed){
        $stmt = "DELETE * FROM relationships WHERE id_follower = {$id_follower} AND id_followed = {$id_followed}";
        $sql = $this->db->query($stmt);
    }
}

?>