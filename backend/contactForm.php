<?php

    // define variables and set empty values
    $name = $email = $message = $nameErr = $emailErr = $messageErr = "";

    if( $_SERVER["REQUEST_METHOD"] == "POST"){

        if( empty($_POST["firstname"])){
            $nameErr = "Firstname is required";
        } else {
            $name = test_input($_POST["name"]);
        }
        
        if( empty($_POST["email"])){
            $emailErr = "Email is required";
        } else {
            $email = test_input($_POST["email"]);
        }
        
        if( empty($_POST["message"])){
            $messageErr = "Message is required";
        } else {
            $message = test_input($_POST["message"]);
        }

        /*$servername = "localhost";
        $username = "root";
        $password = "";
        $dbname = "matmax";*/

        $servername = "localhost";
        //$username = "cpses_ma6cihywyk@localhost";
        $username = "matmaxco";
        $password = "!wp58AnR:97XmB";
        $dbname = "matmaxco_db";

        //create a connection
        $conn = new mysqli($servername, $username, $password, $dbname);

        // check connection 
        if($conn ->connect_error){
            die("Connection failed: " . $conn->connect_error);
        }

        // echo "Connected successfully";

        echo $firstname .', ' .$lastname .', ' .$email .', ' .$message;
        //Code for filling the database and sending email go here;
        
        // $sql = "INSERT INTO messages (name, email, message) VALUES("."'" .$firstname ."'".", "."'" .$lastname."'". ", "."'" .$email."'" .', '."'".$message."'".")";
        $sql = "INSERT INTO messages (name, email, message) VALUES("."'" .$name ."'". ", "."'" .$email."'" .', '."'".$message."'".")";

        if( $conn->query($sql) === TRUE){
            echo "New message successfully created";
        } else {
            echo "Error: " .$sql . "<br />" . $conn->error;
        }
        
    }

    function test_input($data){
        $data = trim($data);
        $data = stripslashes($data);
        $data = htmlspecialchars($data);

        return $data;
    }

    $conn->close();

    // mail to matmax, sales, support and my personal email.
    //$to = "sales@matmaxent.co.ke, support@matmaxent.co.ke";
    $to = "info@solarprime.co.ke";
    $subject = $name ." contacting via website form";
    $message = "<html>
        <head>
            <title>Potential client contacting via website form</title>
        </head>
        <body>
            <h1>Client name: ".$name."</h1>
            <p>Client email: <a href=mailto:".$email.">".$email."</a></p>
            <p>".$message."</p>
        </body>
    </html>";

    //$headers = "MIME-Version: 1.0" . "\r\n";
    /*$headers = "Content-type:text/html;charset=UTF-8" . "\r\n";

    // More headers
    $headers .= 'From: Matmax Enterprises Website <info@example.com>' .'\r\n';
    $headers .= 'Reply-To: info@matmax.co.ke\r\n';
    $headers .= 'Bcc: samsonkumenisande@gmail.com' . "\r\n";*/
    $headers[] = "Content-type:text/html;charset=UTF-8";

    // More headers
    $headers[] = 'From: Solar prime Website <info@example.com>';
    $headers[] = 'Reply-To: info@matmax.co.ke';
    $headers[] = 'Bcc: samsonkumenisande@gmail.com';

    mail($to,$subject,$message,implode("\r\n", $headers));

?>