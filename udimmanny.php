<?php 
error_reporting(0);
if(empty(conn)){
    include("..db/php");
    include ("..config");
}
    try {
        $manny_data = $conn->prepare("SELECT * FROM interns_data WHERE username = 'udimmanny'");
        $manny_data->execute();
        $result = $manny_data->setFetchMode(PDO::FETCH_ASSOC);
        $result = $manny_data->fetch();
    
    
        $secret_code = $conn->prepare("SELECT * FROM secret_word");
        $secret_code->execute();
        $code = $secret_code->setFetchMode(PDO::FETCH_ASSOC);
        $code = $secret_code->fetch();
        $secret_word = $code['secret_word'];
     } catch (PDOException $e) {
         throw $e;
     }


// $sql = "SELECT * FROM intern_data where username = 'udimmanny'";
// $result = $conn->query($sql);
// $sql = "SELECT * FROM secret_word";
// $secret_word = $conn->query($sql);
 ?>

<?php
//set server method to Post
if ($_SERVER['REQUEST_METHOD'] === 'POST'){
//BOT FUNCTIONS
function regex_string($data){
$data = trim($data);
$data = stripslashes($data);
$data = htmlspecialchars($data); //change HTML output
$data = preg_replace("[?.!])", "\'", $data);
$data = preg_replace("(['])", "\'", $data);
return $data;
}

function Chatty($question){
require '../..config.php';
$question = regex_string($question);
$conn = mysql_connect(DB_HOST, DB_USER, DB_PASSWORD, DB_DATABASE);
if (!$conn){
echo json_encode([
'status' => 1,
'answer' => "could not connect to the database" . DB_DATABASE . ":" .$conn->
connect_error
]);
return;
}
$query = "SELECT answer FROM chatbot WHERE question LIKE '$question'";
$result = $conn->query($query)->fetch_all();
echo json_encode([
'status' => 1,
'answer' => $result
]);
return;
}

//training the bot

function trainerMode($ask){
require '../../config.php';
$QuestionAndAnswer = substr($question, 6); //uses # as delimiter
$QuestionAndAnswer = regex_string($questionAndAnswer);
$QuestionAndAnswer = preg_replace("([?.])", "", $QuestionAndAnswer); //regular expresson to search and replace
$QuestionAndAnswer = explode("#", $QuestionAndAnswer);
if ((count($QuestionAndAnswer)==3)){
$question = $QuestionAndAnswer [0];
$answer = $questionAndAnswer[1];
$password = regex_string($questionAndAnswer[2]);
}
if(!isset($password)|| $password !=='password'){
echo json_encode([
'status' =>1,
'answer' => "please use the correct training password"
]);
return;
}
if(isset($question) && isset($answer)){
$question = regex_string($question);
$aanswer = regex_string($answer);
if(($question) =="" || $answer ==""){
echo json_encode([
'status' => 1,
'answer' => "empty question or response"
]);
return;
}
$conn = mysqli_connect( DB_HOST, DB_USER, DB_PASSWORD,DB_DATABASE );
                if(!$conn){
                    echo json_encode([
                        'status'    => 1,
                        'answer'    => "Could not connect to the database " . DB_DATABASE . ": " . $conn->connect_error
                    ]);
                    return;
}
$query = "INSERT INTO 'chatbot' ('question', 'answer')VALUES ('$question', '$answer')";
if($conn->query($query) ===true){
echo json_encode([
'status' => 1,
'answer' =>  "thank you for training me, I am smarter"
]);
}
else{
echo json_encode([
'status' => 1,
'answer' => "Error training me, something went wrong" .$conn->error]);
}
return;
}else{
echo json_encode([
'status' => 0,
'answer' => "Wrong training pattern<br>Please use this<br>train: question # answer"
]);
return;
}
} 
//now lets post the Q&As
$Ask = regex_string(_POST['ask']);
if (strpos($ques, "train:") ==!false){
trainerMode($ques);
}else{
chatty($ques);
}
return;
}
?>


<?php if($_SERVER['REQUEST_METHOD'] !== 'POST'){ ?> 

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="stylesheet" href="../vendor/bootstrap/css/bootstrap.min.css">
    <link rel="stylesheet" href="../vendor/font-awesome/css/font-awesome.min.css">
    <title>Udim Manny| HNG intern</title>
    <style>




body{
font-size:16px;
font-family: 'Roboto';
width:100%}

#hero{height: 700px;
background: linear-gradient(
    rgba(0,0,0,0.7),rgba(0,0,0,0.8) ),
    url("https://res.cloudinary.com/eacademy/image/upload/v1523653635/web-developer.jpg");
background-size: cover;
background-position: center;
background-attachment: fixed;
width: 100%;
position: relative}


