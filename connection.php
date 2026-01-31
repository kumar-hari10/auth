<?php
$conn=mysqli_connect("localhost","root","","auth");
if($conn)
{
    // echo "connection ok";
}
else{
    echo "not connected".mysqli_connect_error();
}
?>