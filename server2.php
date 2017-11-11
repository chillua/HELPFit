<?php
  session_start();

  $db = mysqli_connect('localhost','root','','helpfit');

  function mysqli_query_or_die($query) {
    global $db;
      $result = mysqli_query($db, $query);
      if ($result)
          return $result;
      else {
          $err = mysqli_error($db);
          die("<br>{$query}<br>*** {$err} ***<br>");
      }
  }
  function printSessions(){
    $query = "SELECT * FROM trainingsession ORDER BY trainingsession.training_type, trainingsession.date, trainingsession.time ASC";
    $result = mysqli_query_or_die($query);
    $first_row = true;
    $none_available = true;
    if(isset($_SESSION['type'])){
      echo '<div class="training-container">';
      while ($row = mysqli_fetch_assoc($result)) {
        $sessionID = $row['sessionID'];
        $member_id = $_SESSION['user']['user_id'];
        //checks if session has already expired(completed) or not
        $date = strtotime($row['date']);
        if (($date < strtotime(date("Y-m-d")))||($row['status'] == "completed")){
            if ($row['status'] != "completed"){
            $query = "UPDATE trainingsession SET status = 'completed' WHERE sessionID = '$sessionID'";
            mysqli_query_or_die($query);
          }
        }

        //checks if member have already joined the training session
        $joined = mysqli_query_or_die("SELECT * FROM membersession WHERE sessionID='$sessionID' AND member_id='$member_id'");
        if ($row['status'] == "available" && mysqli_num_rows($joined) == 0){
          //get the trainer
          $trainer_id = $row['trainer_id'];
          $ses_trn = mysqli_query_or_die("SELECT * FROM user WHERE user_id='$trainer_id'");
          $trainer_user = mysqli_fetch_assoc($ses_trn);
          $ses_trn = mysqli_query_or_die("SELECT * FROM trainer WHERE user_id='$trainer_id'");
          $trainer = mysqli_fetch_assoc($ses_trn);

          if($row['training_type'] == $_SESSION['type'])
          {
            $none_available = false;
            //get the personal or group session attributes
            if ($row['training_type'] == "personal"){
              $ses_p = mysqli_query_or_die("SELECT * FROM personaltraining WHERE sessionID='$sessionID'");
              $personal = mysqli_fetch_assoc($ses_p);
            }else if ($row['training_type'] == "group"){
              $ses_g = mysqli_query_or_die("SELECT * FROM grouptraining WHERE sessionID='$sessionID'");
              $group = mysqli_fetch_assoc($ses_g);
            }

            if ($first_row) {
                $first_row = false;
            }
            $dateDM = DateTime::createFromFormat('Y-m-d', $row['date'])->format('M d');
            $dateY = DateTime::createFromFormat('Y-m-d', $row['date'])->format('Y');
            $time = DateTime::createFromFormat('H:i:s', $row['time'])->format('h:i a');
            //for desktop and tablet
            echo '<div class="panel panel-default">
              <div class="container-fluid">
                <div class="col-xs-2 date-time">
                  <h3>'.$dateDM.'</h3>
                  <h4 class="year">'.$dateY.'</h4>
                  <h4 class="time">'.$time.'</h4>
                </div>
                <div class="col-xs-5 title-class ';
                if(isset($group)){
                  echo 'title-group';
                }
                if (isset($personal)){
                  echo 'title-personal';
                }

            echo '">
                  <p> SESSION ID: #'.$row['sessionID'].'</p>
                  <h2 title="'.$row['title'].'">'.$row['title'].'</h2>';
            if(isset($group)){
              //count how many members have participated in the group training
              $cquery = mysqli_query_or_die("SELECT count(*) AS total FROM membersession WHERE sessionID = '$sessionID'");
              $data = mysqli_fetch_assoc($cquery);
              $no_pax = $data['total'];
              echo '<h3>Type: '.$group['class_type'].'</h3>';
              echo '<p class="par_label">Participants </p>
                    <p class="par">'.$no_pax.'/'.$group['max_pax'].'</p>';
            }
            if (isset($personal)){
              echo '<h3 class="notes">';
              if (empty($personal['notes'])){
                echo 'NOTES: N/A';
              }else{
                echo 'NOTES: '.$personal['notes'];
              }
              echo '</h3>';
            }

            //calculate trainer's average rating
            $trainer_id = $trainer_user['user_id'];
            $query = mysqli_query_or_die("SELECT avg(rating) AS avg_rating FROM review WHERE trainer_id = '$trainer_id'");
            $data = mysqli_fetch_assoc($query);
            $avg_rating = round($data['avg_rating'],2);
            echo '</div>
                <div class="col-xs-3 trainer-rate">
                  <p>BY TRAINER</p>
                  <h3 title="'.$trainer_user['name'].'">'.$trainer_user['name'].'</h3>
                  <h4 title="'.$trainer['specialty'].'">Specialty: '.$trainer['specialty'].'</h4>
                  <span class="stars" data-rating="'.$avg_rating.'" data-num-stars="5" ></span>
                </div>
                <div class="col-xs-2 join-div">
                <label class="radio">
                    <input type="radio" name="join" class="btn join_btn" value="'.$sessionID.'">
                    <div class="btn"><p>
                      <strong>JOIN</strong><br />
                      RM'.$row['fee'].'</p>
                    </div>
                  </label>
                </div>
              </div>
            </div>';

            //for mobile
            echo '<div class="panel mobile-panel">
              <div class="container-fluid">
                <div class="col-xs-6 col-mobile">
                  <p class="sid"> #'.$row['sessionID'].'</p>
                  <p class="title">'.$row['title'].'</p>
                  <p class="notes-type">';
              if(isset($group)){
                echo '<b>Type:</b> '.$group['class_type'].'</p>';
                echo '<p class="mob_par"><b>Participants:</b> '.$no_pax.'/'.$group['max_pax'].'</p>';
                unset($group);
              }
              if (isset($personal)){
                echo '<div class="notes-div">';
                if (empty($personal['notes'])){
                  echo '<b>Notes:</b> N/A';
                }else{
                  echo '<b>Notes:</b> '.$personal['notes'];
                }
                echo '</div></p>';
                unset($personal);
              }
              echo '<p class="fee">RM'.$row['fee'].'</p>
              <p class="date-time">'.$dateDM.','.$dateY.' '.$time.'</p>
              </div>
              <div class="col-xs-6 col-join-mobile">
                <p class="label">Trainer: </p> <br>'.$trainer_user['name'].'</p>
                <p class="label">Specialty: </p> <br>'.$trainer['specialty'].'</p>
                <div class="stars-div"><span class="stars" data-rating="'.$avg_rating.'" data-num-stars="5"></span></div>
                <div class="col-xs-12 join-mobile">
                <label class="radio">
                    <input type="radio" name="join" class="btn join_btn_mobile" value="'.$sessionID.'">
                    <div class="btn"><strong>JOIN</strong>
                    </div>
                  </label>
                </div>
              </div>
              </div>
            </div>';
          }
        }
      }// end while loop
      if ($none_available){
        echo '<div style="text-align:center"><h3 style="margin:90px 30px 90px 30px;color:#fff;">
        Sorry! There are no '.$_SESSION['type'].' training sessions currently available.
        </h3></div>';
      }
        echo '</div>';
        unset($_SESSION['type']);
    }//end if training type
  }

  //join session
  if (isset($_POST['join'])){
    $sessionID = $_POST['join'];
    $member_id = $_SESSION['user']['user_id'];
    $query = "INSERT INTO membersession (member_id, sessionID)
				  VALUES('$member_id','$sessionID')";
		mysqli_query($db, $query);
    $ses = mysqli_query_or_die("SELECT * FROM trainingsession WHERE sessionID='$sessionID'");
    $ses = mysqli_fetch_assoc($ses);
    if ($ses['training_type'] == "personal"){
      $query = "UPDATE trainingsession SET status = 'full' WHERE sessionID = '$sessionID'";
      mysqli_query($db, $query);
    }else{
      $ses_g = mysqli_query_or_die("SELECT * FROM grouptraining WHERE sessionID='$sessionID'");
      $group = mysqli_fetch_assoc($ses_g);
      $result = mysqli_query_or_die("SELECT count(*) AS total FROM membersession WHERE sessionID = '$sessionID'");
      $data = mysqli_fetch_assoc($result);
      $no_pax = $data['total'];
      if ($no_pax >= $group['max_pax']){
        $query = "UPDATE trainingsession SET status = 'full' WHERE sessionID = '$sessionID'";
        mysqli_query($db, $query);
      }
    }
    $_SESSION['success_join'] = "You have successfully joined!";
		header('location: #');
    exit();
  }


