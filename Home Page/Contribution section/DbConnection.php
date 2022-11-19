<?php

$userid=$_POST['userid'];
$passid=$_POST['passid'];
$username=$_POST['username'];
$phone=$_POST['phone'];
$address=$_POST['addresss'];
$country=$_POST['country'];
$zip=$_POST['zip'];
$email=$_POST['email'];
$gender=$_POST['gender'];
$point=$_POST['pointt'];
$english=$_POST['english'];
$descr=$_POST['descr'];

if(!empty($userid)||!empty($passid)||!empty($username)||!empty($phone)||!empty($address)||!empty($country)
                          ||!empty($zip)||!empty($email)||!empty($gender)||!empty($point)||!empty($english)||!empty($descr))
{
    $host="localhost";
    $dbUserName="root";
    $dbPassword="";
    $dbname="comment_table";
    $conn=new mysqli($host,$dbUserName,$dbPassword,$dbname);

    if(mysqli_connect_error())
    {
        die('Connect Error('.mysqli_connect_errno().')'.mysqli_connect_error());

    }
    else
    {
        $SELECT= "SELECT email FROM registrationtlb where email=? Limit 1";
        $INSERT= "INSERT INTO registrationtlb (userid,passid,username,phone,addresss,country,zip,email,gender,pointt,english,descr) 
                     values(?,?,?,?,?,?,?,?,?,?,?,?)";

        $stmt=$conn->prepare($SELECT);
        $stmt->bind_param("s",$email);
        $stmt->execute();
        $stmt->bind_result($email);
        $stmt->store_result();
        $rnum=$stmt->num_rows;

        if($rnum==0)
        {
            $stmt->close();
            $stmt=$conn->prepare($INSERT);
            $stmt->bind_para("sssssii",$userid,$passid,$username,$phone,$address,$country,$zip,$email,$gender,$point,$english,$descr);
            $stmt->execute();
            echo "Submition Done Sucessfully";
        }
        else{
            echo "Someone already register using this email";
        }
        $stmt->close();
        $conn->close();
    }

}
else{
    echo"All fields are required";
    die();
}


?>