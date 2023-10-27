<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\ValidationException;
use Tests\TestCase;

class ValidatorTest extends TestCase
{
    public function testValidator()
    {
        $data = [
            'username' => 'admin',
            'password' => '123'
        ];

        $rules = [
            'username' => 'required',
            'password' => 'required'
        ];

        $validator = Validator::make($data, $rules);
        $this->assertNotNull($validator);

        $this->assertTrue($validator->passes());
        $this->assertFalse($validator->fails());
    }

    public function testValidatorInvalid()
    {
        $data = [
            'username' => '',
            'password' => ''
        ];

        $rules = [
            'username' => 'required',
            'password' => 'required'
        ];

        $validator = Validator::make($data, $rules);
        $this->assertNotNull($validator);

        $this->assertFalse($validator->passes());
        $this->assertTrue($validator->fails());

        $message = $validator->getMessageBag();
        $message->keys();

        Log::info($message->toJson(JSON_PRETTY_PRINT));
    }

    public function testValidatorValidationException()
    {
        $data = [
            'username' => '',
            'password' => ''
        ];

        $rules = [
            'username' => 'required',
            'password' => 'required'
        ];

        $validator = Validator::make($data, $rules);
        $this->assertNotNull($validator);

        try {
            $validator->validate();
            $this->fail("ValidationException not thrown");
        } catch (ValidationException $exception) {
            $this->assertNotNull($exception->validator);
            $message = $exception->validator->errors();

            Log::error($message->toJson(JSON_PRETTY_PRINT));
        }
    }

    public function testValidatorMultipleRules()
    {
        \Illuminate\Support\Facades\App::setlocale('id');
        $data = [
            'username' => 'ucup',
            'password' => 'ucup'
        ];

        $rules = [
            'username' => 'required|email|max:100',
            'password' => ['required', 'min:6', 'max:20']
        ];

        $validator = Validator::make($data, $rules);
        $this->assertNotNull($validator);

        $this->assertFalse($validator->passes());
        $this->assertTrue($validator->fails());

        $message = $validator->getMessageBag();
        $message->keys();

        Log::info($message->toJson(JSON_PRETTY_PRINT));
    }

    public function testValidatorValidData()
    {
        $data = [
            'username' => 'admin@yahoo.com',
            'password' => 'adminpassword',
            'admin' => true
        ];

        $rules = [
            'username' => 'required|email|max:100',
            'password' => 'required|min:6|max:20'
        ];

        $validator = Validator::make($data, $rules);
        $this->assertNotNull($validator);

        try {
            $valid = $validator->validate();
            Log::info(json_encode($valid, JSON_PRETTY_PRINT));
        } catch (ValidationException $exception) {
            $this->assertNotNull($exception->validator);
            $message = $exception->validator->errors();

            Log::error($message->toJson(JSON_PRETTY_PRINT));
        }
    }

    public function testValidatorInlineMessage()
    {
        $data = [
            'username' => 'ucup',
            'password' => 'ucup'
        ];

        $rules = [
            'username' => 'required|email|max:100',
            'password' => ['required', 'min:6', 'max:20']
        ];

        $message = [
            'required' => ':attribute harus diisi',
            'email' => ':attribute harus berupa email',
            'min' => ':attribute minimal :min karakter',
            'max' => ':atrribute maksimal :max karakter'
        ];

        $validator = Validator::make($data, $rules, $message);
        $this->assertNotNull($validator);

        $this->assertFalse($validator->passes());
        $this->assertTrue($validator->fails());

        $message = $validator->getMessageBag();
        $message->keys();

        Log::info($message->toJson(JSON_PRETTY_PRINT));
    }

    public function testValidatorAdditionalValidation()
    {
        $data = [
            'username' => 'ucup@yahoo.com',
            'password' => 'ucup@yahoo.com'
        ];

        $rules = [
            'username' => 'required|email|max:100',
            'password' => ['required', 'min:6', 'max:20']
        ];

        $validator = Validator::make($data, $rules);
        $validator->after(function (\Illuminate\Validation\Validator $validator) {
            $data = $validator->getData();
            if ($data['username'] === $data['password']) {
                $validator->errors()->add('password', 'Password tidak boleh sama dengan username');
            }
        });
        $this->assertNotNull($validator);

        $this->assertFalse($validator->passes());
        $this->assertTrue($validator->fails());

        $message = $validator->getMessageBag();
        $message->keys();

        Log::info($message->toJson(JSON_PRETTY_PRINT));
    }
}