// print session history
  function printHistory(){
    $member_id = $_SESSION['user']['user_id'];
    $result = mysqli_query_or_die("SELECT * FROM membersession JOIN trainingsession ON membersession.sessionID=trainingsession.sessionID WHERE member_id='$member_id' ORDER BY trainingsession.date, trainingsession.time ASC");
    $none_available = true;
    if(isset($_SESSION['type'])){
      echo '<div class="training-container">';
      while ($row = mysqli_fetch_assoc($result)) {
        $sessionID = $row['sessionID'];
        //get the trainer
        $trainer_id = $row['trainer_id'];
        $ses_trn = mysqli_query_or_die("SELECT * FROM user WHERE user_id='$trainer_id'");
        $trainer_user = mysqli_fetch_assoc($ses_trn);
        $ses_trn = mysqli_query_or_die("SELECT * FROM trainer WHERE user_id='$trainer_id'");
        $trainer = mysqli_fetch_assoc($ses_trn);

        //checks if session has expired(completed) or not
        $date = strtotime($row['date']);
        if (($date < strtotime(date("Y-m-d")))||($row['status'] == "completed")){
           $status_type = "completed";
           if ($row['status'] != "completed"){
             $query = "UPDATE trainingsession SET status = 'completed' WHERE sessionID = '$sessionID'";
             mysqli_query_or_die($query);
           }
        }else {
          $status_type = "upcoming";
        }

        if($status_type == $_SESSION['type'])
        {
          $none_available = false;
          //get the personal or group session attributes
          if ($row['training_type'] == "personal"){
            $ses_p = mysqli_query_or_die("SELECT * FROM personaltraining WHERE sessionID='$sessionID'");
            $personal = mysqli_fetch_assoc($ses_p);
          }else if ($row['training_type'] == "group"){
            $ses_g = mysqli_query_or_die("SELECT * FROM grouptraining WHERE sessionID='$sessionID'");
            $group = mysqli_fetch_assoc($ses_g);
          }

          $dateDM = DateTime::createFromFormat('Y-m-d', $row['date'])->format('M d');
          $dateY = DateTime::createFromFormat('Y-m-d', $row['date'])->format('Y');
          $time = DateTime::createFromFormat('H:i:s', $row['time'])->format('h:i a');
          //for desktop and tablet
          echo '<div class="panel panel-default">
            <div class="container-fluid">
              <div class="col-xs-2 date-time">
                <h3>'.$dateDM.'</h3>
                <h4 class="year">'.$dateY.'</h4>
                <h4 class="time">'.$time.'</h4>
              </div>
              <div class="col-xs-5 title-class ';
              if(isset($group)){
                echo 'title-group';
              }
              if (isset($personal)){
                echo 'title-personal';
              }

          echo '">
                <p> SESSION ID: #'.$row['sessionID'].'</p>
                <h2 title="'.$row['title'].'">'.$row['title'].'</h2>';
          if(isset($group)){
            //count how many members have participated in the group training
            $cquery = mysqli_query_or_die("SELECT count(*) AS total FROM membersession WHERE sessionID = '$sessionID'");
            $data = mysqli_fetch_assoc($cquery);
            $no_pax = $data['total'];
            echo '<h3>Type: '.$group['class_type'].'</h3>';
            echo '<p class="par_label">Participants </p>
                  <p class="par">'.$no_pax.'/'.$group['max_pax'].'</p>';
          }
          if (isset($personal)){
            echo '<h3 class="notes">';
            if (empty($personal['notes'])){
              echo 'NOTES: N/A';
            }else{
              echo 'NOTES: '.$personal['notes'];
            }
            echo '</h3>';
          }
          //calculate trainer's average rating
          $trainer_id = $trainer_user['user_id'];
          $query = mysqli_query_or_die("SELECT avg(rating) AS avg_rating FROM review WHERE trainer_id = '$trainer_id'");
          $data = mysqli_fetch_assoc($query);
          $avg_rating = round($data['avg_rating'],2);
          echo '</div>
              <div class="col-xs-3 trainer-rate">
                <p>BY TRAINER</p>
                <h3 title="'.$trainer_user['name'].'">'.$trainer_user['name'].'</h3>
                <h4 title="'.$trainer['specialty'].'">Specialty: '.$trainer['specialty'].'</h4>
                <span class="stars" data-rating="'.$avg_rating.'" data-num-stars="5" ></span>
              </div>
              <div class="col-xs-2 join-div">
              <label class="radio">';

              //search if user has already reviewed this session
              $reviewed = mysqli_query_or_die("SELECT * FROM review WHERE sessionID='$sessionID' AND member_id='$member_id'");
              if ($status_type == "completed" && mysqli_num_rows($reviewed) == 1){
                echo '<input type="radio" value="'.$sessionID.' disabled">
                <div class="btn-disabled"><p>
                  <strong>REVIEWED';
              }
              else if ($status_type == "completed"){
                  echo '<input type="radio" name="rate" value="'.$sessionID.'" class="btn join_btn" data-sid="'.$sessionID.'">
                  <div class="btn"><p>
                    <strong>
                    REVIEW<br />TRAINER';
                }
              else{
                echo '<input type="radio" value="'.$sessionID.' disabled">
                <div class="btn-disabled"><p>
                  <strong>JOINED';
              }
          echo '</strong></p>
                  </div>
                </label>
              </div>
            </div>
          </div>
          ';

          //for mobile
          echo '<div class="panel mobile-panel">
            <div class="container-fluid">
              <div class="col-xs-6 col-mobile">
                <p class="sid"> #'.$row['sessionID'].'</p>
                <p class="title">'.$row['title'].'</p>
                <p class="notes-type">';
            if(isset($group)){
              echo '<b>Type:</b> '.$group['class_type'].'</p>';
              echo '<p class="mob_par"><b>Participants:</b> '.$no_pax.'/'.$group['max_pax'].'</p>';
              unset($group);
            }
            if (isset($personal)){
              echo '<div class="notes-div">';
              if (empty($personal['notes'])){
                echo '<b>Notes:</b> N/A';
              }else{
                echo '<b>Notes:</b> '.$personal['notes'];
              }
              echo '</div></p>';
              unset($personal);
            }
            echo '<p class="fee">RM'.$row['fee'].'</p>
            <p class="date-time">'.$dateDM.','.$dateY.' '.$time.'</p>
            </div>
            <div class="col-xs-6 col-join-mobile">
              <p class="label">Trainer: </p> <br>'.$trainer_user['name'].'</p>
              <p class="label">Specialty: </p> <br>'.$trainer['specialty'].'</p>
              <div class="stars-div"><span class="stars" data-rating="'.$avg_rating.'" data-num-stars="5" title="3.75"></span></div>
              <div class="col-xs-12 join-mobile">
              <label class="radio">';

              if ($status_type == "completed" && mysqli_num_rows($reviewed) == 1){
                echo '<input type="radio" value="'.$sessionID.' disabled">
                <div class="btn-disabled"><p>
                  <strong>REVIEWED';
              }
              else if ($status_type == "completed"){
                  echo '<input type="radio" name="rate" value="'.$sessionID.'" data-sid="'.$sessionID.'">
                  <div class="btn"><p>
                    <strong>
                    REVIEW';
                }
              else{
                echo '<input type="radio" value="'.$sessionID.' disabled">
                <div class="btn-disabled"><p>
                  <strong>JOINED';
              }
                echo '</strong>
                  </div>
                </label>
              </div>
            </div>
            </div>
          </div>';

          //rate sect
          echo'<aside class="rate rate'.$sessionID.'">
            <h3>Rate Trainer <p class="t_name">'.$trainer_user['name'].'</p></h3>
            <form id="review" action="#" method="post" autocomplete="off">
            <div class="rate_stars">
                <input class="rate_star rate_star-5" id="rate_star-5-'.$sessionID.'" type="radio" name="rate_star" value="5"/>
                <label class="rate_star rate_star-5" for="rate_star-5-'.$sessionID.'"></label>
                <input class="rate_star rate_star-4" id="rate_star-4-'.$sessionID.'" type="radio" name="rate_star" value="4"/>
                <label class="rate_star rate_star-4" for="rate_star-4-'.$sessionID.'"></label>
                <input class="rate_star rate_star-3" id="rate_star-3-'.$sessionID.'" type="radio" name="rate_star" value="3"/>
                <label class="rate_star rate_star-3" for="rate_star-3-'.$sessionID.'"></label>
                <input class="rate_star rate_star-2" id="rate_star-2-'.$sessionID.'" type="radio" name="rate_star" value="2"/>
                <label class="rate_star rate_star-2" for="rate_star-2-'.$sessionID.'"></label>
                <input class="rate_star rate_star-1" id="rate_star-1-'.$sessionID.'" type="radio" name="rate_star" value="1"/>
                <label class="rate_star rate_star-1" for="rate_star-1-'.$sessionID.'"></label>
            </div>
            <input type = "hidden" name = "sessionID" value = "'.$sessionID.'" />
            <input type = "hidden" name = "trainer_id" value = "'.$trainer_user['user_id'].'" />
            <textarea class="comments" name="comments" placeholder="Tell us what you feel!" font-weight="200" id="" cols="30" rows="7"></textarea>
            <button type="submit" name="review" class="button" style="margin-top:10px;">SUBMIT</button>
          </form>
        </aside>';
        }
      }// end while loop
      if ($none_available){
        echo '<div style="text-align:center"><h3 style="margin:90px 30px 90px 30px;color:#fff;">
        You do not have any '.$_SESSION['type'].' training sessions.
        </h3></div>';
      }
        echo '</div>';
        unset($_SESSION['type']);
    }//end if type
  }



  //add review
  if (isset($_POST['review'])) {
    $rating = $_POST['rate_star'];
  	$comments = trim(mysqli_real_escape_string($db, $_POST['comments']));
  	$member_id = $_SESSION['user']['user_id'];
    $trainer_id = $_POST['trainer_id'];
    $sessionID = $_POST['sessionID'];
    if (empty($rating)) { $_SESSION['error'] = "Please enter a rating with the stars."; }
    if (!isset($_SESSION['error'])){
      $query = "INSERT INTO review (rating,comments,trainer_id,member_id,sessionID)
  				  VALUES('$rating','$comments', '$trainer_id','$member_id','$sessionID')";
  		mysqli_query_or_die($query);
      $_SESSION['success_review'] = "You have successfully submitted a review!";
      header('location: #');
      exit();
    }
  }


  // ----------------------------for trainer---------------------------------------

  // print trainer's training history
    function printTrainerHistory(){
      $trainer_id = $_SESSION['user']['user_id'];
      $result = mysqli_query_or_die("SELECT * FROM trainingsession WHERE trainer_id='$trainer_id' ORDER BY trainingsession.date, trainingsession.time ASC");
      $none_available = true;
      if(isset($_SESSION['type'])){
        echo '<div class="training-container" style="margin-bottom:20px !important;">';
        while ($row = mysqli_fetch_assoc($result)) {
          $sessionID = $row['sessionID'];

          //checks if session has expired(completed) or not
          $date = strtotime($row['date']);
          if (($date < strtotime(date("Y-m-d")))||($row['status'] == "completed")){
             $status_type = "completed";
             if ($row['status'] != "completed"){
               $query = "UPDATE trainingsession SET status = 'completed' WHERE sessionID = '$sessionID'";
               mysqli_query_or_die($query);
             }
          }else {
            $status_type = "upcoming";
          }

          if(($status_type == $_SESSION['type'])&&($row['status'] != "cancelled"))
          {
            $none_available = false;
            //get the personal or group session attributes
            if ($row['training_type'] == "personal"){
              $ses_p = mysqli_query_or_die("SELECT * FROM personaltraining WHERE sessionID='$sessionID'");
              $personal = mysqli_fetch_assoc($ses_p);
            }else if ($row['training_type'] == "group"){
              $ses_g = mysqli_query_or_die("SELECT * FROM grouptraining WHERE sessionID='$sessionID'");
              $group = mysqli_fetch_assoc($ses_g);
            }

            $dateDM = DateTime::createFromFormat('Y-m-d', $row['date'])->format('M d');
            $dateY = DateTime::createFromFormat('Y-m-d', $row['date'])->format('Y');
            $time = DateTime::createFromFormat('H:i:s', $row['time'])->format('h:i a');
            //for desktop and tablet
            echo '<div class="panel panel-default">
              <div class="container-fluid">
                <div class="col-xs-2 date-time">
                  <h3>'.$dateDM.'</h3>
                  <h4 class="year">'.$dateY.'</h4>
                  <h4 class="time">'.$time.'</h4>
                </div>
                <div class="col-xs-5 title-class ';
                if(isset($group)){
                  echo 'title-group';
                }
                if (isset($personal)){
                  echo 'title-personal';
                }

            echo '">
                  <p> SESSION ID: #'.$row['sessionID'].'</p>
                  <h2 title="'.$row['title'].'">'.$row['title'].'</h2>';
            if(isset($group)){
              //count how many members have participated in the group training
              $cquery = mysqli_query_or_die("SELECT count(*) AS total FROM membersession WHERE sessionID = '$sessionID'");
              $data = mysqli_fetch_assoc($cquery);
              $no_pax = $data['total'];
              echo '<h3>Type: '.$group['class_type'].'</h3>';
              echo '<p class="par_label">Participants </p>
                    <p class="par">'.$no_pax.'/'.$group['max_pax'].'</p>';
            }
            if (isset($personal)){
              echo '<h3 class="notes">';
              if (empty($personal['notes'])){
                echo 'NOTES: N/A';
              }else{
                echo 'NOTES: '.$personal['notes'];
              }
              echo '</h3>';
            }
            echo '</div>
                <div class="col-xs-1 status">
                  <p class="sts_label">Status</p>
                  <p>'.$row['status'].'</p>
                </div>
                <div class="col-xs-2 trainer-rate edit-btn">
                  <label class="radio">
                    <input type="radio" name="edit" value="'.$sessionID.'" class="btn join_btn" />
                    <div class="btn"><p>
                      <strong>
                      EDIT
                      </strong></p>
                    </div>
                  </label>
                </div>
                <div class="col-xs-2 join-div">
                  <label class="radio">
                    <input type="radio" name="cancel" value="'.$sessionID.'" class="btn join_btn" data-sid="'.$row['title'].'"/>
                    <div class="btn del-btn"><p>
                      <strong>
                      CANCEL
                      </strong></p>
                    </div>
                  </label>
                </div>
              </div>
            </div>';

            //for mobile
            echo '<div class="panel mobile-panel">
              <div class="container-fluid">
                <div class="col-xs-6 col-mobile">
                  <p class="sid"> #'.$row['sessionID'].' ('.$row['training_type'].')</p>
                  <p class="title">'.$row['title'].'</p>
                  <p class="notes-type">';
              if(isset($group)){
                echo '<b>Type:</b> '.$group['class_type'].'</p>';
                echo '<p class="mob_par"><b>Participants:</b> '.$no_pax.'/'.$group['max_pax'].'</p>';
                unset($group);
              }
              if (isset($personal)){
                echo '<div class="notes-div">';
                if (empty($personal['notes'])){
                  echo '<b>Notes:</b> N/A';
                }else{
                  echo '<b>Notes:</b> '.$personal['notes'];
                }
                echo '</div></p>';
                unset($personal);
              }
              echo '<p class="fee">RM'.$row['fee'].'</p>
              <p class="date-time">'.$dateDM.','.$dateY.' '.$time.'</p>
              </div>
              <div class="col-xs-6 col-join-mobile">
                <div class="col-xs-12 join-mobile">
                <p class="label">Status: </p> <br>'.$row['status'].'</p>
                <label class="radio" style="margin-top:20px;">
                    <input type="radio" name="edit" value="'.$sessionID.'">
                    <div class="btn"><p>
                      <strong>
                      EDIT
                      </strong>
                    </div>
                  </label>
                </div>
                <div class="col-xs-12 join-mobile">
                <label class="radio">
                    <input type="radio" name="cancel" value="'.$sessionID.'" data-sid="'.$row['title'].'">
                    <div class="btn"><p>
                      <strong>
                      CANCEL
                      </strong>
                    </div>
                  </label>
                </div>
              </div>
              </div>
            </div>';
          }
        }// end while loop
        if ($none_available){
          echo '<div style="text-align:center"><h3 style="margin:90px 30px 90px 30px;color:#fff;">
          You do not have any '.$_SESSION['type'].' training sessions.
          </h3></div>';
        }
          echo '</div>';
          unset($_SESSION['type']);
      }//end if type
    }

    //cancel session
    if (isset($_POST['cancel'])){
      $sessionID = $_POST['cancel'];
      $ses = mysqli_query_or_die("SELECT * FROM trainingsession WHERE sessionID='$sessionID'");
      $ses = mysqli_fetch_assoc($ses);
      mysqli_query_or_die("UPDATE trainingsession SET status='cancelled' WHERE sessionID='$sessionID'");

      $_SESSION['success_cancel'] = "Training session ".$ses['title']." is successfully cancelled.";
  		header('location: #');
      exit();
    }

    //uncancel session
    if (isset($_POST['uncancel'])){
      $sessionID = $_POST['uncancel'];
      $ses = mysqli_query_or_die("SELECT * FROM trainingsession WHERE sessionID='$sessionID'");
      $ses = mysqli_fetch_assoc($ses);
      mysqli_query_or_die("UPDATE trainingsession SET status='available' WHERE sessionID='$sessionID'");

      $_SESSION['success_uncancel'] = "Cancellation of training session ".$ses['title']." has been successfully undone.";
      header('location: #');
      exit();
    }

