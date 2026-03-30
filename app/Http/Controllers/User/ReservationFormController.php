<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\User\Language;
use App\Models\User\ReservationInput;
use App\Models\User\ReservationInputOption;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Validator;


class ReservationFormController extends Controller
{
    public function form(Request $request)
    {
        $userId = getRootUser()->id;
        $lang = Language::query()
            ->where([
                ['code', $request->language],
                ['user_id', $userId]
            ])
            ->first();
       
        $data['lang_id'] = $lang->id;
        $data['abs'] = $lang->basic_setting;
        $data['inputs'] = ReservationInput::query()
            ->where([
                ['language_id', $data['lang_id']],
                ['user_id', $userId]
            ])
            ->orderBy('order_number', 'ASC')
            ->get();

        return view('user.reservations.form', $data);
    }

    public function formStore(Request $request)
    {
        $userId = getRootUser()->id;
        $inname = make_input_name($request->label);
        $reservationInputQuery = ReservationInput::query()
            ->where([
                ['language_id', $request->language_id],
                ['user_id', $userId]
            ]);
        $inputs = $reservationInputQuery->get();
        $maxOrder = $reservationInputQuery->max('order_number');

        $messages = [
            'options.*.required_if' => 'Options are required if field type is select dropdown/checkbox',
            'placeholder.required_unless' => 'The placeholder field is required unless field type is Checkbox'
        ];

        $rules = [
            'label' => [
                'required',
                function ($attribute, $value, $fail) use ($inname, $inputs) {
                    foreach ($inputs as $input) {
                        if ($input->name == $inname) {
                            $fail("Input field already exists.");
                        }
                    }
                },
            ],
            'placeholder' => 'required_unless:type,3',
            'type' => 'required',
            'options.*' => 'required_if:type,2,3'
        ];

        $validator = Validator::make($request->all(), $rules, $messages);
        if ($validator->fails()) {
            $validator->getMessageBag()->add('error', 'true');
            return response()->json($validator->errors());
        }

        $input = new ReservationInput;
        $input->language_id = $request->language_id;
        $input->user_id = $userId;
        $input->type = $request->type;
        $input->label = $request->label;
        $input->name = $inname;
        $input->placeholder = $request->placeholder;
        $input->required = $request->required;
        $input->order_number = $maxOrder + 1;
        $input->save();

        if ($request->type == 2 || $request->type == 3) {
            $options = $request->options;
            foreach ($options as $option) {
                $op = new ReservationInputOption;
                $op->reservation_input_id = $input->id;
                $op->user_id = $userId;
                $op->name = $option;
                $op->save();
            }
        }
        Session::flash('success', 'Input field added successfully!');
        return "success";
    }

    public function inputDelete(Request $request)
    {
        $userId = getRootUser()->id;
        $input = ReservationInput::query()
                 ->where('user_id', $userId)
                 ->find($request->input_id);
        $input->reservation_input_options()->delete();
        $input->delete();
        Session::flash('success', 'Input field deleted successfully!');
        return back();
    }

    public function inputEdit($id)
    {
        $userId = getRootUser()->id;
        $data['input'] = ReservationInput::query()
            ->where('user_id', $userId)
            ->find($id);
        $this->authorize('view',$data['input']);    
        if (!empty($data['input']->reservation_input_options)) {
            $options = $data['input']->reservation_input_options;
            $data['options'] = $options;
            $data['counter'] = count($options);
        }
        return view('user.reservations.form-edit', $data);
    }

    public function inputUpdate(Request $request)
    {
        
        $userId = getRootUser()->id;
        $inname = make_input_name($request->label);
        $input = ReservationInput::query()
            ->where('user_id', $userId)
            ->find($request->input_id);
        $inputs = ReservationInput::query()
            ->where([
                ['user_id', $userId],
                ['language_id', $input->language_id]
            ])
            ->get();

        $messages = [
            'options.required_if' => 'Options are required',
            'placeholder.required_unless' => 'Placeholder is required',
            'label.required_unless' => 'Label is required',
        ];

        $rules = [
            'label' => [
                'required_unless:type,5',
                function ($attribute, $value, $fail) use ($inname, $inputs, $input) {
                    foreach ($inputs as $in) {
                        if ($in->name == $inname && $inname != $input->name) {
                            $fail("Input field already exists.");
                        }
                    }
                },
            ],
            'placeholder' => 'required_unless:type,3,5',
            'options' => [
                'required_if:type,2,3',
                function ($attribute, $value, $fail) use ($request) {
                    if ($request->type == 2 || $request->type == 3) {
                        foreach ($request->options as $option) {
                            if (empty($option)) {
                                $fail('All option fields are required.');
                            }
                        }
                    }
                },
            ]
        ];

        $validator = Validator::make($request->all(), $rules, $messages);
        if ($validator->fails()) {
            $validator->getMessageBag()->add('error', 'true');
            return response()->json($validator->errors());
        }


        if ($request->type != 5) {
            $input->label = $request->label;
            $input->name = $inname;
        }

        // if input is checkbox then placeholder is not required
        if ($request->type != 3 && $request->type != 5) {
            $input->placeholder = $request->placeholder;
        }
        $input->required = $request->required;

        $input->save();

        if ($request->type == 2 || $request->type == 3) {
            $input->reservation_input_options()->delete();
            $options = $request->options;
            foreach ($options as $option) {
                $op = new ReservationInputOption;
                $op->reservation_input_id = $input->id;
                $op->user_id = $userId;
                $op->name = $option;
                $op->save();
            }
        }

        Session::flash('success', 'Input field updated successfully!');
        return "success";
    }


    public function orderUpdate(Request $request) {
        $ids = $request->ids;
        $orders = $request->orders;
        $userId = getRootUser()->id;
        if (!empty($ids)) {
            foreach ($request->ids as $key => $id) {
                $input = ReservationInput::query()
                    ->where('user_id', $userId)
                    ->findOrFail($id);
                $input->order_number = $orders["$key"];
                $input->save();
            }
        }
    }

    public function options($id)
    {
        $userId = getRootUser()->id;
        $options = ReservationInputOption::query()
            ->where('user_id', $userId)
            ->where('reservation_input_id', $id)
            ->get();
        return $options;
    }
}
