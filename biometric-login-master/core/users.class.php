
<?php

  class Users extends Dbh {

    public function createUser() {
      if(isset($_POST['createUser'])) {
        $password = $_POST['password'];
        $username = $_POST['username'];
        $dataURL = $_POST['dataURL'];

        $checkUser = $this->checkUser($username);
        
        if(is_bool($checkUser)) {
          
          if($checkUser === FALSE){
            $imageByte = $this->encodeToImage($dataURL);
            $this->convertToImageFile($imageByte, $username);

            try {
              $addUser = $this->connect()->prepare("INSERT INTO `users` (`username`, `password`, `image`) VALUES (?,?,?)");
              $executed = $addUser->execute([$username, $password, "assets/img/".$username.".png"]);
              if($executed) {
                // USER SUCCESSFULLY ADDED
                return json_encode(array('msgType' => 'success', 'msgBody' => "was added successfully", 'msgHead' => $username));
              } else {
                // FAILED TO ADD USER
                return json_encode(array('msgType' => 'warning', 'msgBody' => "was not added, please refresh the page and try again", 'msgHead' => $username));
              }
            } catch (PDOException $th) {
              // PDOException ERROR
              return json_encode(array('msgType' => 'error', 'msgBody' => $th->getMessage(), 'msgHead' => 'Fatal Error'));
            }
          } else {
            // USERNAME ALREADY EXIST
            return json_encode(array('msgType' => 'warning', 'msgBody' => "already exists", 'msgHead' => $username));
          }
        } else {
          // PDOException FROM checkUser() FUNCTION
          return json_encode(array('msgType' => 'error', 'msgBody' => $checkUser, 'msgHead' => 'Fatal Error'));
        }
      }
    }





    public function loginByFace() {
      if(isset($_POST['logUser'])) {
        $username = $_POST['username'];
        $dataURL = $_POST['dataURL'];
        $canvasImage = $this->encodeToImage($dataURL);
        $fileImage = file_get_contents("../assets/img/".$username.".png");

        $checkUser = $this->checkUser($username);

        if(is_bool($checkUser)) {
          if($checkUser === TRUE) {
            $comparedFace = $this->compareImage($fileImage, $canvasImage);

            if(is_bool($comparedFace)) {
              if($comparedFace === TRUE) {
                return json_encode(array('msgType' => 'success', 'msgBody' => "Match found", 'msgHead' => $username));
                $this->redirectTo('dashboard');
              } else {
                // FACE DON'T MATCH
                return json_encode(array('msgType' => 'error', 'msgBody' => "unrecognised face detected", 'msgHead' => 'No Match'));
              }
            } else {
              // PDOException FROM compareImage() FUNCTION
              return json_encode(array('msgType' => 'error', 'msgBody' => $comparedFace, 'msgHead' => 'Fatal Error'));
            }
          } else {
            // USERNAME DOESN'T EXIST
            return json_encode(array('msgType' => 'error', 'msgBody' => "doesn't exist", 'msgHead' => $username));
          }
        } else {
          // PDOException FROM checkUser() FUNCTION
          return json_encode(array('msgType' => 'error', 'msgBody' => $checkUser, 'msgHead' => 'Fatal Error'));
        }
      }
    }
    




    private function compareImage($fileImage, $canvasImage) {
      try {
        $compare = $this->rekognition()->compareFaces([
          'SimilarityThreshold' => 90,
          'SourceImage' => [
              'Bytes' => $canvasImage,
          ],
          'TargetImage' => [
              'Bytes' => $fileImage,
          ],
        ]);
    
        $results =  $compare['FaceMatches'];
        foreach ($results as $result) {
          $similarity = $result['Similarity'];
        }
    
        if (count($results) == 1) {
          if ($similarity >= 90) {
            // FACE MATCH
            return TRUE;
          } else {
            // FACE DON'T MATCH
            return FALSE;
          }
        } else {
          return "Too many faces detected";
        }
      } catch (Aws\Exception\AwsException $th) {
        return $th->getMessage();
      }
    }



    
    private function checkUser($username) {
      try {
        $sql = $this->connect()->prepare("SELECT * FROM `users` WHERE `username` = ?");
        $sql->execute([$username]);
        if($sql->rowCount() > 0) {
          return TRUE;
        } else {
          return FALSE;
        }
      } catch (PDOException $pe) {
        return $pe->getMessage();
      }
    }




    private function encodeToImage($imageByte) {
      $uri = str_replace('data:image/png;base64,', '', $imageByte);
      // $uri = substr($imageByte, strpos($imageByte, ','), 1);
      $fileByte = base64_decode($uri);
      return $fileByte;
    }
  



    private function convertToImageFile($encodedURL, $filename) {
      // file_put_contents($filePath, base64_decode($uri));
      if($imageFile = fopen("./assets/img/" . $filename . ".png", "w")){
        fwrite($imageFile, $encodedURL);
        fclose($imageFile);
        return TRUE;
      } else {
        return FALSE;
      }
    }
    
    
  }
  