//list cancelled sessions
function printCancelledSessions(){
  $trainer_id = $_SESSION['user']['user_id'];
  $result = mysqli_query_or_die("SELECT * FROM trainingsession WHERE trainer_id='$trainer_id' ORDER BY trainingsession.date, trainingsession.time ASC");
  $none_available = true;
    echo '<div class="training-container">';
    while ($row = mysqli_fetch_assoc($result)) {
      $sessionID = $row['sessionID'];

      if($row['status'] == "cancelled")
      {
        $none_available = false;
        //get the personal or group session attributes
        if ($row['training_type'] == "personal"){
          $ses_p = mysqli_query_or_die("SELECT * FROM personaltraining WHERE sessionID='$sessionID'");
          $personal = mysqli_fetch_assoc($ses_p);
        }else if ($row['training_type'] == "group"){
          $ses_g = mysqli_query_or_die("SELECT * FROM grouptraining WHERE sessionID='$sessionID'");
          $group = mysqli_fetch_assoc($ses_g);
        }

        $dateDM = DateTime::createFromFormat('Y-m-d', $row['date'])->format('M d');
        $dateY = DateTime::createFromFormat('Y-m-d', $row['date'])->format('Y');
        $time = DateTime::createFromFormat('H:i:s', $row['time'])->format('h:i a');
        //for desktop and tablet
        echo '<div class="panel panel-default">
          <div class="container-fluid">
            <div class="col-xs-2 date-time">
              <h3>'.$dateDM.'</h3>
              <h4 class="year">'.$dateY.'</h4>
              <h4 class="time">'.$time.'</h4>
            </div>
            <div class="col-xs-8 title-class ';
            if(isset($group)){
              echo 'title-group';
            }
            if (isset($personal)){
              echo 'title-personal';
            }

        echo '">
              <p> SESSION ID: #'.$row['sessionID'].'</p>
              <h2 title="'.$row['title'].'">'.$row['title'].'</h2>';
        if(isset($group)){
          //count how many members have participated in the group training
          $cquery = mysqli_query_or_die("SELECT count(*) AS total FROM membersession WHERE sessionID = '$sessionID'");
          $data = mysqli_fetch_assoc($cquery);
          $no_pax = $data['total'];
          echo '<h3>Type: '.$group['class_type'].'</h3>';
          echo '<p class="par_label">Participants </p>
                <p class="par">'.$no_pax.'/'.$group['max_pax'].'</p>';
        }
        if (isset($personal)){
          echo '<h3 class="notes">';
          if (empty($personal['notes'])){
            echo 'NOTES: N/A';
          }else{
            echo 'NOTES: '.$personal['notes'];
          }
          echo '</h3>';
        }
        echo '</div>
            <div class="col-xs-2 join-div">
              <label class="radio">
                <input type="radio" name="uncancel" value="'.$sessionID.'" class="btn join_btn" data-sid="'.$row['title'].'"/>
                <div class="btn del-btn"><p style="margin-top:45px !important;">
                  <strong>
                  UNDO <br/>CANCEL
                  </strong></p>
                </div>
              </label>
            </div>
          </div>
        </div>';

        //for mobile
        echo '<div class="panel mobile-panel">
          <div class="container-fluid">
            <div class="col-xs-6 col-mobile">
              <p class="sid"> #'.$row['sessionID'].'</p>
              <p class="title">'.$row['title'].'</p>
              <p class="notes-type">';
          if(isset($group)){
            echo '<b>Type:</b> '.$group['class_type'].'</p>';
            echo '<p class="mob_par"><b>Participants:</b> '.$no_pax.'/'.$group['max_pax'].'</p>';
            unset($group);
          }
          if (isset($personal)){
            echo '<div class="notes-div">';
            if (empty($personal['notes'])){
              echo '<b>Notes:</b> N/A';
            }else{
              echo '<b>Notes:</b> '.$personal['notes'];
            }
            echo '</div></p>';
            unset($personal);
          }
          echo '<p class="fee">RM'.$row['fee'].'</p>
          <p class="date-time">'.$dateDM.','.$dateY.' '.$time.'</p>
          </div>
          <div class="col-xs-6 col-join-mobile">
            <label class="radio">
                <input type="radio" name="uncancel" value="'.$sessionID.'" data-sid="'.$row['title'].'">
                <div class="btn" style="margin-top:50px;"><p>
                  <strong>
                  UNDO CANCEL
                  </strong>
              </label>
            </div>
          </div>
          </div>
        </div>';
      }
    }// end while loop
    if ($none_available){
      echo '<div style="text-align:center"><h3 style="margin:90px 30px 90px 30px;color:#fff;">
      You do not have any cancelled training sessions.
      </h3></div>';
    }
      echo '</div>';
}


    //navigate to edit page
    if (isset($_POST['edit'])){
      unset($_SESSION['personal']);
      unset($_SESSION['group']);
      $sessionID = $_POST['edit'];
      $ses = mysqli_query_or_die("SELECT * FROM trainingsession WHERE sessionID='$sessionID'");
      $ses = mysqli_fetch_assoc($ses);
      $_SESSION['training'] = $ses;

      if ($_SESSION['training']['training_type'] == "personal"){
        $ses_p = mysqli_query_or_die("SELECT * FROM personaltraining WHERE sessionID='$sessionID'");
        $ses_p = mysqli_fetch_assoc($ses_p);
        $_SESSION['personal'] = $ses_p;
      }else{
        $ses_trn = mysqli_query_or_die("SELECT * FROM grouptraining WHERE sessionID='$sessionID'");
        $ses_trn = mysqli_fetch_assoc($ses_trn);
        $_SESSION['group'] = $ses_trn;
      }
      header('location: editsession.php');
      exit();
    }

