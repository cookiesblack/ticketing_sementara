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
use Tymon\JWTAuth\Facades\JWTAuth;
// use JWTAuth;


class Api extends Controller
{
    public function __construct()
    {
    }

    public function login(Request $request)
    {
        $username = $request->username;
        $password = $request->password;

        $userProfile = User::where(["email" => $username, "password" => $password])->first();
        if (empty($userProfile->email)) {
            return response()->json([
                'message' => 'username / password is wrong',
            ], 401);
        } else {
            $userSession = [
                "id" => $userProfile->id,
                "fullname" => $userProfile->fullname,
                "username" => $userProfile->email,
                "type" => $userProfile->type
            ];
            $token = JWTAuth::claims($userSession)->fromUser($userProfile);

            return response()->json([
                'message' => 'success',
                'data' => $token,
            ], 200);
        }
    }

    public function post_ticket(Request $request)
    {
        $user_id = $request->user->id;
        $kolom = "id_user, subject, id_category, id_assign, priority, description, attachment";

        $kolomTable = explode(', ', $kolom);
        $data = array();
        $ticket = new Ticket();
        foreach ($kolomTable as $key => $value) {
            if ($value == 'id_user') {
                $ticket->$value = $user_id;
            } elseif ($value == 'attachment') {
                if ($request->hasFile('attachment')) {
                    $file = $request->file('attachment');
                    $attachment = time() . '.' . $file->getClientOriginalExtension();
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
        $ticket->uniq_id = substr(base_convert(sha1(uniqid(mt_rand())), 16, 36), 0, 8);
        $ticket->status = "open";
        $ticket->save();

        $Reply = new TicketReply();
        $Reply->id_user = $request->id_assign;
        $Reply->id_ticket = $ticket->id;
        $Reply->reply = "Tiket anda sudah kami terima. Silahkan menunggu balasan dari petugas kami. Terima Kasih.";
        $Reply->save();

        return response()->json([
            'message' => 'success'
        ], 200);
    }

    public function delete_ticket($id)
    {
        $ticket = Ticket::find($id);
        if (!$ticket){
            return response()->json([
                'message' => 'id user not found'
            ], 404);
        }

        $ticket->delete();
        
        return response()->json([
            'message' => 'success'
        ], 200);
    }

    public function all_ticket(Request $request)
    {
        $type = $request->user->type;
        $user_id = $request->user->id;
        $dataUser = [];
        switch ($type) {
            case 'admin':
                $dataUser = DB::table('ticket as t')
                    ->join('user as u', 't.id_user', '=', 'u.id')
                    ->join('user as u_assigned', 't.id_assign', '=', 'u_assigned.id')
                    ->join('category as c', 't.id_category', '=', 'c.id')
                    ->select('t.*', 'c.category_name as category', 'u.fullname as user', 'u_assigned.fullname as assigned', 't.updated_at as last_reply')
                    ->orderBy('t.id', 'DESC')
                    ->get();
                break;

            case 'user':
                $dataUser = DB::table('ticket as t')
                    ->join('user as u', 't.id_user', '=', 'u.id')
                    ->join('user as u_assigned', 't.id_assign', '=', 'u_assigned.id')
                    ->join('category as c', 't.id_category', '=', 'c.id')
                    ->select('t.*', 'c.category_name as category', 'u.fullname as user', 'u_assigned.fullname as assigned', 't.updated_at as last_reply')
                    ->where('t.id_user', '=', $user_id)
                    ->orderBy('t.id', 'DESC')
                    ->get();
                break;

            case 'division':
                $dataUser = DB::table('ticket as t')
                    ->join('user as u', 't.id_user', '=', 'u.id')
                    ->join('user as u_assigned', 't.id_assign', '=', 'u_assigned.id')
                    ->join('category as c', 't.id_category', '=', 'c.id')
                    ->select('t.*', 'c.category_name as category', 'u.fullname as user', 'u_assigned.fullname as assigned', 't.updated_at as last_reply')
                    ->where('id_assign', '=', $user_id)
                    ->orderBy('t.id', 'DESC')
                    ->get();
                break;
        }
        return response()->json([
            'message' => 'success',
            'data' => $dataUser,
        ], 200);
    }

    public function reply($id = 0)
    {
        $ticket = Ticket::find($id);
        if (!$ticket){
            return response()->json([
                'message' => 'ticket not found'
            ], 404);
        }

        $ticket = DB::table('ticket as t')
            ->join('user as u', 't.id_user', '=', 'u.id')
            ->join('user as u_assigned', 't.id_assign', '=', 'u_assigned.id')
            ->join('category as c', 't.id_category', '=', 'c.id')
            ->select('t.*', 'c.category_name as category', 'u.fullname as user', 'u_assigned.fullname as assigned')
            ->where('t.id', '=', $id)
            ->first();
        $replay = DB::table('ticket_reply as t')
            ->join('user as u', 't.id_user', '=', 'u.id')
            ->select('t.*', 'u.fullname as user')
            ->where('id_ticket', '=', $id)
            ->orderBy('t.id', 'ASC')
            ->get();
        return response()->json([
            'message' => 'success',
            'data' => [
                'ticket'=> $ticket,
                'reply'=> $replay
            ]
        ], 200);
    }

    public function post_reply(Request $request)
    {
        $user_id = $request->user->id;

        $checkTicket = Ticket::find($request->id_ticket);
        if (!$checkTicket){
            return response()->json([
                'message' => 'ticket not found'
            ], 404);
        }

        $Reply = new TicketReply();
        $Reply->id_user = $user_id;
        $Reply->id_ticket = $request->id_ticket;
        $Reply->reply = $request->reply;
        $Reply->save();

        // return back()->withSuccess('Success! Replay has been posted.');
        return response()->json([
            'message' => 'success'
        ], 200);
    }

    public function user(Request $request)
    {
        return response()->json([
            'message' => 'success',
            'data' => User::select(['id','fullname','email', 'type','created_at'])->get(),
        ], 200);
    }

    public function assign_user(Request $request)
    {
        return response()->json([
            'message' => 'success',
            'data' => User::select(['id','fullname','email', 'type'])->where('type', '=', 'division')->get()
        ], 200);
    }

    public function category(Request $request)
    {
        return response()->json([
            'message' => 'success',
            'data' => Category::select(['id','category_name', 'created_at'])->get()
        ], 200);
    }

    public function add_user(Request $request)
    {
        $users = new User();
        $users->fullname = $request->fullname;
        $users->email = $request->username;
        $users->type = $request->type;
        $users->password = $request->password;
        $users->save();

        return response()->json([
            'message' => 'success'
        ], 200);
    }
    public function delete_user($id)
    {
        $users = User::find($id);

        if (!$users){
            return response()->json([
                'message' => 'id user not found'
            ], 404);
        }
        
        $users->delete();
        return response()->json([
            'message' => 'success'
        ], 200);
    }
}
