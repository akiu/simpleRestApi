<?php

  require_once("vendor/autoload.php");
  $router = new AltoRouter();
  $pdo = new PDO("mysql:host=localhost;dbname=alto", "root", "root");
  $conn = new NotOrm($pdo);
  $match = $router->match();

  $router->map('GET', '/buku', function() use ($router, $conn) {
        $bukus = $conn->buku();
        $data = [];
        foreach($bukus as $buku) {
          $data[] = $buku;
        }
        header("HTTP/1.1 200 Ok");
        echo json_encode($data);
  });

  $router->map('GET', '/buku/[i:id]', function($id) use ($router, $conn) {
        $buku = $conn->buku[$id['id']];
        if($buku) {
          echo json_decode($buku);
          header("HTTP/1.1 200 Ok");

        } else {

          header("HTTP/1.1 404 No Found");
          echo json_encode(['message' => 'Not Found']);
        }

  });

  $router->map('POST', '/buku', function() use ($router, $conn) {
        $data = json_decode($_POST['data']);
        $buku = $conn->buku()->insert(array(
              "name" => $data->nama,
              "price" => $data->price,
              "image" => $data->image,
        ));

        if(!$buku) {
          header("HTTP/1.1 400 Bad Request");
          echo json_encode(['message' => 'Bad Request']);
        } else {

          header("HTTP/1.1 200 Ok");
          echo json_encode(['message' => 'Success']);
        }

  }, 'home1');

  $router->map('PUT', '/buku/[i:id]', function($id) use ($conn) {

      parse_str(file_get_contents("php://input"),$post_vars);
      $data = json_decode($post_vars['data']);
      $arr = get_object_vars($data);
      $uid = $id['id'];
      $res = $conn->buku[$uid];
          if($res) {
              $dat = $res->update($arr);
              header("HTTP/1.1 200 Data Updated");
              echo json_encode(['message' => "Update success"]);
          } else {
              header();
              echo json_encode(['message' => "Record Not Found"]);
          }
  });

  $router->map('DELETE', '/buku/[i:id]', function($id) use ($conn) {
      $uid = $id['id'];
      $res = $conn->buku[$uid];
      if($res) {
        echo json_encode(['message' => "Data Deleted"]);
        $res->delete();
        } else {
        header("HTTP/1.1 404 Not Found");
        echo json_encode(['message' => "No data to be deleted"]);
      }

  });

  $match = $router->match();

  if($match){
      call_user_func($match['target'], $match['params']);
  }else{
    header("HTTP/1.1 404 Not Found");
    require '404.html';
  }



 ?>
