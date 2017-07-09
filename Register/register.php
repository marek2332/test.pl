<?php

# Podłaczenia do bd

require_once "config.php";

$con = mysql_connect($servername, $username, $password);
if (!$con)
{

die('Could not connect: ' . mysql_error());

}

mysql_select_db("mydb");


if(isset($_POST['submit']))

{

    $err = array();


# Sprawdzamy nazwe użytkownika

    if(!preg_match("/^[a-zA-Z0-9]+$/",$_POST['login']))

    {

        $err[] = "Nazwa użytkownika może zawierać tylko angielski litery oraz cyfry" ;

    }

    

    if(strlen($_POST['login']) < 3 or strlen($_POST['login']) > 30)

    {

        $err[] = "Dopuszczlna wielkość nazwy użytkownika od 3-30";

    }

    

# Sprawdzamy czy nie istnieje już użytkownik z taką samą nazwą

    $query = mysql_query("SELECT COUNT(user_id) FROM users WHERE user_login='".mysql_real_escape_string($_POST['login'])."'");

    if(mysql_result($query, 0) > 0)

    {

        $err[] = "Klient z taką nazwą użytkownika już istnieje w bazie danych ";

    }


# W przypadku gdy nie ma błedów to dodajemy nowego użytkownika do bd

    if(count($err) == 0)

    {

        
        $login = $_POST['login'];

        

 # Убераем лишние пробелы и делаем двойное шифрование

        $user_password = md5(md5(trim($_POST['user_password'])));

        

        mysql_query("INSERT INTO users SET user_login='".$login."', password='".$user_password."'");

        header("Location: login.php"); exit();

    }
else

    {

        print "<b>W procesie rejestracji znalieżiono kolejne błedy:</b><br>";

        foreach($err AS $error)

        {

            print $error."<br>" ;

        }

    }

}








?>
