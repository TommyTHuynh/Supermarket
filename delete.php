<?php

require_once('assets/PHPfunctions/bookmark_fns.php');
session_start();

if(!(isset($_SESSION['valid_user'])) || !(isset($_SESSION['priviledge']))){
    do_html_header_universal('form');
    user_message('You are not logged in');
    do_html_url('index.html', 'Login');
    do_html_footer_universal(false, 'form');
    exit;
}

if($_SESSION['priviledge'] != "employee"){
    do_html_header_universal('form');
    user_message('You do not have clearance for this page');
    do_html_url('member.php', 'Go back');
    do_html_footer_universal(false, 'form');
    exit;
}


if ( isset($_GET['t']) && isset($_GET['i']) ) {
    $table = $_GET['t'];
    $pK = base64_decode($_GET['i']);


    try {
        switch ( $table ) {
            case 'employee':
                $conn = pdo_connection();
                $stmt = $conn->prepare('DELETE FROM employee WHERE `EName` = ?');
                $stmt->execute(array($pK));
                header('Location: /Supermarket/employee.php');
                break;
            case 'supplier':
                $conn = pdo_connection();
                $stmt = $conn->prepare('DELETE FROM supplier WHERE `CompanyID` = ?');
                $stmt->execute(array($pK));
                header('Location: /Supermarket/supplier.php');
                break;
            case 'product':
                $conn = pdo_connection();
                $stmt = $conn->prepare('DELETE FROM product WHERE `BarCode` = ?');
                $stmt->execute(array($pK));
                header('Location: /Supermarket/product.php');
                break;
        }
    } catch (PDOException $pdoEx) {
        echo $pdoEx->getMessage() . '<br>';
        echo '<a href="/Supermarket/product.php">Back to Product Page<a>';
    }
}
