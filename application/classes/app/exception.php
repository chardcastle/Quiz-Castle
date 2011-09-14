<?php defined('SYSPATH') or die('No direct script access.');

class App_Exception
{
    public static function handle(Exception $e)
    {
        switch (get_class($e))
        {
            case 'Http_Exception_404':
                $response = new Response;
                $response->status(404);
                $view = new View('error_404');
                $view->message = $e->getMessage();
                $view->title = 'File Not Found';
                echo $response->body($view)->send_headers()->body();
                return TRUE;
                break;
            default:
                $response = new Response;
                $response->status(500);
                $view = new View('error');
                $view->message = $e->getMessage();
				// Get the exception information
				$view->type    = get_class($e);
				$view->code    = $e->getCode();
				$view->message = $e->getMessage();
				$view->file    = $e->getFile();
				$view->line    = $e->getLine();
				// Get the exception backtrace
				$view->trace = $e->getTrace();
                echo $response->body($view)->send_headers()->body();
                return TRUE;
                break;
        }
    }
}
