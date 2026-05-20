<?php

namespace App\Controllers;

use App\Models\Event;

class CalendarController {
    public function index() {
        $eventModel = new Event();
        $allEvents = $eventModel->all();

        $today = date('Y-m-d');
        $upcomingEvent = $eventModel->upcoming();
        $upcomingDate = $upcomingEvent['event_date'] ?? null;

        // Group events by date for the calendar view
        $events = [];
        foreach ($allEvents as $event) {
            $date = $event['event_date'];
            if (!isset($events[$date])) {
                $events[$date] = [];
            }
            $events[$date][] = [
                'title' => $event['title'],
                'type'  => $event['type'],
            ];
        }

        view('calendar', [
            'title'  => 'Kalender Program - GibelFm',
            'events' => $events,
            'today' => $today,
            'upcomingDate' => $upcomingDate,
        ]);
    }
}
