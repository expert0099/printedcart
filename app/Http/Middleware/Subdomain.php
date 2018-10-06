<?php 
/* namespace App\Http\Middleware;
use Auth;

class Subdomain 
{
	public function handle($request, $next)
	{
		$route = $request->route();
		$subdomain = $route->parameter('subdomain');
		$route->forgetParameter('subdomain');
		return $next($request);
	}
} */


namespace App\Http\Middleware;

use Illuminate\Session\Middleware\StartSession;
use Illuminate\Http\Request;

use App\SessionShare;

use Closure;

class StartSessionWithSharer extends StartSession
{

    /**
     * Get the session implementation from the manager.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Session\SessionInterface
     */
    public function getSession(Request $request)
    {
        $session = $this->manager->driver();

        /**
         * Check if we can find a valid session token from saved records
         */
        
            if($request->get('session_token') && !empty($request->get('session_token'))) {
                $sessionShare = SessionShare::valid()->whereToken($request->get('session_token'))->first();

                if($sessionShare)
                    $session_id = $sessionShare->session_id;
            }

        /**
         * Fallback to session in browser
         */
        
            if(!isset($session_id) || !$session_id)
                $session_id = $request->cookies->get($session->getName());

        $session->setId($session_id);

        return $session;
    }
}