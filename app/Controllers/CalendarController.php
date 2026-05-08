<?php

namespace App\Controllers;

use App\Models\Event;

class CalendarController {
    public function index() {
        $eventModel = new Event();
        $allEvents = $eventModel->all();

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
            'title'  => 'Program Calendar - GibelFm',
            'events' => $events
        ]);
    }
}
