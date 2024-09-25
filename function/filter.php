<?php
include 'connection.php';

$filter = '';

if(isset($_POST['fruits'])){
    $filter.=" OR `category`= 'fruits'";
}

if(isset($_POST['vegetables'])){
    $filter.=" OR `category`= 'vegetables'";
}

if(isset($_POST['dairy'])){
    $filter.=" OR `category`= 'dairy'";
}

if(isset($_POST['spices'])){
    $filter.=" OR `category`= 'spices'";
}

if(isset($_POST['grains'])){
    $filter.=" OR `category`= 'grains'";
}

if(isset($_POST['bakery'])){
    $filter.=" OR `category`= 'bakery'";
}

if($_POST['range1']!=''){
    if($_POST['range1'] > $_POST['range2']){
        $r2 = $_POST['range1'];
        $r1 = $_POST['range2'];
    }
    else{
        $r1 = $_POST['range1'];
        $r2 = $_POST['range2'];
    }
    $filter.=" AND `discount` BETWEEN '$r1' AND '$r2'";
}

$_SESSION['filter'] = "SELECT * FROM `product` WHERE ".substr($filter, 4);
$mysqli->close();
echo '<script type="text/JavaScript"> history.back();</script>';
?>