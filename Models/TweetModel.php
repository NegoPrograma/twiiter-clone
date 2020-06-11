<?php 

class TweetModel extends Model {



    public function __construct(){
		parent::__construct();//necessário pois se você define um padrão de construtor aqui, ele passa a ignorar o construtor de model, pois ocorre uma sobreescrita
    }
    
    public function postTweet($text,$user_id){
        $stmt = "INSERT INTO tweets (user_id,tweet,post_time)
                VALUES ({$user_id},'{$text}',NOW())";
        $sql = $this->db->query($stmt);
    }

    public function getTweets($users,$limit){
      $users = implode(",",$users);
      $stmt = "SELECT *,(SELECT name FROM users WHERE users.id = tweets.user_id) AS name FROM tweets WHERE user_id IN ({$users}) ORDER BY post_time DESC LIMIT {$limit}";
      $sql = $this->db->query($stmt)->fetchAll();
      return $sql;
    }
}

?>