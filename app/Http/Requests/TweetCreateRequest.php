<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Http\Exceptions\HttpResponseException;

class TweetCreateRequest extends FormRequest
{
  /**
   * Determine if the user is authorized to make this request.
   */
  public function authorize(): bool
  {
    return true;
  }

  /**
   * Get the validation rules that apply to the request.
   *
   * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
   */
  public function rules(): array
  {
    return [
      'tweet' => 'required|string|max:255',
    ];
  }

  protected function failedValidation(Validator $validator)
  {
    if ($this->expectsJson()) {
      $response = response()->json([
        'message' => 'Validation errors',
        'errors' => $validator->errors()
      ], 422);

      throw new HttpResponseException($response);
    }

    parent::failedValidation($validator);
  }
}
