<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

use App\Models\AdminRole;
use App\Models\DataUser;
use App\Models\Obat;
use App\Models\Artikel;

use App\Models\User;
use App\Models\Category;
use App\Models\Ticket;
use App\Models\TicketReply;
use App\Models\users;


class Dashboard extends Controller
{
    public function __construct()
    {
    }


    public function index()
    {
        if (empty(session('type'))) {
            return redirect()->route('login');
        }

        $data = [
            "title" => "TicketingSchema",
        ];
        return view("dashboard.dashboard", $data);
    }

    public function create_ticket()
    {
        $kolom = "subject, id_category, id_assign, priority, description, attachment";
        $kolomCaption = "Subject, Category, Assign Division, Priority,  Description, Attachment";

        $data = [
            "title" => "Aplikasi TicketingSchema",
            "subtitle" => "Admin",
            "assign" => User::where('type', '=', 'division')->get(),
            "category" => Category::all(),
            "kolomTable" => explode(', ', $kolom),
            "kolomCaption" => explode(', ', $kolomCaption),
            "post" => "post_ticket",
            "delete" => "delete_ticket",
            "file" => "attachment"
        ];
        return view("dashboard.create", $data);
    }

    public function post_ticket(Request $request)
    {

        $kolom = "id_user, subject, id_category, id_assign, priority, description, attachment";

        $kolomTable = explode(', ', $kolom);
        $data = array();
        $ticket = new Ticket();
        foreach ($kolomTable as $key => $value) {
            if ($value == 'id_user') {
                $ticket->$value = session('id');
            } elseif ($value == 'attachment') {
                // $foto_kunjungan = $request->file('post_image');

                if ($request->hasFile('attachment')) {
                    $file = $request->file('attachment');
                    $attachment = time() . '.' . $file->getClientOriginalExtension();
                    // $destinationPath = public_path('/upload_manual');
                    $file->move('upload_manual', $attachment);
                }

                if (!empty($attachment)) {
                    $ticket->$value = empty($attachment) == true ? "-" : $attachment;
                }
            } elseif ($value == 'post_date') {
                $valueCell = date('Y-m-d', strtotime($request->$value));
                $ticket->$value = empty($valueCell) == true ? "-" : $valueCell;
            } else {
                $valueCell = $request->$value;
                $ticket->$value = empty($valueCell) == true ? "-" : $valueCell;
            }
        }
        $ticket->status = "open";
        $ticket->save();

        return back()->withSuccess('Success! Your ticket has been send.');
    }

    public function delete_ticket($id)
    {
        $ticket = Ticket::find($id);
        $ticket->delete();
        return back()->withSuccess('Success! Ticket has been delete.');
    }

