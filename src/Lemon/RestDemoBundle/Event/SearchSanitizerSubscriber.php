<?php
namespace Lemon\RestDemoBundle\Event;

use Lemon\RestBundle\Event\PreSearchEvent;
use Lemon\RestBundle\Event\RestEvents;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;

class SearchSanitizerSubscriber implements EventSubscriberInterface
{
    public static function getSubscribedEvents()
    {
        return array(
            RestEvents::PRE_SEARCH => 'preSearch'
        );
    }

    public function preSearch(PreSearchEvent $event)
    {
        $q = $event->getCriteria()->get("q");

        if ($q) {
            $event->getCriteria()->remove("q");
            $event->getCriteria()->set("title", $q);
        }
    }
}
