<?php
// This is a singleton class for maintaining a single connection to the Memcache server
class MC {
     private static $instance; //The single instance
     public $m;
     public $hostname;
     
      private function setHostname()
    {
        if (getenv("CACHE_HOSTNAME") == "")
        {
            $this->hostname = trim(file_get_contents("/etc/CACHE_HOSTNAME"));
        } else
        {
            $this->hostname = trim(getenv("CACHE_HOSTNAME"));
        }

    }
    // Function returns the single instance of this class

      public static function getInstance()
    {
        if (!self::$instance)
        { // If no instance then make one
            self::$instance = new self();
        }
        return self::$instance;
    }
    
    // Constructor
    private function __construct()
    {
        $this->setHostname();
        try
        {
        $this->m = new Memcached();
        $this->m->addServer($this->hostname, 11211);    

        }

        catch (PDOException $e)
        {
            error_log($e->getMessage());
        }
    }
}



?>