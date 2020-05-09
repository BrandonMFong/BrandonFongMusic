<?php
    global $Connected;
    $Connected = false;
    function GetCorrectEnvironment(string $ConfigEnv)
    {
        $val = 0;
        foreach($GLOBALS['VarXml']->Credentials->Credential as $cred)
        {
            if($ConfigEnv == $cred['Environment']){$val = $cred;}
        }
        return $val;
    }

    function GetVariables()
    {
        $x = GetCred($GLOBALS['WebConfig']->Environment);

        $GLOBALS['servername'] = $x->Servername;
        $GLOBALS['username'] = $x->Username;
        $GLOBALS['password'] = $x->Password;
        $GLOBALS['dbname'] = $x->Database;
    }

    function Connect()
    {
        $GLOBALS['conn'] = new mysqli($GLOBALS['servername'], $GLOBALS['username'], $GLOBALS['password'], $GLOBALS['dbname']);
        if ($GLOBALS['conn']->connect_error) {die("Connection failed: " . $GLOBALS['conn']->connect_error);}
        else{$Connected = true;}
    }

    function Close(){$GLOBALS['conn']->close();}

    function QueryByFile(string $filepath) 
    {
        if(!$Connected){Connect();}
        $sqlfile =  fopen($filepath, "r") or die("Unable to read file.");
        Query(fread($sqlfile, filesize("sql/GetBio.sql")));
    }

    function Query(string $querystring)
    {
        if(!$Connected){Connect();}
        $GLOBALS['Results'] = $GLOBALS['conn']->query($querystring);
        if ($GLOBALS['Results']->num_rows == 0) {echo "0 results";}
        Close();
    }
?>