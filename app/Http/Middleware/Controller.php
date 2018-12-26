<?php

namespace App\Http\Middleware;
use Illuminate\Support\Facades\Route;
use Closure;

class Controller
{
    protected $alw = ["127.0.0.1"];
    protected function ok($request,$m){
        return in_array($m, $this->alw);
    }
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {

        $mac = $request->ip();
        if($mac != "127.0.0.1"){
            $macCommandString   =   "arp -a " . $mac ;
            $r = exec($macCommandString);
            $rs = explode(' ', $r);
            foreach ($rs as $s) {
                if(substr_count($s, '-') == 5){
                    $mac = $s;
                }
            }

        }
        return $this->ok($request,$mac) ? $next($request) : redirect()->route('Buy');
    }
}
