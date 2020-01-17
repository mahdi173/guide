<?php

namespace App\EventListener;

use Symfony\Component\HttpKernel\Event\RequestEvent;

class RequestListener
{
    public function onKernelRequest(RequestEvent $event)
    {
        $listbots = array(
            "Googlebot",
            "Google Favicon",
            "Google PageSpeed Insights",
            "Google Partner Monitoring",
            "Google Search Console",
            "Google Structured Data Testing Tool",
        );
        if (!$event->isMasterRequest()) {
            return;
        }
        $bots=implode('|',$listbots);
        if(strpos(strtolower($_SERVER['HTTP_USER_AGENT']), $bots))
        {
            return true;
        }else{ return; }
    }
}
