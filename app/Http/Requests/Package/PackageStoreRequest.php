<?php

namespace App\Http\Requests\Package;

use App\Rules\AmazonS3OrStorageRequired;
use Illuminate\Foundation\Http\FormRequest;

class PackageStoreRequest extends FormRequest
{
    public array $array;
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
            'title' => 'required|max:255|unique:packages,title,NULL,id,term,' . $this->term,
            'term' => 'required',
            'price' => 'required',
            'status' => 'required',
            'categories_limit' => 'required',
            'subcategories_limit' => 'required',
            'items_limit' => 'required',
            'storage_limit' => is_array($this->features) &&  in_array('Storage Limit', $this->features) ? 'required' : '',
            'table_reservation_limit' => is_array($this->features) && in_array('Table Reservation', $this->features) ? 'required' : '',
            'language_limit' => 'required',
            'trial_days' => 'required_if:is_trial,1',
            'staff_limit' => is_array($this->features) && in_array('Staffs', $this->features) ? 'required' : '',
            'order_limit' => is_array($this->features) && in_array('Online Order', $this->features) ? 'required' : '',
            'features' => ['required', 'array', new AmazonS3OrStorageRequired],
            
            'online_order' => is_array($this->features) && in_array('Online Order', $this->features) &&
            (!in_array('On Table', $this->features) && !in_array('Pick Up', $this->features) && !in_array('Home Delivery', $this->features)) ? 'required' : '',
            'pos_order' => is_array($this->features) && in_array('POS', $this->features) &&
            (!in_array('On Table', $this->features) && !in_array('Pick Up', $this->features) && !in_array('Home Delivery', $this->features)) ? 'required' : '',
        ];
    }
    public function messages(): array
    {
        return [
            'title.unique' => 'Title must be unique for this term',
            'trial_days.required_if' => 'Trial days is required',
            'table_reservation_limit.required' => 'Table reservation limit field is required, when table reservation feature is enabled',
            'staff_limit.required' => 'Staff limit field is required, when Staffs feature is enabled',
            'order_limit.required' => 'Order limit is required, when Online Order feature is enabled',
            'online_order.required' => 'Pick Up Or Home Deliver Or On Table is required',
            'pos_order.required' => 'Pick Up Or Home Deliver Or On Table is required',
            'features.required' => 'Either "Amazon AWS S3" or "Storage Limit" must be selected, but not both.',
        ];
    }
}
