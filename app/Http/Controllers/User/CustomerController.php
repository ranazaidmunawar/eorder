<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\User\Customer;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;

class CustomerController extends Controller
{
    public function index(Request $request) {
        $userId = getRootUser()->id;
        $term = $request->term;
    
        $data['customers'] = Customer::query()
            ->where('user_id',$userId)
            ->when($term, function ($query, $term) {
               return $query->where('name', 'LIKE', '%' . $term . '%')
            ->orWhere('phone', 'LIKE', '%' . $term . '%');
        })
        ->orderBy('id', 'DESC')
        ->paginate(10);
        return view('user.customers.index', $data);
    }

    public function store(Request $request)
    {
        $userId = getRootUser()->id;
        $rules = [
            'phone' => ['required',
                Rule::unique('customers')->where(function($query) use ($userId){
                    return $query->where('user_id', $userId);
                })],
            'name' => 'required|max:255',
        ];
        $validator = Validator::make($request->all(), $rules);
        if ($validator->fails()) {
            $validator->getMessageBag()->add('error', 'true');
            return response()->json($validator->errors());
        }

        $customer = new Customer;
        $customer->name = $request->name;
        $customer->phone = $request->phone;
        $customer->email = $request->email;
        $customer->address = $request->address;
        $customer->user_id = $userId;
        $customer->save();

        Session::flash('success', 'Customer added successfully!');
        return "success";
    }

    public function update(Request $request)
    {
        $userId = getRootUser()->id;
        $customer = Customer::query()
            ->where('user_id',$userId)
            ->findOrFail($request->customer_id);
        $rules = [
            'phone' => [
                'required',
                 Rule::unique('customers')
                    ->ignore($customer->id)
                    ->where(function($query) use ($userId){
                        return $query->where('user_id', $userId);
                 }),
            ],
            'name' => 'required|max:255'
        ];

        $validator = Validator::make($request->all(), $rules);
        if ($validator->fails()) {
            $validator->getMessageBag()->add('error', 'true');
            return response()->json($validator->errors());
        }
        $customer->name = $request->name;
        $customer->phone = $request->phone;
        $customer->email = $request->email;
        $customer->address = $request->address;
        $customer->save();

        Session::flash('success', 'Customer updated successfully!');
        return "success";
    }

    public function delete(Request $request)
    {
        $userId = getRootUser()->id;
        Customer::query()
            ->where('user_id',$userId)
            ->findOrFail($request->customer_id)
            ->delete();
        Session::flash('success', 'Customer deleted successfully!');
        return back();
    }

    public function bulkDelete(Request $request)
    {
        $userId = getRootUser()->id;
        $ids = $request->ids;
        foreach ($ids as $id) {
            Customer::query()
                ->where('user_id',$userId)
                ->findOrFail($id)
                ->delete();
        }
        Session::flash('success', 'Customers deleted successfully!');
        return "success";
    }
}
