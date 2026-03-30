<?php

namespace App\Http\Requests\Package;

use App\Rules\AmazonS3OrStorageRequired;
use Illuminate\Foundation\Http\FormRequest;

class PackageUpdateRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules(): array
    {
        return [
            'title' => 'required|max:255|unique:packages,title,' . $this->package_id.',id,term,' . $this->term,
            'term' => 'required',
            'price' => 'required',
            'status' => 'required',
            'categories_limit' => 'required',
            'subcategories_limit' => 'required',
            'items_limit' => 'required',
            'storage_limit' => is_array($this->features) && in_array('Storage Limit', $this->features) ? 'required' : '',
            'features' => ['required', 'array', new AmazonS3OrStorageRequired],
            'table_reservation_limit' => is_array($this->features) && in_array('Table Reservation', $this->features) ? 'required' : '',
            'language_limit' => is_array($this->features) && in_array('Languages', $this->features) ? 'required' : '',
            'trial_days' => $this->is_trial == "1" ? 'required' : '',
            'staff_limit' => is_array($this->features) && in_array('Staffs', $this->features) ? 'required' : '',
            'order_limit' => is_array($this->features) && in_array('Online Order', $this->features) ? 'required' : '',
            'online_order' =>  in_array('Online Order', $this->features) &&
            (!in_array('On Table', $this->features) && !in_array('Pick Up', $this->features) && !in_array('Home Delivery', $this->features)) ? 'required' : '',
            'pos_order' =>  in_array('POS', $this->features) &&
            (!in_array('On Table', $this->features) && !in_array('Pick Up', $this->features) && !in_array('Home Delivery', $this->features)) ? 'required' : '',
        ];
    }
    public function messages(): array
    {
        return [
            'title.unique' => 'Title already taken for this term',
            'trial_days.required' => 'Trial days is required when trial option is checked',
            'table_reservation_limit.required' => 'Table reservation limit is required, when table reservation feature is enabled',
            'staff_limit.required' => 'Staff limit is required, when Staffs feature is enabled',
            'order_limit.required' => 'Order limit is required, when Online Order feature is enabled',
            'online_order.required' => 'Please select one of the three available options: Pick Up, Home Delivery, or On Table',
            'pos_order.required' => 'Please select one of the three available options: Pick Up, Home Delivery, or On Table',
            'features.required' => 'Either "Amazon AWS S3" or "Storage Limit" must be selected, but not both.',
        ];
    }
}
