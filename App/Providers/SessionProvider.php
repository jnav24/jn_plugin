<?php
namespace App\Providers;

class SessionProvider
{
    public $session = [];
    public static $instance = null;

    public static function getInstance()
    {
        if(is_null(self::$instance))
        {
            self::$instance = new self();
        }

        return self::$instance;
    }

    public function flash($key, $value)
    {
        $this->session['flash'][$key] = $value;
        $_SESSION[$key] = $value;
    }

    public function get($key)
    {
        $session = $_SESSION[$key];
        $this->delete($key);

        return $session;
    }

    public function has($key)
    {
        return isset($_SESSION[$key]);
    }

    public function put($key, $value)
    {
        $_SESSION[$key] = $value;
    }

    public function delete($key)
    {
        if($this->session['flash'][$key])
        {
            unset($this->session['flash'][$key]);
        }
        unset($_SESSION[$key]);
    }
}