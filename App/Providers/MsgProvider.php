<?php
namespace App\Providers;

class MsgProvider
{
    public static $instance = null;

    public static function getInstance()
    {
        if(is_null(self::$instance))
        {
            self::$instance = new self();
        }

        return self::$instance;
    }

    public function info($msg)
    {
        $this->message($msg, 'info');

        return $this;
    }

    public function success($msg)
    {
        $this->message($msg, 'success');

        return $this;
    }

    public function error($msg)
    {
        $this->message($msg, 'error');

        return $this;
    }

    public function warn($msg)
    {
        $this->message($msg, 'warning');

        return $this;
    }

    public function retain()
    {
        session()->flash('msg_notify.close', true);

        return $this;
    }

    public function message($msg, $class)
    {
        session()->flash('msg_notify.message', $msg);
        session()->flash('msg_notify.class', $class);

        return $this;
    }
}