    public function all_ticket()
    {
        switch (session('type')) {
            case 'admin':
                $kolom = "user, subject, priority, category, created_at, status, assigned";
                $kolomCaption = "User, Subject, Priority, Category, Date, Status, Assigned";
                // $dataUser = Ticket::all();
                $dataUser = DB::table('ticket as t')
                    ->join('user as u', 't.id_user', '=', 'u.id')
                    ->join('user as u_assigned', 't.id_assign', '=', 'u_assigned.id')
                    ->join('category as c', 't.id_category', '=', 'c.id')
                    // ->leftjoin('ticket_reply as r', 't.id', '=', 'r.id_ticket')
                    // ->latest('r.created_at')
                    ->select('t.*', 'c.category_name as category', 'u.fullname as user', 'u_assigned.fullname as assigned', 't.updated_at as last_reply')
                    ->orderBy('t.id','DESC')
                    ->get();
                break;

            case 'user':
                $kolom = "subject, priority, category, created_at, status, assigned, last_reply";
                $kolomCaption = "Subject, Priority, Category, Date, Status, Assigned, Last Reply";
                // $dataUser = Ticket::all();
                $dataUser = DB::table('ticket as t')
                    ->join('user as u', 't.id_user', '=', 'u.id')
                    ->join('user as u_assigned', 't.id_assign', '=', 'u_assigned.id')
                    ->join('category as c', 't.id_category', '=', 'c.id')
                    // ->leftjoin('ticket_reply as r', 't.id', '=', 'r.id_ticket')
                    // ->latest('r.created_at')
                    ->select('t.*', 'c.category_name as category', 'u.fullname as user', 'u_assigned.fullname as assigned', 't.updated_at as last_reply')
                    ->where('t.id_user', '=', session('id'))
                    ->orderBy('t.id','DESC')
                    ->get();
                break;

            case 'division':
                $kolom = "user, subject, priority, category, created_at, status, last_reply";
                $kolomCaption = "User, Subject, Priority, Category, Date, Status, last_reply";
                // $dataUser = Ticket::all();
                $dataUser = DB::table('ticket as t')
                    ->join('user as u', 't.id_user', '=', 'u.id')
                    ->join('user as u_assigned', 't.id_assign', '=', 'u_assigned.id')
                    ->join('category as c', 't.id_category', '=', 'c.id')
                    // ->leftjoin('ticket_reply as r', 't.id', '=', 'r.id_ticket')
                    // ->latest('r.created_at')
                    ->select('t.*', 'c.category_name as category', 'u.fullname as user', 'u_assigned.fullname as assigned', 't.updated_at as last_reply')
                    ->where('id_assign', '=', session('id'))
                    ->orderBy('t.id','DESC')

                    ->get();

                break;
        }


        $data = [
            "title" => "Aplikasi TicketingSchema",
            "subtitle" => "All Ticket",
            "data" => $dataUser,
            "kolomTable" => explode(', ', $kolom),
            "kolomCaption" => explode(', ', $kolomCaption),
            "post" => "post_berita",
            "delete" => "delete_ticket",
            "image" => "post_images"
        ];
        return view("dashboard.all", $data);
    }

    public function reply($id = 0)
    {
        $ticket = DB::table('ticket as t')
            ->join('user as u', 't.id_user', '=', 'u.id')
            ->join('user as u_assigned', 't.id_assign', '=', 'u_assigned.id')
            ->join('category as c', 't.id_category', '=', 'c.id')
            ->select('t.*', 'c.category_name as category', 'u.fullname as user', 'u_assigned.fullname as assigned')
            ->where('t.id', '=', $id)
            ->get();
        $replay = DB::table('ticket_reply as t')
            ->join('user as u', 't.id_user', '=', 'u.id')
            ->select('t.*', 'u.fullname as user')
            ->where('id_ticket', '=', $id)
            ->get();

        $data = [
            "title" => "Aplikasi TicketingSchema",
            "id_ticket"=> $id,
            "ticket" => $ticket,
            "replay" => $replay,
            "subtitle" => "Admin",
            "post" => "post_reply"
        ];
        return view("dashboard.reply", $data);
    }

    public function post_reply(Request $request)
    {
        $Reply = new TicketReply();
        $Reply->id_user = session('id');
        $Reply->id_ticket = $request->id_ticket;
        $Reply->reply = $request->reply;
        $Reply->save();

        return back()->withSuccess('Success! Replay has been posted.');

    }

    public function user()
    {


        $data = [
            "title" => "Aplikasi TicketingSchema",
            "subtitle" => "User List",
            "users" => User::all(),
            "post" => "add_user",
            "delete" => "delete_user",
            "image" => "post_images"
        ];
        return view("dashboard.users", $data);
    }
    public function add_user(Request $request)
    {
        $users = new User();
        $users->fullname = $request->fullname;
        $users->email = $request->email;
        $users->type = $request->type;
        $users->password = $request->password;
        $users->save();

        return back()->withSuccess('Success! User has been add.');

    }
    public function delete_user($id)
    {
        $users = User::find($id);
        $users->delete();
        return redirect()->route('user');
    }
}
