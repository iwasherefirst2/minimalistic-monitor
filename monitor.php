<?php 

    $config = require __DIR__ .'/config.php';
    $db = new SQLite3($config['db']);

    if(empty($config['url'])){
        echo "URL missing in config.php.";
        echo PHP_EOL . "Abort." . PHP_EOL;
        return;
    }

    while(true){
        storeResult($config['url'], $db);
        sendAliveSignal($config['logFile']);
        sleep($config['sleepDuration']);
    }

    function storeResult($url, $db)
    {
        $curlHandle = curl_init($url);
        curl_setopt($curlHandle, CURLOPT_RETURNTRANSFER,1);

        if(curl_exec($curlHandle))
        {
            $info = curl_getinfo($curlHandle);
            $data = [
                'null',
                true,
                $info['http_code'],
                $info['total_time'],
                $info['namelookup_time'],
            ];
            $values = '(' . implode(',', $data) . ')';
            $db->query("INSERT INTO requests (id, available, http_code, duration_request, duration_dns) VALUES $values" );
            return;
        }

        $db->query('INSERT INTO requests (id, available) VALUES (null, false)');

        curl_close($curlHandle);
    }

    function sendAliveSignal($logFile)
    {
        // I am not using FILE_APPEND flag of file_put_contents
        // because I want my logs to be on the top of the file
        $logs = file_get_contents($logFile);
        $logs = 'Still alive at ' . date('Y-m-d H:i:s') . PHP_EOL . $logs;
        file_put_contents('monitor.log', $logs);
    }
