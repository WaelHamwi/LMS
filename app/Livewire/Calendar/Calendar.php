<?php

namespace App\Livewire\Calendar;

use App\Models\Event;
use Livewire\Component;
use Carbon\Carbon;


class Calendar extends Component
{
    public $events = '';
    public function render()
    {
        $this->events = Event::select('id', 'name as title', 'start_date as start', 'end_date as end')
            ->get()
            ->map(function ($event) {
                $event->start = Carbon::parse($event->start)->toIso8601String();
                $event->end = Carbon::parse($event->end)->toIso8601String();
                return $event;
            })
            ->toArray();

        return view('livewire.calendar.calendar', ['events' => $this->events]);
    }

    public function getevent()
    {
        $events = Event::select('id', 'name as title', 'start_date as start', 'end_date as end')
            ->get();


        return  json_encode($events);
    }
    public function addevent($name, $start, $end)
    {
        $start = Carbon::parse($start)->format('Y-m-d H:i:s');
        $end = Carbon::parse($end)->format('Y-m-d H:i:s');
        $event = Event::create([
            'name' => $name,
            'start_date' => $start,
            'end_date' => $end,
        ]);
        return $event->id;
    }
    public function eventDrop($event, $oldEvent)
    {
        $eventdata = Event::find($event['id']);
        $eventdata->start_date = $event['start_date'];
        $eventdata->save();
    }
    public function updateEvent($id, $name, $start, $end)
    {
        $start = Carbon::parse($start)->format('Y-m-d H:i:s');
        $end = Carbon::parse($end)->format('Y-m-d H:i:s');

        $event = Event::find($id);
        if ($event) {
            $event->name = $name ?: $event->name;
            $event->start_date = $start;
            $event->end_date = $end;
            $event->save();
        }
    }
}
