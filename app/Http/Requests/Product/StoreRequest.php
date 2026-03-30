<?php

namespace App\Http\Requests\Product;

use App\Models\User\Language;
use App\Models\User\ProductInformation;
use App\Rules\ImageMimeTypeRule;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;

class StoreRequest extends FormRequest
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
    $user = getRootUser();

    $ruleArray = [
      'feature_image' => new ImageMimeTypeRule(),
      'slider_images' => 'required',
      'status' => 'required',
      'current_price' => 'required',
    ];

    $languages = Language::query()->where('user_id', $user->id)->get();

    foreach ($languages as $language) {
      $request = $this->request->all();
      $slug = slug_create($request[$language->code . '_title']);
      $ruleArray[$language->code . '_title'] = [
        'required',
        'max:255',
        function ($attribute, $value, $fail) use ($slug, $language,$user) {
            $bis = ProductInformation::query()->where('language_id', $language->id)->where('user_id', $user->id)->get();
            foreach ($bis as $bi) {
                if (strtolower($slug) == strtolower($bi->slug)) {
                    $fail('The title field must be unique for ' . $language->name . ' language.');
                }
            }
        }
      ];
      $ruleArray[$language->code . '_category_id'] = 'required';
      $ruleArray[$language->code . '_description'] = 'required';
      $ruleArray[$language->code . '_summary'] = 'required';
    }

    return $ruleArray;
  }

  public function messages(): array
  {
    $user = getRootUser();

    $messageArray = [];

    $languages = Language::query()->where('user_id', $user->id)->get();

    foreach ($languages as $language) {

      $messageArray[$language->code . '_title.required'] = 'The title field is required for ' . $language->name . ' language.';

      $messageArray[$language->code . '_title.max'] = 'The title field cannot contain more than 255 characters for ' . $language->name . ' language.';

      $messageArray[$language->code . '_title.unique'] = 'The title field must be unique for ' . $language->name . ' language.';

      $messageArray[$language->code . '_category_id.required'] = 'The category field is required for ' . $language->name . ' language.';

      $messageArray[$language->code . '_description.required'] = 'The description field is required for ' . $language->name . ' language.';

      $messageArray[$language->code . '_summary.required'] = 'The summary field is required for ' . $language->name . ' language.';
    }

    return $messageArray;
  }
}
