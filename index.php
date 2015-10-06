<?php  
// include our libraries  
include 'lib/tmhOAuth.php';  
include 'lib/TwitterApp.php';  
require 'lib/tmhUtilities.php';
// set the consumer key and secret  
define("CONSUMER_KEY","GANTI DENGAN TwitterApp CONSUMER KEY"); 
define("CONSUMER_SECRET","GANTI DENGAN TWITTER APP CUNSOMER SECRET");  
try {  
    // our tmhOAuth settings  
    $config = array(  
        'consumer_key'      => CONSUMER_KEY,  
        'consumer_secret'   => CONSUMER_SECRET  
    );  
    // create a new TwitterAvatars object  
    $ta = new TwitterApp(new tmhOAuth($config));  
    //$ta->endSession();
    // check our authentication status  
    if($ta->isAuthed()=='2') {  //the user is authed
        if(isset($_POST["tweet"])) {  
          // we set the type and filename are set here as well
          
         if ($_FILES['image']['size'] > 0 ){
            $target_path = "";
            $target_path = $target_path . basename( $_FILES['image']['name']); 
            move_uploaded_file($_FILES['image']['tmp_name'], $target_path);
              $params = array(
                'media[]' =>  file_get_contents($_FILES['image']['name']),
                'status'  => $_POST['status']
              );
              $code = $ta->sendTweetImage($params);
              unlink($_FILES['image']['name']);
              
            echo "Check tweet at <a target='_blank' href='https://twitter.com/".$ta->userdata->screen_name."/status/".$code['id']."'>https://twitter.com/".$ta->userdata->screen_name."/status/".$code['id']."</a>";
          }else{
            $text =  $_POST['status'];
            $code = $ta->sendTweet($text);           
            echo "Check tweet at <a target='_blank' href='https://twitter.com/".$ta->userdata->screen_name."/status/".$code['id']."'>https://twitter.com/".$ta->userdata->screen_name."/status/".$code['id']."</a>";
          }
          
         }

        if (isset($_GET['logout'])) {
        	$ta->endSession();
            header("Location: {$_SERVER['PHP_SELF']}");
        }

        $success = true;
        
        include('home.php');

    }  
    // did the user request authorization?  
    elseif(isset($_POST["auth"])) {  
        // start authentication process  
        $ta->auth();  
    }  
    else{ //default index must show login button
    	echo "
    		<form action=\"index.php\" method=\"post\">  
			<input type=\"image\" src=\"https://g.twimg.com/dev/sites/default/files/images_documentation/sign-in-with-twitter-gray.png\" alt=\"Connect to Twitter\" name=\"auth\" value=\"1\">  
			</form> 
    	";
        echo $ta->isAuthed();
    }

} catch(Exception $e) {  
    // catch any errors that may occur  
    $error = $e;  
}
?>
