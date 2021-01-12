<?php

// singleton helper
class DB
{
    protected static $db;

    public static function get( $sql )
    {
        if (static::$db === null) {
            // $servername = "localhost";
            // $username = "root";
            // $password = "";
            // $dbname = "cars_tracer";
            // static::$db = mysqli_connect($servername, $username, $password, $dbname);
            static::$db = pg_connect("host=localhost port=5432 dbname=library user=postgres password=123");
        }

        // return static::$db;
        return pg_query(static::$db, $sql);
    }
}