<?php

namespace Recca0120\Elfinder;

use elFinderSessionInterface;
use Illuminate\Session\SessionManager;

class Session implements elFinderSessionInterface
{
    /**
     * $session.
     *
     * @var \\Illuminate\Session\SessionInterface
     */
    protected $session;

    /**
     * __construct.
     *
     * @param \Illuminate\Session\SessionManager $sessionManager
     */
    public function __construct(SessionManager $sessionManager)
    {
        $this->session = $sessionManager->driver();
    }

    /**
     * Session start.
     *
     * @return $this
     **/
    public function start()
    {
        $this->session->start();

        return $this;
    }

    /**
     * Session write & close.
     *
     * @return $this
     **/
    public function close()
    {
        $this->session->save();

        return $this;
    }

    /**
     * Get session data.
     *
     * This method must be equipped with an automatic start / close.
     *
     * @param string $key
     * @param mixed $empty
     * @return mixed
     **/
    public function get($key, $empty = '')
    {
        return $this->session->get($key, $empty);
    }

    /**
     * Set session data.
     *
     * This method must be equipped with an automatic start / close.
     *
     * @param string $key
     * @param mixed $data
     * @return $this
     **/
    public function set($key, $data)
    {
        $this->session->put($key, $data);

        return $this;
    }

    /**
     * Get session data.
     *
     * @param string $key
     * @return $this
     **/
    public function remove($key)
    {
        $this->session->remove($key);

        return $this;
    }
}
