<?php
/**
 * Created by PhpStorm.
 * User: PiotrTutak
 * Date: 06.11.2017
 * Time: 11:18
 */

namespace AppBundle\EventListener;


use ADesigns\CalendarBundle\Event\CalendarEvent;
use ADesigns\CalendarBundle\Entity\EventEntity;
use AppBundle\Entity\data_urlop;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Security\Core\Authentication\Token\Storage\TokenStorage;

class CalendarEventListener
{
    private $entityManager;
    private $tokenStorage;

    public function __construct(EntityManagerInterface $entityManager,TokenStorage $tokenStorage)
    {
        $this->entityManager = $entityManager;
        $this->tokenStorage= $tokenStorage;
    }

    public function loadEvents(CalendarEvent $calendarEvent)
    {
        $events = $this->entityManager->getRepository(data_urlop::class)->getUserDataUrlops($this->tokenStorage->getToken()->getUser());

        $startDate = $calendarEvent->getStartDatetime();
        $endDate = $calendarEvent->getEndDatetime();

        foreach ( $events as $event ){
            /**
             * @var data_urlop $event
             */
            $eventEntity = new EventEntity("Urlop",$event->getData(),$event->getData());

            $eventEntity->setAllDay(true); // default is false, set to true if this is an all day event
            $eventEntity->setBgColor('#FF0000'); //set the background color of the event's label
            $eventEntity->setFgColor('#FFFFFF'); //set the foreground color of the event's label
            $eventEntity->setUrl('http://www.google.com'); // url to send user to when event label is clicked
            $eventEntity->setCssClass('calendar_day'); // a custom class you may want to apply to event labels
            $calendarEvent->addEvent($eventEntity);
        }
        // The original request so you can get filters from the calendar
        // Use the filter in your query for example

//        $request = $calendarEvent->getRequest();

        // load events using your custom logic here,
        // for instance, retrieving events from a repository
        $eventEntity = new EventEntity("Hello", new \DateTime("2017-11-11"), new \DateTime("2017-11-11"));

        //optional calendar event settings
        $eventEntity->setAllDay(true); // default is false, set to true if this is an all day event
        $eventEntity->setBgColor('#000000'); //set the background color of the event's label
        $eventEntity->setFgColor('#FFFFFF'); //set the foreground color of the event's label
        $eventEntity->setUrl('http://www.google.com'); // url to send user to when event label is clicked
        $eventEntity->setCssClass('calendar_day'); // a custom class you may want to apply to event labels

        //finally, add the event to the CalendarEvent for displaying on the calendar
        $calendarEvent->addEvent($eventEntity);
    }
}