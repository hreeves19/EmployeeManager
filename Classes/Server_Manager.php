<?php
/**
 * Created by PhpStorm.
 * User: Court
 * Date: 11/22/2018
 * Time: 7:30 PM
 */

class Server_Manager
{
    // Class Variables
    private $diskUsage;
    private $disktotal;
    private $diskfree;
    private $diskFormat;
    private $diskRemaining;
    private $cpuLoad;
    private $memory;

    /**
     * Server_Manager constructor.
     */
    public function __construct()
    {
        // Getting disk info in bits
        $this->disktotal = disk_total_space ('C:');
        $this->diskfree  = disk_free_space  ('C:');

        // Converting memory to either bytes, kilobytes, megabytes, gigabyte
        $this->disktotal = $this->convertMemorySizes($this->disktotal);
        $this->diskfree = $this->convertMemorySizes($this->diskfree);
        $this->diskRemaining = (float) $this->disktotal - (float) $this->diskfree;

        $this->diskUsage   = round (100 - (($this->diskfree / $this->disktotal) * 100));
    }

    /**
     * @return float
     */
    public function getDiskRemaining()
    {
        return $this->diskRemaining;
    }

    /**
     * @return mixed
     */
    public function getDiskUsage()
    {
        return $this->diskUsage;
    }

    /**
     * @param mixed $diskUsage
     */
    public function setDiskUsage($diskUsage)
    {
        $this->diskUsage = $diskUsage;
    }

    /**
     * @return mixed
     */
    public function getCpuLoad()
    {
        return $this->cpuLoad;
    }

    /**
     * @param mixed $cpuLoad
     */
    public function setCpuLoad()
    {
        $cpuLoad = $this->getServerLoad();

        // checking to see if its null
        if (is_null($cpuLoad)) {
            echo "CPU load not estimateable (maybe too old Windows or missing rights at Linux or Windows)";
            $this->cpuLoad = null;
        }
        else {
            $this->cpuLoad = $cpuLoad;
        }
    }

    /**
     * @return mixed
     */
    public function getMemory()
    {
        return $this->memory;
    }

    /**
     * @param mixed $memory
     */
    public function setMemory()
    {
        // Setting function to true
        $mem = memory_get_usage(true);

        // Bytes
        if ($mem < 1024) {

            $memory = $mem .' B';

        }

        // Kilobytes
        else if ($mem < 1048576) {

            $memory = round($mem / 1024, 2) .' KB';

        }

        // Megabytes
        else {

            $memory = round($mem / 1048576, 2) .' MB';

        }

        $this->memory = $memory;
    }

    /**
     * @return bool|float
     */
    public function getDisktotal()
    {
        return $this->disktotal;
    }

    /**
     * @return bool|float
     */
    public function getDiskfree()
    {
        return $this->diskfree;
    }

    /**
     * @return mixed
     */
    public function getDiskFormat()
    {
        return $this->diskFormat;
    }

    public function convertMemorySizes($mem)
    {
        // Bytes
        if ($mem < 1024) {

            $memory = $mem;
            $this->diskFormat = "B";

        }

        // Kilobytes
        else if ($mem < 1048576)
        {

            $memory = round($mem / 1024, 2);
            $this->diskFormat = "KB";

        }

        // Megabytes
        else if ($mem <  1073741824)
        {

            $memory = round($mem / 1048576, 2);
            $this->diskFormat = "MB";

        }

        else
        {
            $memory = round($mem / 1073741824, 2);
            $this->diskFormat = "GB";
        }

        return $memory;
    }

    /******************************************************/
    // From PHP documentation comment found on this url
    // http://php.net/manual/en/function.sys-getloadavg.php
    public function _getServerLoadLinuxData()
    {
        if (is_readable("/proc/stat"))
        {
            $stats = @file_get_contents("/proc/stat");

            if ($stats !== false)
            {
                // Remove double spaces to make it easier to extract values with explode()
                $stats = preg_replace("/[[:blank:]]+/", " ", $stats);

                // Separate lines
                $stats = str_replace(array("\r\n", "\n\r", "\r"), "\n", $stats);
                $stats = explode("\n", $stats);

                // Separate values and find line for main CPU load
                foreach ($stats as $statLine)
                {
                    $statLineData = explode(" ", trim($statLine));

                    // Found!
                    if
                    (
                        (count($statLineData) >= 5) &&
                        ($statLineData[0] == "cpu")
                    )
                    {
                        return array(
                            $statLineData[1],
                            $statLineData[2],
                            $statLineData[3],
                            $statLineData[4],
                        );
                    }
                }
            }
        }

        return null;
    }

    // Returns server load in percent (just number, without percent sign)
    public function getServerLoad()
    {
        $load = null;

        if (stristr(PHP_OS, "win"))
        {
            $cmd = "wmic cpu get loadpercentage /all";
            @exec($cmd, $output);

            if ($output)
            {
                foreach ($output as $line)
                {
                    if ($line && preg_match("/^[0-9]+\$/", $line))
                    {
                        $load = $line;
                        break;
                    }
                }
            }
        }
        else
        {
            if (is_readable("/proc/stat"))
            {
                // Collect 2 samples - each with 1 second period
                // See: https://de.wikipedia.org/wiki/Load#Der_Load_Average_auf_Unix-Systemen
                $statData1 = $this->_getServerLoadLinuxData();
                sleep(1);
                $statData2 = $this->_getServerLoadLinuxData();

                if
                (
                    (!is_null($statData1)) &&
                    (!is_null($statData2))
                )
                {
                    // Get difference
                    $statData2[0] -= $statData1[0];
                    $statData2[1] -= $statData1[1];
                    $statData2[2] -= $statData1[2];
                    $statData2[3] -= $statData1[3];

                    // Sum up the 4 values for User, Nice, System and Idle and calculate
                    // the percentage of idle time (which is part of the 4 values!)
                    $cpuTime = $statData2[0] + $statData2[1] + $statData2[2] + $statData2[3];

                    // Invert percentage to get CPU time, not idle time
                    $load = 100 - ($statData2[3] * 100 / $cpuTime);
                }
            }
        }

        return $load;
    }
    /******************************************************/
}