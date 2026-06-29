<?php

namespace App\Http\Controllers;

use App\Models\Event;
use Illuminate\Http\Request;

class EventController extends Controller
{
    public function index()
    {
        $events = Event::latest()->get();
        return view('events.index', compact('events'));
    }

    public function create()
    {
        return view('events.create');
    }

    public function store(Request $request)
    {
        Event::create([
            'title' => $request->title,
            'event_date' => $request->event_date,
            'is_active' => false
        ]);

        return redirect('/events');
    }

    public function edit($id)
    {
        $event = Event::findOrFail($id);

        return view('events.edit', compact('event'));
    }

    public function update(Request $request, $id)
    {
        $event = Event::findOrFail($id);

        $event->update([
            'title' => $request->title,
            'event_date' => $request->event_date
        ]);

        return redirect('/events');
    }

    public function destroy($id)
    {
        Event::findOrFail($id)->delete();

        return redirect('/events');
    }

    public function activate($id)
    {
        Event::query()->update([
            'is_active' => false
        ]);

        Event::findOrFail($id)->update([
            'is_active' => true
        ]);

        return redirect('/events');
    }
}