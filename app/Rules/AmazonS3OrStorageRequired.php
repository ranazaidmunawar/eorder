<?php

namespace App\Rules;

use Illuminate\Contracts\Validation\Rule;

class AmazonS3OrStorageRequired implements Rule
{
    /**
     * Create a new rule instance.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Determine if the validation rule passes.
     *
     * @param  string  $attribute
     * @param  mixed  $value
     * @return bool
     */
    public function passes($attribute, $value)
    {
        $amazonS3Selected = in_array('Amazon AWS s3', $value);
        $storageLimitSelected = in_array('Storage Limit', $value);

        return ($amazonS3Selected && !$storageLimitSelected) || (!$amazonS3Selected && $storageLimitSelected);
    }

    public function message()
    {
        return 'Either "Amazon AWS S3" or "Storage Limit" must be selected, but not both.';
    }
}
