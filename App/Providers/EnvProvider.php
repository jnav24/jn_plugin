<?php
namespace App\Providers;

class EnvProvider
{
	private $file = '.env';
	private $path = __DIR__;
	public $loadDefaults = false;

	public function setPath($path)
	{
		if(!file_exists($path . $this->file))
		{
			$this->loadDefaults = true;
			return;
		}

		$this->path = $path;
	}

	public function load()
	{
		$this->setEnv($this->getFileContents());
	}

	private function getFileContents()
	{
		return trim(file_get_contents(rtrim($this->path,'/') .'/'. $this->file));
	}

	private function setEnv($env)
	{
		$env = explode("\n", $env);
		foreach($env as $value)
		{
            if(!empty($value)) 
            {
                putenv($value);
            }
		}
	}

	public static function getEnv($value, $default = '')
	{
        $env = getenv($value);
        
        if(!$env)
        {
            return $default;
        }
		
        return $env;
	}
}
