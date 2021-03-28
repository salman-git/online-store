<?php
    include('connection.php');
    $filterParam = $_POST['filterParam'];
    $query = "select * from orders;";
    if (strlen($filterParam) > 0)
        $query = "select * from orders where status = '$filterParam'";

    $result = mysqli_query($con,$query);
    $arr = array();
    while($row=mysqli_fetch_assoc($result)){
        array_push($arr, $row);
    }
    echo json_encode($arr);
?>