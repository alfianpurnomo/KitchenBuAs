<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * Exceptions Class Extension
 * @author ivan lubis <ivan.z.lubis@gmail.com>
 * @version 3.0
 * @category Core
 * @desc extending exceptions class for customize error page
 * 
 */

class FAT_Exceptions extends CI_Exceptions {
    
    protected $CI;
    private $loader;

    /**
     * load the constructor
     */
    public function __construct() {
        parent::__construct();
        $this->CI =& get_instance();
        $this->loader =& load_class('Loader','core');
    }

    // --------------------------------------------------------------------

    /**
     * General Error Page
     *
     * Takes an error message as input (either as a string or an array)
     * and displays it using the specified template.
     *
     * @param	string		$heading	Page heading
     * @param	string|string[]	$message	Error message
     * @param	string		$template	Template name
     * @param 	int		$status_code	(default: 500)
     *
     * @return	string	Error page output
     */
    public function show_error($heading, $message, $template = 'error_general', $status_code = 500) {
        $templates_path = config_item('error_views_path');
        if (empty($templates_path)) {
            $templates_path = VIEWPATH . 'default'.DIRECTORY_SEPARATOR.'errors' . DIRECTORY_SEPARATOR;
        }
        
        if (is_cli()) {
            $message = "\t" . (is_array($message) ? implode("\n\t", $message) : $message);
            $template = 'cli' . DIRECTORY_SEPARATOR . $template;
        } else {
            set_status_header($status_code);
            $message = '<p>' . (is_array($message) ? implode('</p><p>', $message) : $message) . '</p>';
            $template = 'html' . DIRECTORY_SEPARATOR . $template;
        }

        if (ob_get_level() > $this->ob_level + 1) {
            ob_end_flush();
        }
        ob_start();
        include($templates_path . $template . '.php');
        $buffer = ob_get_contents();
        ob_end_clean();
        return $buffer;
    }

    // --------------------------------------------------------------------

    public function show_exception(Exception $exception) {
        $templates_path = config_item('error_views_path');
        if (empty($templates_path)) {
            $templates_path = VIEWPATH . 'default'.DIRECTORY_SEPARATOR.'errors' . DIRECTORY_SEPARATOR;
        }

        $message = $exception->getMessage();
        if (empty($message)) {
            $message = '(null)';
        }

        if (is_cli()) {
            $templates_path .= 'cli' . DIRECTORY_SEPARATOR;
        } else {
            set_status_header(500);
            $templates_path .= 'html' . DIRECTORY_SEPARATOR;
        }

        if (ob_get_level() > $this->ob_level + 1) {
            ob_end_flush();
        }

        ob_start();
        include($templates_path . 'error_exception.php');
        $buffer = ob_get_contents();
        ob_end_clean();
        echo $buffer;
    }

    // --------------------------------------------------------------------

    /**
     * Native PHP error handler
     *
     * @param	int	$severity	Error level
     * @param	string	$message	Error message
     * @param	string	$filepath	File path
     * @param	int	$line		Line number
     * @return	string	Error page output
     */
    public function show_php_error($severity, $message, $filepath, $line) {
        $templates_path = VIEWPATH . 'default'.DIRECTORY_SEPARATOR.'errors' . DIRECTORY_SEPARATOR;
        
        $severity = isset($this->levels[$severity]) ? $this->levels[$severity] : $severity;

        // For safety reasons we don't show the full file path in non-CLI requests
        if (!is_cli()) {
            $filepath = str_replace('\\', '/', $filepath);
            if (FALSE !== strpos($filepath, '/')) {
                $x = explode('/', $filepath);
                $filepath = $x[count($x) - 2] . '/' . end($x);
            }

            $template = 'html' . DIRECTORY_SEPARATOR . 'error_php';
        } else {
            $template = 'cli' . DIRECTORY_SEPARATOR . 'error_php';
        }

        if (ob_get_level() > $this->ob_level + 1) {
            ob_end_flush();
        }
        ob_start();
        include($templates_path . $template . '.php');
        $buffer = ob_get_contents();
        ob_end_clean();
        echo $buffer;
    }

}
