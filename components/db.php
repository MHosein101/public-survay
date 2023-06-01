<?php

function DB_Connect($config) 
{
    $conn = null;
    extract($config);

    $type = strtoupper($type);

    try 
    {
        if($type == "MYSQL")
        {
            $conn = new PDO("mysql:host=localhost;dbname=$database;charset=utf8", $username, $password);
        }
        else if($type == "SQLITE")
        {
            $conn = new PDO("sqlite:$database");
        }

        $conn->setAttribute( PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION );
        return $conn;
    }
    catch(Exception $e) 
    {
        echo "<code><pre>" . "Connection error : {$e->getMessage()}" . "</pre></code>";
    }
}

function DB_Execute($conn, $sql, $inputs = [])
{
    try 
    {
        $prepared = $conn->prepare($sql);
        $prepared->execute($inputs);
        return $prepared->rowCount();
    }
    catch(Exception $e) 
    {
        echo "<code><pre>" . "Execution error : {$e->getMessage()}" . "</pre></code>";
    }
}

function DB_Query($conn, $select, $inputs = []) 
{
    try 
    {
        $stmt = $conn->prepare($select);
        $stmt->execute($inputs);
        $stmt->setFetchMode(PDO::FETCH_BOTH);
        return $stmt->fetchAll();
    }
    catch(Exception $e) 
    {
        echo "<code><pre>" . "Query error : {$e->getMessage()}" . "</pre></code>";
    }
}

?>