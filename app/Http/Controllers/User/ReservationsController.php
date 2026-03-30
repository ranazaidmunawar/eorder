<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Http\Helpers\LimitCheckerHelper;
use App\Http\Helpers\MegaMailer;
use App\Models\User\BasicSetting;
use App\Models\User\Language;
use App\Models\User\ReservationInput;
use App\Models\User\TableBook;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Response;
use Illuminate\Support\Facades\Session;

class ReservationsController extends Controller
{
    public function index()
    {

        $userId = getRootUser()->id;
        $data['tables'] = TableBook::query()
            ->where('user_id', $userId)
            ->orderBy('id', 'DESC')
            ->paginate(10);
        return view('user.reservations.reservations', $data);
    }
    public function create()
    {
        $userId = getRootUser()->id;
        $currentLang = Language::query()
            ->where([
                ['code', request('language')],
                ['user_id', $userId]
            ])
            ->first();
      
        $data['bs'] = BasicSetting::query()
            ->where('user_id', $userId)
            ->first();
        $data['inputs'] = ReservationInput::query()
            ->where([
                ['language_id', $currentLang->id],
                ['user_id', $userId]
            ])
            ->orderBy('order_number', 'ASC')
            ->get();
          
        return view('user.reservations.create', $data);
    }

    public function pending(Request $request)
    {
        $userId = getRootUser()->id;
        $search = $request->search;
        $data['tables'] = TableBook::query()
            ->where([
                ['status', '1'],
                ['user_id', $userId]
            ])
            ->orderBy('id', 'DESC')->paginate(10);
        return view('user.reservations.reservations', $data);
    }

    public function accepted(Request $request)
    {
        $userId = getRootUser()->id;
        $data['tables'] = TableBook::query()
            ->where([
                ['status', 2],
                ['user_id', $userId]
            ])
            ->orderBy('id', 'DESC')
            ->paginate(10);
        return view('user.reservations.reservations', $data);
    }

    public function rejected(Request $request)
    {
        $userId = getRootUser()->id;
        $data['tables'] = TableBook::query()
            ->where([
                ['status', 3],
                ['user_id', $userId]
            ])
            ->orderBy('id', 'DESC')
            ->paginate(10);
        return view('user.reservations.reservations', $data);
    }

    public function status(Request $request)
    {
        $user = getRootUser();
        $userId = $user->id;
        $bs = BasicSetting::query()
            ->where('user_id', $userId)
            ->first();
        $res = TableBook::query()
            ->where('user_id', $userId)
            ->find($request->table_id);

        $res->status = $request->status;
        $res->save();

        if ($request->status == 2)
        {
            $templateType = 'reservation_accept';
        }
        elseif ($request->status == 3)
        {
            $templateType = 'reservation_reject';
        }
        if ($request->status != 1) {
            $mailer = new MegaMailer();
            $data = [
                'toMail' => $res->email,
                'toName' => $res->name,
                'customer_name' => $res->name,
                'website_title' => $bs->website_title,
                'templateType' => $templateType,
                'type' => 'reservationStatus'
            ];
            $mailer->mailFromUser($data,$userId,$user);
        }
        Session::flash('success', 'table reservations status changed successfully!');
        return back();
    }

    public function delete(Request $request)
    {
        $userId = getRootUser()->id;
        $table = TableBook::query()
            ->where('user_id', $userId)
            ->findOrFail($request->table_id);
        $table->delete();
        Session::flash('success', 'table reservations deleted successfully!');
        return back();
    }

    public function bulkTableDelete(Request $request)
    {
        $userId = getRootUser()->id;
        $ids = $request->ids;
        foreach ($ids as $id) {
            $table = TableBook::query()
                ->where('user_id', $userId)
                ->findOrFail($id);
            $table->delete();
        }
        Session::flash('success', 'table reservations deleted successfully!');
        return "success";
    }

    public function visibility()
    {
        $userId = getRootUser()->id;
        $data['abs'] = BasicSetting::query()
            ->where('user_id', $userId)
            ->first();
        return view('user.reservations.visibility', $data);
    }

    public function updateVisibility(Request $request)
    {
        $userId = getRootUser()->id;
        $bss = BasicSetting::query()
            ->where('user_id', $userId)
            ->get();
        foreach ($bss as $bs) {
            $bs->is_quote = $request->is_quote;
            $bs->save();
        }
        $request->session()->flash('success', 'Page status updated successfully!');
        return back();
    }
    public function tableBook(Request $request,$lang)
    {
        $userId = getRootUser()->id;
       
        $currentLang = Language::query()
            ->where('code', $lang)
            ->where('user_id', $userId)
            ->first();

        $count = LimitCheckerHelper::getTableReservationCount($userId);
        $package = LimitCheckerHelper::currentMembershipPackage($userId);
        $membership = LimitCheckerHelper::currentMembership($userId);

        if (is_null($package) ||  $count >= $package->table_reservation_limit) {

            return back()->with('error', "we are currently unable to receive any reservation")->withInput($request->all());
        }

        $reservation_inputs = $currentLang->reservation_inputs;

        $rules = [
            'name' => 'required',
            'email' => 'required|email',
        ];

        foreach ($reservation_inputs as $input) {
            if ($input->required == 1) {
                $rules["$input->name"] = 'required';
            }
        }

        $request->validate($rules);

        $fields = [];
        foreach ($reservation_inputs as $input) {
            $in_name = $input->name;
            if ($request["$in_name"]) {
                $fields["$in_name"] = $request["$in_name"];
            }
        }
        $jsonfields = json_encode($fields);
        $jsonfields = str_replace("\/", "/", $jsonfields);

        $data = new TableBook;
        $data->name = $request->name;
        $data->email = $request->email;
        $data->fields = $jsonfields;
        $data->user_id = $userId;
        $data->membership_id = $membership->id;

        $data->save();
        Session::flash('success', 'Table reservation is successful');
        return 'success';
    }
}
