<?php

namespace App\Http\Middleware;
use Cookie;
use Illuminate\Auth\Middleware\Authenticate as Middleware;

class Authenticate extends Middleware
{
    /**
     * Get the path the user should be redirected to when they are not authenticated.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return string
     */
    protected $devices = ["127.0.0.1"=>"WiGSV SERVER"];
    protected function check($mac){
        if(in_array($mac, $this->alw))
            return true;
        return false;
    }
    
    protected function makeMyCookie($device)
    {
        return Cookie::queue(Cookie::make('device', $device, 1440));
    }
    protected function cook($request){
        $ip = $request->ip();
        $mac = $ip;
        if(Cookie::get('device')==null){

            if($ip != "127.0.0.1"){
                $macCommandString   =   "arp -a " . $ip ;
                $r = exec($macCommandString);
                $rs = explode(' ', $r);
                foreach ($rs as $s) {
                    if(substr_count($s, '-') == 5){
                        $mac = $s;
                    }
                }

            }
            else{
                $mac = $ip;


            }
            if(array_key_exists($mac, $this->devices))
                $this->makeMyCookie($this->devices[$mac]);


        }
        return $mac;
    }
    protected function redirectTo($request)
    {
     $this->cook($request);
     return route('login');
 }
}
