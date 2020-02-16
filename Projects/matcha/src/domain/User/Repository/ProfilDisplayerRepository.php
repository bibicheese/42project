<?php

namespace Src\Domain\User\Repository;

use Src\Domain\User\Data\UserData;
use PDO;

class ProfilDisplayerRepository
{
    private $connection;

    public function __construct(PDO $connection) {
      $this->connection = $connection;
    }

    public function displayer($user, $currId) {
      $sql = "SELECT latitude, longitude FROM users WHERE
      id = '$currId'";
      $ret = $this->connection->query($sql)->fetch(PDO::FETCH_ASSOC);
      $latFrom = $ret['latitude'];
      $lonFrom = $ret['longitude'];
      
      
      $login = $user->login;
      $row = [
        'login' => $login
      ];
      $sql = "SELECT * FROM users WHERE
      login=:login;";
      $ret = $this->connection->prepare($sql);
      $ret->execute($row);
      if (! $dataUser = $ret->fetch(PDO::FETCH_ASSOC))
        return [
          'status' => 0,
          'error' => 'user do not exist'
        ];
      
      $gender = $dataUser['gender'];
      $id = $dataUser['id'];
      $latTo = $dataUser['latitude'];
      $lonTo = $dataUser['longitude'];
      
      $this->addViews($id, $currId);
      
      $sql = "SELECT * FROM likes WHERE
      liker = '$currId'
      AND
      liked = '$id'";
      $myLikeTo = $this->connection->query($sql)->fetch(PDO::FETCH_ASSOC);
      
      $sql = "SELECT * FROM likes WHERE
      liker = '$id'
      AND
      liked = '$currId'";
      $likedBy = $this->connection->query($sql)->fetch(PDO::FETCH_ASSOC);
      
      if ($likedBy && $myLikeTo)
        $match = 1;
      
      $sql = "SELECT link FROM images WHERE
      userid = '$id'
      AND
      profil = '1'";
      if (! $profilPic = $this->connection->query($sql)->fetch(PDO::FETCH_ASSOC)) {
          if ($gender == 'Male')
            $profilPic = "/img/male.jpg";
          elseif ($gender == 'Female')
            $profilPic = "/img/female.jpg";
      }
      else
        $profilPic = $profilPic['link'];
      $sql = "SELECT link FROM images WHERE
      userid = '$id'
      AND
      profil = '0'";
      if (! $images = $this->connection->query($sql)->fetchAll(PDO::FETCH_ASSOC))
        $images = [];
      
      $sql = "SELECT tag FROM tags WHERE
      userids REGEXP '(,|^)$id(,|$)'";
      $tags_db = $this->connection->query($sql)->fetchAll(PDO::FETCH_ASSOC);
      
      $j = count($tags_db);
      while ($j-- != 0)
        $tags = !$tags ? $tags_db[$j]['tag'] : $tags . "," . $tags_db[$j]['tag'];
  
      $tags = explode(',', $tags);
      return [
        'status' => 1,
        'success' => [
          'firstname' => $dataUser['firstname'],
          'lastname' => $dataUser['lastname'],
          'birth' => $dataUser['birth'],
          'age' => (int)$dataUser['age'],
          'gender' => $dataUser['gender'],
          'orientation' => $dataUser['orientation'],
          'bio' => $dataUser['bio'],
          'score' => (int)$dataUser['score'],
          'login' => $dataUser['login'],
          'profilePic' => $profilPic,
          'myLikeTo' => $myLikeTo ? 1 : 0,
          'likedBy' => $likedBy ? 1 : 0,
          'match' => $match ? 1 : 0,
          'images' => $images,
          'city' => $dataUser['city'],
          'arr' => $dataUser['arr'],
          'dst' => $this->getDistance($latFrom, $lonFrom, $latTo, $lonTo),
          'log' => $dataUser['token_log'] ? 1 : 0,
          'tags' => $tags
        ]
      ];

    }

    private function addViews($idVisited, $currId) {
      if ($idVisited != $currId) {
        $sql = "SELECT * FROM viewers WHERE
        visitor = '$currId'
        AND
        host = '$idVisited'";
        $ret = $this->connection->query($sql)->fetch(PDO::FETCH_ASSOC);
    
        if (!$ret) {
          $sql = "UPDATE users SET 
          score = score + 2
          WHERE
          id = '$idVisited'
          AND
          score < 100";
          $this->connection->query($sql);
        
          $sql = "UPDATE users SET
          score = score - 1
          WHERE
          id = '$currId'
          AND
          score > 0";
          $this->connection->query($sql);
        }
        
        $sql = "INSERT INTO viewers SET
        visitor = '$currId',
        host = '$idVisited'";
        $this->connection->query($sql);
      }
    }
    
    private function getDistance($latFrom, $lonFrom, $latTo, $lonTo) {
        $degrees = rad2deg(acos((sin(deg2rad($latFrom))*sin(deg2rad($latTo))) + (cos(deg2rad($latFrom))*cos(deg2rad($latTo))*cos(deg2rad($lonFrom-$lonTo)))));
        $distance = $degrees * 111.13384;

        return round($distance, $decimals);    
    }
}
