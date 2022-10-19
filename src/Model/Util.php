<?php

namespace App\Model;

class Util
{

    public function alert(string $message): void /* boite de dialoge javascript */
    {
        echo "<script>alert('" . $message . "');</script>";
    }

    public function clearLog(): bool
    {
        try {
            if (file_exists("logfile"))
                return unlink("logfile");
        } catch (\Exception $e) {
            $this->writeLog("logfile cannot be deleted : " . $e->getMessage());
            return false;
        }
        return true;
    }

    public function writeLog(mixed $data): int|bool
    {
        if (DEBUG)
            $this->alert($data);
        return file_put_contents("logfile", $data, FILE_APPEND);
    }

    public function cleanParam(mixed $param): mixed
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
                foreach ($param as $item)
                    $newParam[] = $this->cleanParam($item);
                $param = $newParam;
            default:
                $param = false;
        }
        $this->alert($param);
        return $param;
    }

    public function testDatabase()
    {
        try {
            $connect = new \PDO(APP_DB_HOST, APP_DB_USER, APP_DB_PASSWORD);
            $sql = file_get_contents(DB_DUMP_PATH); /* fichier database.sql pour init DB si non existatnte */
            $connect->query($sql);
        } catch (\PDOException $err) {
            $this->writeLog("Error DB Connection : <br>" . $err->getMessage());
        }
    }
}
