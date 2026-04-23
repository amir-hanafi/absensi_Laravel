<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;


use App\Models\Ticket;
use App\Models\AutoReply;
use App\Models\TicketResponse;
use Illuminate\Support\Facades\Auth;
use App\Models\Category;
use App\Models\SatisfactionRating;


class TicketController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $data = Ticket::latest()->get();

        return view('tickets.index', [
            'title' => 'Data Ticket',
            'data' => $data,
            'createRoute' => route('tickets.create')
        ]);
    }



    public function storeResponse(Request $request, $ticketId)
    {
        TicketResponse::create([
            'ticket_id' => $ticketId,
            'responder_id' => Auth::id(),
            'message' => $request->message,
            'is_auto_reply' => false
        ]);

        $ticket = Ticket::find($ticketId);

        if ($ticket->status == 'open') {
            $ticket->update([
                'status' => 'in_progress',
                'operator_id' => Auth::id()
            ]);
        }

        return back()->with('success', 'Response dikirim');
    }


    /**
     * Show the form for creating a new resource.
     */


    public function create()
    {
        return view('tickets.create', [
            'title' => 'Buat Ticket',
            'categories' => Category::all()
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */


    public function store(Request $request)
    {
        $inputText = strtolower($request->subject . ' ' . $request->description);

        $existingTickets = Ticket::all();

        $similarTickets = $existingTickets->filter(function ($ticket) use ($inputText) {

            $dbText = strtolower($ticket->subject . ' ' . $ticket->description);

            similar_text($inputText, $dbText, $percent);

            return $percent >= 60;
        });

        // 🔥 kalau ada duplikasi
        if ($similarTickets->count() && !$request->force) {
            return back()
                ->withInput()
                ->with('similar', $similarTickets);
        }

        // simpan ticket
        Ticket::create([
            'reporter_id' => Auth::id(),
            'subject' => $request->subject,
            'description' => $request->description,
            'category_id' => $request->category_id,
            'priority' => $request->priority,
            'status' => 'open'
        ]);

        return redirect()->route('tickets.index')
            ->with('success', 'Ticket berhasil dibuat');
    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        $ticket = Ticket::with(['category', 'responses'])->findOrFail($id);

        $replies = [];

        if ($ticket->category_id) {
            $replies = AutoReply::where('category_id', $ticket->category_id)->get();
        }

        return view('tickets.show', [
            'title' => 'Detail Ticket',
            'ticket' => $ticket,
            'replies' => $replies
        ]);
    }

    public function myTickets()
    {
        $data = Ticket::where('reporter_id', Auth::id())->get();

        return view('tickets.index', compact('data'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }

    public function close($id)
    {
        $ticket = Ticket::findOrFail($id);

        $ticket->update([
            'status' => 'closed'
        ]);


        return redirect()->route('tickets.index')->with('success', 'Ticket selesai');
    }

    public function storeRating(Request $request, $id)
    {
        SatisfactionRating::create([
            'ticket_id' => $id,
            'score' => $request->score,
            'feedback' => $request->feedback
        ]);

        return back()->with('success', 'Terima kasih atas penilaian Anda');
    }
}
