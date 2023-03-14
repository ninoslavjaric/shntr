<?php

class Session implements SessionHandlerInterface
{
    /**
     * @var mysqli
     */
    private $link;

    public function open($savePath, $sessionName)
    {
        global $db;

        if ($db) {
            $this->link = $db;
            return true;
        } else {
            return false;
        }
    }

    public function close()
    {
        mysqli_close($this->link);
        return true;
    }

    public function read($id)
    {
        $result = $this->link->query("SELECT session_Data FROM php_sessions WHERE session_Id = '" . $id . "' AND session_Expires > '" . date('Y-m-d H:i:s') . "'");
        if ($row = $result->fetch_assoc()) {
            return $row['session_Data'];
        } else {
            return "";
        }
    }

    public function write($id, $data)
    {
        $DateTime = date('Y-m-d H:i:s');
        $NewDateTime = date('Y-m-d H:i:s', strtotime($DateTime . ' + 1 hour'));
        $result = $this->link->query("REPLACE INTO php_sessions SET session_Id = '" . $id . "', session_Expires = '" . $NewDateTime . "', session_Data = '" . $data . "'");
        if ($result) {
            return true;
        } else {
            return false;
        }
    }

    public function destroy($id)
    {
        $result = $this->link->query("DELETE FROM php_sessions WHERE session_Id ='" . $id . "'");
        if ($result) {
            return true;
        } else {
            return false;
        }
    }

    public function gc($maxlifetime)
    {
        $result = $this->link->query("DELETE FROM php_sessions WHERE ((UNIX_TIMESTAMP(session_Expires) + " . $maxlifetime . ") < " . $maxlifetime . ")");
        if ($result) {
        return true;
        } else {
            return false;
        }
    }
}
