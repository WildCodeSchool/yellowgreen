<?php

namespace App\Model;

use PDO;
use PDOException;

class Util
{
    public static function getAlertBox(string $message): void /* boite de dialoge javascript */
    {
        echo "<script>alert('" . $message . "');</script>";
    }

    public static function clearLog(): bool
    {
        try {
            if (file_exists("logfile")) {
                return unlink("logfile");
            }
        } catch (\Exception $e) {
            self::writeLog("logfile cannot be deleted : " . $e->getMessage());
            return false;
        }
        return true;
    }

    public static function writeLog(mixed $data): int|bool
    {
        if (DEBUG === 'false') {
            self::getAlertBox($data);
        }
        return file_put_contents("logfile", $data, FILE_APPEND);
    }

    public static function cleanParam(mixed $param): mixed
    {
        switch (gettype($param)) {
            case "string":
                $param = htmlentities(trim($param));
                break;
            case "integer":
                $param = filter_var($param, FILTER_VALIDATE_INT);
                break;
            case "double":
                $param = filter_var($param, FILTER_VALIDATE_FLOAT);
                break;
            case "boolean":
                $param = filter_var($param, FILTER_VALIDATE_BOOLEAN);
                break;
            case "array":
                $newParam = array();
                foreach ($param as $key => $value) {
                    $newParam[$key] = self::cleanParam($value);
                }
                $param = $newParam;
                break;
            default:
                $param = false;
        }
        return $param;
    }

    public static function testDatabase()
    {
        try {
            $connect = new PDO(APP_DB_HOST, APP_DB_USER, APP_DB_PASSWORD);
            $sql = file_get_contents(DB_DUMP_PATH); /* fichier database.sql pour init DB si non existatnte */
            $connect->query($sql);
        } catch (PDOException $err) {
            self::writeLog("Error DB Connection : <br>" . $err->getMessage());
        }
    }
}
