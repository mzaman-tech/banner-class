<?php
class Banner
{
    
    public $isDisplay, $startTime, $endTime, $IP;
    private $allowedIPs = ["10.0.0.1", "10.0.0.2"];
    
    /**
    * class constructor  
    */
    public function __construct($startTime, $endTime)
    {
        $this->IP = $this->getUserIP();
        $this->setTime($startTime, $endTime);
        
    }


    /**
    * set the start and end time  
    */
    public function setTime($startTime, $endTime)
    {
        if($startTime > $endTime)
        {
            $this->setStartTime($endTime);
            $this->setEndTime($startTime);
        }
        else
        {
            $this->setStartTime($startTime);
            $this->setEndTime($endTime);
        }
        
    }

    /**
    * set the start time  
    */
    public function setStartTime($startTime)
    {
        $this->startTime = $this->convertTime($startTime);
    }


    /**
    * set the end time  
    */
    public function setEndTime($endTime)
    {
        $this->endTime = $this->convertTime($endTime);
    }


    /**
    * set the IP address  
    */
    public function setIpAddress($ip)
    {
        $this->IP = $ip;
    }


    /**
    * Converts the dateTime is Y/m/d H:i:s format  
    */
    public function convertTime($time)
    {
        return date("Y/m/d H:i:s", strtotime($time));
    }

    /**
    * returns the start time  
    */
    public function getStartTime()
    {
        return $this->startTime;
    }

    /**
    * returns the end time 
    */
    public function getEndTime()
    {
        return $this->endTime;
    }


    /**
    * returns the IP address 
    */
    public function getIpAddress()
    {
        return $this->IP;
    }


    /**
    * returns the banner if isDisplay is set  
    */
    public function display()
    {
        return ($this->isDisplay) ? true : false;
    }

    /**
    * Checks IP address and current time to set isDisplay  
    */
    public function update()
    {
        $current_time = $this->convertTime(date('Y/m/d H:i:s'));
        if ($this->checkIp() && ($current_time < $this->endTime))
        {
            $this->isDisplay = true;
        }
        elseif(!($this->checkIp()) && ($current_time > $this->startTime) && ($current_time < $this->endTime))
        {
            $this->isDisplay = true;
        }
        else
        {
            $this->isDisplay = false;
        }

        $this->display();
    }

    /**
    * returns true if the IP is allowed
    */
    public function checkIp()
    {
        return (in_array($this->IP, $this->allowedIPs)) ? true : false;
    }
    
    /**
    * returns user IP address
    */

    public function getUserIP()
    {
        if (!empty($_SERVER['HTTP_CLIENT_IP'])) 
        {
            $IP = $_SERVER['HTTP_CLIENT_IP'];
        } 
        elseif (!empty($_SERVER['HTTP_X_FORWARDED_FOR']))
        {
            $IP = $_SERVER['HTTP_X_FORWARDED_FOR'];
        } 
        else 
        {
            $IP = $_SERVER['REMOTE_ADDR'];
        }
        return $IP;
    }
}

