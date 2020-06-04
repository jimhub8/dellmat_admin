<?php
namespace App\Http\Middleware;
use Closure;
class Cors
{
   public function handle($request, Closure $next)
   {
      //allow origin only wildcard domain and root domain
      if (preg_match('/(\.|^)your-domain\.com/', $request->getHost())) {
         $origin = $request->headers->get('Origin');
      } else {
         $origin = 'http://localhost:3000';
      }

      header('Access-Control-Allow-Origin: ' . $origin);
      header('Access-Control-Allow-Methods: GET, POST, PATCH, PUT, DELETE, OPTIONS');
      header('Access-Control-Allow-Headers: *');
   }
}