.btn-info {
    color: #fff;
    background-color: #17a2b8;
    border-color: #17a2b8;
    border-radius: 25px;
}


.btn-info:hover {
    color: #17a2b8;
    background-color: #fff;
    border-color: #17a2b8;
    cursor:pointer;
}




h1{color:#fff;
 padding-top: 300px;   
font-size: 5vw;
line-height:1.1 ;}

.name{color: #fff;}
.name2{color:#DC143C;}

/*Navbar styling starts here*/





.progress-bar{
    line-height:30px;
}


   
.shadow{box-shadow: #f8f8f8 5px 5px;
border: 1px solid whitesmoke;}
    

p.space{font-size:22px;
color:#524e4d;
padding-bottom: 80px;}
p#about{color:#888;
}

p.space2{font-size:22px;
    color:#524e4d;
    }

    p#about{color:#888;
    }
.end{background-color:#dc0000; width:120px;
    padding-left:0px}
    .end2{background-color:#dc0000; width:120px;
        padding-left:0px}

/* Progress Bar Starts*/
        .progress {
            position: relative;
            height: 25px;
            margin-bottom: 12px;
            color: #DC143C;
        }
        .progress > .progress-type {
            position: absolute;
            left: 0px;
            font-weight: 800;
            padding: 3px 30px 2px 10px;
            color: rgb(255, 255, 255);
            background-color: rgba(25, 25, 25, 0.2);
            width: 120px;
        }
        .progress > .progress-completed {
            position: absolute;
            right: 0px;
            font-weight: 600;
            padding: 3px 10px 2px;
            
        }
        .progress-bar{background-color: #DC143C;}
/* Progress Bar Starts*/





h2{font-weight: 800;}

#about{padding: 50px 50px;
background-color: #fdfdfd;
animation: fadeInLeft 2s;}

#skills{padding: 10px 0px 50px;
    background-color: #fdfdfd;

}


