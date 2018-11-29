<?php
/**
 * Created by Aaron Zhang.
 * Date: 2017/12/19 22:44
 * FileName : MY_Router.php
 */

class MY_Router extends CI_Router
{
    public $is_manager;

    public function __construct ()
    {
        $this->method = 'index';
        parent::__construct();
    }


    // --------------------------------------------------------------------

    /**
     * Set request route
     *
     * Takes an array of URI segments as input and sets the class/method
     * to be called.
     *
     * @used-by	CI_Router::_parse_routes()
     * @param	array	$segments	URI segments
     * @return	void
     */
    protected function _set_request($segments = array())
    {

        $segments = $this->_validate_request($segments);
        // If we don't have any segments left - try the default controller;
        // WARNING: Directories get shifted out of the segments array!
        if (empty($segments))
        {
            $this->_set_default_controller();
            return;
        }

        if ($this->translate_uri_dashes === TRUE)
        {
            $segments[0] = str_replace('-', '_', $segments[0]);
            if (isset($segments[1]))
            {
                $segments[1] = str_replace('-', '_', $segments[1]);
            }
        }
        $this->set_class($segments[0]);
        if (isset($segments[1]))
        {
            $this->set_method($segments[1]);
        }
        else
        {
            $segments[1] = 'index';
        }

        array_unshift($segments, NULL);
        unset($segments[0]);

        $this->uri->rsegments = $segments;
    }

    // --------------------------------------------------------------------

    /**
     * Set default controller
     *
     * @return	void
     */
    protected function _set_default_controller()
    {
        if (empty($this->default_controller))
        {
            show_error('Unable to determine what should be displayed. A default route has not been specified in the routing file.');
        }

        // Is the method being specified?
        if (sscanf($this->default_controller, '%[^/]/%s', $class, $method) !== 2)
        {
            $method = 'index';
        }

        if ( ! file_exists(APPPATH.'controllers/'.$this->directory.ucfirst($class).'.php'))
        {
            // This will trigger 404 later
            return;
        }

        $this->set_class($class);
        $this->set_method($method);

        // Assign routed segments, index starting from 1
        $this->uri->rsegments = array(
            1 => $class,
            2 => $method
        );

        log_message('debug', 'No URI present. Default controller set.');
    }
}