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


class Api extends Controller
{
    public function __construct()
    {
    }

    public function login(Request $request)
    {
        $username = $request->username;
        $password = $request->password;

        $userProfile = User::where(["email" => $username, "password" => $password])->selectRaw('*')->get();
        // echo $userProfile;
        if (empty($userProfile[0]->email)) {
            return response()->json([
                'message' => 'username / password is wrong',
            ], 401);
        } else {
            $userSession = [
                "id" => $userProfile[0]->id,
                "fullname" => $userProfile[0]->fullname,
                "username" => $userProfile[0]->email,
                "type" => $userProfile[0]->type
            ];
            
            return response()->json([
                'message' => 'success',
                'data' => $userSession,
            ], 200);
        }
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
        $ticket->uniq_id=substr(base_convert(sha1(uniqid(mt_rand())), 16, 36), 0, 8);
        $ticket->status = "open";
        $ticket->save();

        $Reply = new TicketReply();
        $Reply->id_user = $request->id_assign;
        $Reply->id_ticket = $ticket->id;
        $Reply->reply = "Tiket anda sudah kami terima. Silahkan menunggu balasan dari petugas kami. Terima Kasih.";
        $Reply->save();

        // return back()->withSuccess('Success! Your ticket has been send.');
        return redirect()->route('all_ticket')->withSuccess('Success! Your ticket has been send.');;
    }

    public function delete_ticket($id)
    {
        $ticket = Ticket::find($id);
        $ticket->delete();
        return back()->withSuccess('Success! Ticket has been delete.');
    }

    public function all_ticket(Request $request)
    {
        $type= $request->type;
        $user_id= $request->user_id;
        switch ($type) {
            case 'admin':
                $kolom = "user, uniq_id, subject, priority, category, created_at, status, assigned";
                $kolomCaption = "User, Uniq ID, Subject, Priority, Category, Date, Status, Assigned";
                // $dataUser = Ticket::all();
                $dataUser = DB::table('ticket as t')
                    ->join('user as u', 't.id_user', '=', 'u.id')
                    ->join('user as u_assigned', 't.id_assign', '=', 'u_assigned.id')
                    ->join('category as c', 't.id_category', '=', 'c.id')
                    // ->leftjoin('ticket_reply as r', 't.id', '=', 'r.id_ticket')
                    // ->latest('r.created_at')
                    ->select('t.*', 'c.category_name as category', 'u.fullname as user', 'u_assigned.fullname as assigned', 't.updated_at as last_reply')
                    ->orderBy('t.id', 'DESC')
                    ->get();
                break;

            case 'user':
                $kolom = "uniq_id, subject, priority, category, created_at, status, assigned, last_reply";
                $kolomCaption = "Uniq ID, Subject, Priority, Category, Date, Status, Assigned, Last Reply";
                // $dataUser = Ticket::all();
                $dataUser = DB::table('ticket as t')
                    ->join('user as u', 't.id_user', '=', 'u.id')
                    ->join('user as u_assigned', 't.id_assign', '=', 'u_assigned.id')
                    ->join('category as c', 't.id_category', '=', 'c.id')
                    // ->leftjoin('ticket_reply as r', 't.id', '=', 'r.id_ticket')
                    // ->latest('r.created_at')
                    ->select('t.*', 'c.category_name as category', 'u.fullname as user', 'u_assigned.fullname as assigned', 't.updated_at as last_reply')
                    ->where('t.id_user', '=', session('id'))
                    ->orderBy('t.id', 'DESC')
                    ->get();
                break;

            case 'division':
                $kolom = "user, uniq_id, subject, priority, category, created_at, status, last_reply";
                $kolomCaption = "User, Uniq ID, Subject, Priority, Category, Date, Status, last_reply";
                // $dataUser = Ticket::all();
                $dataUser = DB::table('ticket as t')
                    ->join('user as u', 't.id_user', '=', 'u.id')
                    ->join('user as u_assigned', 't.id_assign', '=', 'u_assigned.id')
                    ->join('category as c', 't.id_category', '=', 'c.id')
                    // ->leftjoin('ticket_reply as r', 't.id', '=', 'r.id_ticket')
                    // ->latest('r.created_at')
                    ->select('t.*', 'c.category_name as category', 'u.fullname as user', 'u_assigned.fullname as assigned', 't.updated_at as last_reply')
                    ->where('id_assign', '=', session('id'))
                    ->orderBy('t.id', 'DESC')

                    ->get();

                break;
        }


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
            ->orderBy('t.id', 'ASC')
            ->get();
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
        return response()->json([
            'message' => 'success',
            'data' => User::all(),
        ], 200);
    }
    public function add_user(Request $request)
    {
        $users = new User();
        $users->fullname = $request->fullname;
        $users->email = $request->email;
        $users->type = $request->type;
        $users->password = $request->password;
        $users->save();


    }
    public function delete_user($id)
    {
        $users = User::find($id);
        $users->delete();

    }
}