function printReviews(){
  $trainer_id = $_SESSION['user']['user_id'];
  $result = mysqli_query_or_die("SELECT * FROM review WHERE trainer_id='$trainer_id' ORDER BY review.timestamp DESC");
  $none_available = true;
  while ($row = mysqli_fetch_assoc($result)) {
    $none_available = false;
    $member_id = $row['member_id'];
    $sessionID = $row['sessionID'];
    //get member that reviewed
    $member = mysqli_query_or_die("SELECT * FROM user WHERE user_id='$member_id'");
    $member = mysqli_fetch_assoc($member);

    //get session that is reviewed
    $ses = mysqli_query_or_die("SELECT * FROM trainingsession WHERE sessionID='$sessionID'");
    $ses = mysqli_fetch_assoc($ses);

    echo '<a class="accordion-panel__heading" href="javascript:;"> By <p class="acc_header">'.$member['name'].'</p> for <p class="acc_header">'.$ses['title'].'</p><p class="timestamp">'.$row['timestamp'].'</p></a>
    <div class="accordion-panel__content">
        <h4><span class="stars" data-rating="'.$row['rating'].'" data-num-stars="5" ></span></h4>
        <p>'.$row['comments'].'</p>
    </div>';
  }
  if ($none_available){
    echo '<div style="text-align:center"><h3 style="margin:90px 30px 90px 30px;color:#fff;">
    You do not have any ratings yet.
    </h3></div>';
  }
}
?>