footer{background-image: url(https://res.cloudinary.com/eacademy/image/upload/v1523653737/footer.jpg);
    color: #ffffff;
    padding-top: 30px;
    
    }

      a{text-decoration: none;
        color: white;
        
    }

    a:hover {text-decoration: none;
        color: white;}

    li{display: inline-block;}

    

   .footer-social i.fa {
        display: inline-block;
        border-radius: 50%;
        box-shadow: 0px 0px 2px #888;
        padding: 0.5em 0.6em;
        color:#fff
      
      }
/* Footer starts here */
      .footer-social i.fa:hover{color:grey;}

      .fa-facebook{background-color:#3B5998 }
      .fa-twitter{background-color:#1DA1F2 }
      .fa-linkedin{background-color:#0077B5 }
      .fa-github{background-color:#bd2c00 }

     


      

    .fine{box-shadow: #8af0d1 2px 2px;
        border: 1px solid whitesmoke;
        border-radius: 15px;}

        .bot{background: linear-gradient(
    rgba(0,0,0,0.4),rgba(0,0,0,0.9) ),
    url(https://cdn57.androidauthority.net/wp-content/uploads/2016/05/artificial-intelligence-840x472.jpg);
     height:500px; 
     overflow-y:scroll;
      color: white;
      border: 2px white solid;
      border-radius: 10px;  }
   </style>

</head>
<body> 
<section id="skills" class="">
    <div class="container"> 
<div class="row skillset ">
        <div class="col-sm-5">
                <div class="text-center">
<img class"fine" src="https://res.cloudinary.com/eacademy/image/upload/v1523624108/manny.jpg" width="80%" style= "border-radius:50%;">
<h2 class="text-center">Who am I?</h2>
<p>Hi, my name is Udim Manny, I'm a Mechie with a passion for building pixel perfect web apps,
I love all things STEM. I currently work as a freelancer.
</p>
<ul class="footer-social">
<li><a href="http://www.twitter.com/udimobong" target="_blank"><i class="fa fa-twitter " title="Twitter" ></i></a></li>
<li><a href="http://www.facebook.com/manassehv" target="_blank"><i  class="fa fa-facebook" title="Facebook"></i></a></li>
<li><a href="http://www.linkedin.com/udimmanny" target="_blank"><i class="fa fa-linkedin" title="Linkedin"></i></a></li>
<li><a href="http://github.com/UdimManny" target="_blank"><i class="fa fa-github " title="GitHub"></i></a></li>
</ul></div>
        </div>
        <div class="col-sm-7" style="padding-top: 60px;">
            <div class="progress">
                <div class="progress-bar progress-bar-danger" role="progressbar"  style="width: 80%">
                    <span class="sr-only">90% Complete (danger)</span>
                </div>
                <span class="progress-type end">HTML</span>
                <span class="progress-completed hidden-sm"></span>
            </div>  
            <div class="progress">
                <div class="progress-bar progress-bar-danger" role="progressbar" aria-valuenow="80" 
                aria-valuemin="0" aria-valuemax="100" style="width: 70%">
                    <span class="sr-only">80% Complete (danger)</span>
                </div>
                <span class="progress-type">CSS</span>
                <span class="progress-completed"></span>
            </div>
            <div class="progress">
                <div class="progress-bar progress-bar-danger" role="progressbar" aria-valuenow="80" 
                aria-valuemin="0" aria-valuemax="100" style="width: 70%">
                    <span class="sr-only">80% Complete (danger)</span>
                </div>
                <span class="progress-type">Bootstrap</span>
                <span class="progress-completed"></span>
            </div>
            <div class="progress">
                <div class="progress-bar progress-bar-danger" role="progressbar" aria-valuenow="80" 
                aria-valuemin="0" aria-valuemax="100" style="width: 50%">
                    <span class="sr-only">80% Complete (danger)</span>
                </div>
                <span class="progress-type">JavaScript</span>
                <span class="progress-completed"></span>
            </div>
            <div class="progress">
                <div class="progress-bar progress-bar-danger" role="progressbar" aria-valuenow="80" 
                aria-valuemin="0" aria-valuemax="100" style="width: 70%">
                    <span class="sr-only">60% Complete (danger)</span>
                </div>
                <span class="progress-type">Jquery</span>
                <span class="progress-completed"></span>
            </div> 
            <div class="progress">
                <div class="progress-bar progress-bar-danger" role="progressbar" aria-valuenow="80" 
                aria-valuemin="0" aria-valuemax="100" style="width: 40%">
                    <span class="sr-only">80% Complete (danger)</span>
                </div>
                <span class="progress-type">React</span>
                <span class="progress-completed"></span>
            </div> 
            <div class="progress">
                <div class="progress-bar progress-bar-danger" role="progressbar" aria-valuenow="80" 
                aria-valuemin="0" aria-valuemax="100" style="width: 40%">
                    <span class="sr-only">80% Complete (danger)</span>
                </div>
                <span class="progress-type">Node.Js</span>
                <span class="progress-completed"></span>
            </div>
            <div class="progress">
                <div class="progress-bar progress-bar-danger" role="progressbar" aria-valuenow="80" 
                aria-valuemin="0" aria-valuemax="100" style="width: 40%">
                    <span class="sr-only">80% Complete (danger)</span>
                </div>
                <span class="progress-type">Figma</span>
                <span class="progress-completed"></span>
            </div>   

            <div class="progress">
                <div class="progress-bar progress-bar-danger" role="progressbar" aria-valuenow="80" 
                aria-valuemin="0" aria-valuemax="100" style="width: 30%">
                    <span class="sr-only">80% Complete (danger)</span>
                </div>
                <span class="progress-type">PHP/MySQL</span>
                <span class="progress-completed"></span>
            </div>
            
            
              </div>
            </div>
            </div>
            </section>
            <section id ="bott">
            <div class ="container">
            <div class="row">
            <div class="col-sm-4 col-sm-offset-8 bot">
            <div class= "bot-header" style="background:black; padding-top:20px; padding-bottom: 20px; color:white; width:100%;">
            <p class="pull-right">eMachine</p>
            </div>
                           <p>emachine: hi my name is emachine, I'm Manny's personal assistant, ask me anything 
                           about him</p>
                           <p>emachine: hi my name is emachine, I'm Manny's personal assistant, ask me anything 
                           about him</p>
                           <p>emachine: hi my name is emachine, I'm Manny's personal assistant, ask me anything 
                           about him</p>
                           <p>emachine:I was built to give you all bible quotes, input a passage and I will display it</p>
                           <p>emachine:I was built to give you all bible quotes, input a passage and I will display it</p>
                            <form name = "chatbot" style= "position:relative; top:600px; left:40px;">
                            <input type ="text" type = "question" id="question" placeholder ="message eMachine" 
                            style = "line-height:35px; border-radius: 15px; margin-right:7px;">
                            <button class="btn btn-info" type ="submit" onclick="sendMsg()">send</button>
                          

                           
                            
                        </div>
            </div>
            </div>
            </section>
            
            <!-- <script>var TxtType = function(el, toRotate, period) {
    this.toRotate = toRotate;
    this.el = el;
    this.loopNum = 0;
    this.period = parseInt(period, 10) || 2000;
    this.txt = '';
    this.tick();
    this.isDeleting = false;
};

TxtType.prototype.tick = function() {
    var i = this.loopNum % this.toRotate.length;
    var fullTxt = this.toRotate[i];

    if (this.isDeleting) {
    this.txt = fullTxt.substring(0, this.txt.length - 6);
    } else {
    this.txt = fullTxt.substring(0, this.txt.length + 1);
    }

    this.el.innerHTML = '<span class="wrap">'+this.txt+'</span>';

    var that = this;
    var delta = 200 - Math.random() * 100;

    if (this.isDeleting) { delta /= 2; }

    if (!this.isDeleting && this.txt === fullTxt) {
    delta = this.period;
    this.isDeleting = true;
    } else if (this.isDeleting && this.txt === '') {
    this.isDeleting = false;
    this.loopNum++;
    delta = 500;
    }

    setTimeout(function() {
    that.tick();
    }, delta);
};

window.onload = function() {
    var elements = document.getElementsByClassName('typewrite');
    for (var i=0; i<elements.length; i++) {
        var toRotate = elements[i].getAttribute('data-type');
        var period = elements[i].getAttribute('data-period');
        if (toRotate) {
          new TxtType(elements[i], JSON.parse(toRotate), period);
        }
    }

};   </script> -->
 <script>
    
        window.addEventListener("keydown", function(e){
            if(e.keyCode ==13){
                if(document.querySelector("#question").value.trim()==""||document.querySelector("#question").value==null||document.querySelector("#question").value==undefined){
                    //console.log("empty box");
                }else{
                    //this.console.log("Unempty");
                    sendMsg();
                }
            }
        });
        function sendMsg(){

            var ques = document.querySelector("#question");
            if(ques.value == "exit"){
                exitB();
                return;
            }
            if(ques.value.toLowerCase() ==":about bot:"){
                displayOnScreen(ques.value, "user");
                displayOnScreen("Name: eMachine <br> Version: 1.0.7");
                return;
            }
            if(ques.value.trim()== ""||document.querySelector("#question").value==null||document.querySelector("#question").value==undefined){return;}
            displayOnScreen(ques.value, "user");
            
            //console.log(ques.value);
            var xhttp = new XMLHttpRequest();
            xhttp.onreadystatechange = function(){
                if(xhttp.readyState ==4 && xhttp.status ==200){
                    processData(xhttp.responseText);
                }
            };
            xhttp.open("POST", "https://hng.fun/profiles/udimmanny.php", true);
            xhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
            xhttp.send("ques="+ques.value);
        }
        function processData (data){
            data = JSON.parse(data);
            console.log(data);
            var answer = data.answer;
            //Choose a random response from available
            if(Array.isArray(answer)){
                if(answer.length !=0){
                    var res = Math.floor(Math.random()*answer.length);
                    displayOnScreen(answer[res][0], "bot");
                }else{
                    displayOnScreen("Sorry I don't understand what you said <br>But You could help me learn<br> Here's the format: train: question # response # password");
                }
            }else{
                displayOnScreen(answer,"bot");
            }
            
            
        
        }
        function displayOnScreen(data,sender){
            //console.log(data);
            if(!sender){
                sender = "bot"
            }
            var display = document.querySelector(".display");
            var msgArea = document.querySelector(".myMessage-area");
            var div = document.createElement("div");
            var p = document.createElement("p");
            p.innerHTML = data;
            //console.log(data);
            div.className = "myMessage "+sender;
            div.append(p);
            msgArea.append(div)
            if(data != document.querySelector("#question").value){
                document.querySelector("#question").value="";
            }
            //display.scrollTo(0, display.scrollHeight);
            $('.display').animate({
                scrollTop: display.scrollHeight,
                scrollLeft: 0
            }, 500);
            
            }
    </script>
 
</body>
<script src="../vendor/jquery/jquery.min.js" type="text/javascript"></script>
<!-- Latest compiled and minified JavaScript -->
<script src="../vendor/bootstrap/js/bootstrap.min.js"></script>
</html>
<?php } ?> 