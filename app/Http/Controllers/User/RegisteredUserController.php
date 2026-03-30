<?php

namespace App\Http\Controllers\User;

use App\Models\User;
use App\Models\Client;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use App\Models\User\ProductOrder;
use App\Models\User\ProductReview;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Validator;

class RegisteredUserController extends Controller
{
   public function registerClient(Request $request)
   {
        $searchKey = null;
        if ($request->filled('term')) {
            $searchKey = $request['term'];
        }

        $data['users'] = Client::when($searchKey, function ($query, $searchKey) {
            return $query->where('username', 'like', '%' . $searchKey . '%')
                ->orWhere('email', 'like', '%' . $searchKey . '%');
        })
            ->where('user_id', Auth::guard('web')->user()->id)
            ->orderBy('id', 'desc')
            ->paginate(10);

    return view('user.register_user.registeruser',$data);
   }

    public function updateAccountStatus(Request $request, $id)
    {
        $user = Client::where('id', $id)->where('user_id', Auth::guard('web')->user()->id)->firstOrFail();

        if ($request['account_status'] == 1) {
            $user->update(['status' => 1]);
        } else {
            $user->update(['status' => 0]);
        }

        $request->session()->flash('success', 'Account status updated successfully!');

        return redirect()->back();
    }

    public function clientban(Request $request)
    {
        $client = Client::query()->where('id', $request->user_id)->first();
        $client->update([
            'status' => $request->status,
        ]);
        Session::flash('success', 'Status update successfully!');
        return back();
    }

    public function clientDetails($id)
    {
        $userInfo = Client::where('id', $id)->where('user_id', Auth::guard('web')->user()->id)->firstOrFail();
        $information['user'] = $userInfo;
        return view('user.register_user.client_details', $information);
    }

    public function emailStatus(Request $request)
    {
        $client = Client::query()->findOrFail($request->user_id);
        $client->update([
            'email_verified' => $request->email_verified,
        ]);
        Session::flash('success', 'Email status updated for ' . $client->username);
        return back();
    }

    public function destroy(Request $request, )
    {

        $Client = Client::where('id', $request->user_id)->where('user_id', Auth::guard('web')->user()->id)->firstOrFail();

        $orders = ProductOrder::where('customer_id', $Client->id)->get();
        $reviews = ProductReview::where('customer_id', $Client->id)->get();

        if($orders->count() > 0){
            foreach($orders as $order)
            {
                $order->delete();
            }
        }
        if ($reviews->count() > 0) {
            foreach ($reviews as $review) {
                $review->delete();
            }
        }

        if (file_exists(public_path('assets/tenant/customer/image/' . $Client->photo))) {
            @unlink(public_path('assets/tenant/customer/image/' . $Client->photo));
        }
        $Client->delete();

        Session::flash('success', 'Customer  deleted successfully!');
        return back();
    }

    public function bulkDestroy(Request $request)
    {
        $ids = $request->ids;

        foreach ($ids as $id) {

            $Client = Client::where('id', $id)->where('user_id', Auth::guard('web')->user()->id)->with('user')->firstOrFail();

            if (file_exists(public_path('assets/tenant/customer/image/' . $Client->photo))) {
                @unlink(public_path('assets/tenant/customer/image/' . $Client->photo));
            }
            $Client->delete();
        }

        Session::flash('success', 'Users info deleted successfully!');
        return 'success';
    }

    public function addClient(Request $request)
    {
       
        $rules = [
            'username' => [
                'required',
                Rule::unique('clients')->where(function ($query) {
                    return $query->where('user_id', getRootUser()->id);
                }),
            ],
            'email' => [
                'required',
                Rule::unique('clients')->where(function ($query) {
                    return $query->where('user_id', getRootUser()->id);
                }),
            ],
            'password' => 'required',
            'password_confirmation' => 'required|same:password'
        ];

        $validator = Validator::make($request->all(), $rules);
        if ($validator->fails()) {
            $validator->getMessageBag()->add('error', 'true');
            return response()->json($validator->errors());
        }
       
        
        $userId = getRootUser()->id;
        $input = $request->except('_token');
        $input['user_id'] = $userId;
        $input['status'] = 1;
        $input['password'] = bcrypt($request['password']);
        $input['email_verified'] = "Yes";

        Client::create($input);
        Session::flash('success', 'Client added successfully!');
        return "success";
    }

    public function changeClientPassword(Request $request)
    {
        $rules = [
            'password' => 'required',
            'password_confirmation' => 'required|same:password'
        ];

        $validator = Validator::make($request->all(), $rules);
        if ($validator->fails()) {
            $validator->getMessageBag()->add('error', 'true');
            return response()->json($validator->errors());
        }

        $client = Client::find($request->id);
        $client->password = bcrypt($request['password']);
        $client->update();
        Session::flash('success', 'Password change successfully!');
        return "success";
    }

    public function secretLogin(Request $request)
    {
        $client = Client::where('id', $request->user_id)->first();
        $user = User::find($client->user_id);
    
        if ($client) {
            Auth::guard('client')->login($client);
            return redirect()->route('user.client.dashboard', $user->username)
            ->withSuccess('You have Successfully loggedin');
        } else {

            return redirect()->route('user.client.login', $user->username)->withSuccess('Oppes! You have entered invalid credentials');
        }
    }
}
