<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin</title>
</head>
<body>
    <h1>WELCOME ADMIN</h1>
<table border='2'>
    
<tr>
    <th>First name</th>
    <th>Last name</th>
    <th>Email</th>
    <th>Gender</th>
    <th>Status</th>
</tr>

    
    
    
    <?php
include("connection.php");
$query="select * from users";
$data=mysqli_query($conn,$query);
$total=mysqli_num_rows($data);
if($total!=0){
    while($result=mysqli_fetch_assoc($data)){
        echo "
            <tr>
            <td>".$result['first']."</td>      
            <td>".$result['last']."</td>      
            <td>".$result['email']."</td>      
            <td>".$result['gen']."</td>      
            <td>".$result['status']."</td>      
        
        ";
    }
}
else{
    echo "no records found";
    
}
?>
</table>
</body>
</html>