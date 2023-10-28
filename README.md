<p align="center"><a href="https://laravel.com" target="_blank"><img src="https://raw.githubusercontent.com/laravel/art/master/logo-lockup/5%20SVG/2%20CMYK/1%20Full%20Color/laravel-logolockup-cmyk-red.svg" width="400" alt="Laravel Logo"></a></p>

<p align="center">
<a href="https://github.com/laravel/framework/actions"><img src="https://github.com/laravel/framework/workflows/tests/badge.svg" alt="Build Status"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/dt/laravel/framework" alt="Total Downloads"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/v/laravel/framework" alt="Latest Stable Version"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/l/laravel/framework" alt="License"></a>
</p>

## About Laravel

Laravel is a web application framework with expressive, elegant syntax. We believe development must be an enjoyable and creative experience to be truly fulfilling. Laravel takes the pain out of development by easing common tasks used in many web projects, such as:

-   [Simple, fast routing engine](https://laravel.com/docs/routing).
-   [Powerful dependency injection container](https://laravel.com/docs/container).
-   Multiple back-ends for [session](https://laravel.com/docs/session) and [cache](https://laravel.com/docs/cache) storage.
-   Expressive, intuitive [database ORM](https://laravel.com/docs/eloquent).
-   Database agnostic [schema migrations](https://laravel.com/docs/migrations).
-   [Robust background job processing](https://laravel.com/docs/queues).
-   [Real-time event broadcasting](https://laravel.com/docs/broadcasting).

Laravel is accessible, powerful, and provides tools required for large, robust applications.

## Learning Laravel

Laravel has the most extensive and thorough [documentation](https://laravel.com/docs) and video tutorial library of all modern web application frameworks, making it a breeze to get started with the framework.

# Laravel Validation

## Table Of Contents

-   [Introduction](#introduction)
-   [Validator](#validator)
-   [Run Validation](#run-validation)
-   [Error Message](#error-message)
-   [Validation Exception](#validation-exception)
-   [Validation Rules](#validation-rules)
-   [Valid Data](#valid-data)
-   [Validation Message](#validation-message)
-   [Additional Validation](#additional-validation)
-   [Custom Rule](#custom-rule)
-   [Custom Function Rule](#custom-function-rule)
-   [Rule Classes](#rule-classes)
-   [Nested Array Validation](#nested-array-validation)
-   [HTTP Request Validation](#http-request-validation)
-   [Error Page](#error-page)

<hr>
<br>
<br>

## Introduction

**Validation**

Saat membuat aplikasi, sudah dipastikan bahwa kita akan selalu menambahkan validasi terhadap data yang diterima oleh aplikasi. Di database, saat membuat tabel pun, biasanya kita menambahkan validasi, misal kolom yang tidak boleh null, atau unique, atau menambahkan check constraint.

Validasi adalah proses yang dilakukan untuk menjaga agar data di aplikasi kita tetap konsisten dan baik. Tanpa validasi, data di aplikasi bisa rusak dan tidak konsisten.

**Manual Validation**

Saat kita menggunakan Laravel, validasi secara manual sangat tidak direkomendasikan. Misal melakukan pengecekkan apakah input data berisi string kosong, atau apakah input data berupa angka, tanggal, dan lain-lain.

Hal ini bisa saja kita lakukan secara manual, dan melakukan pengecekkan menggunakan if statement. Untungnya, Laravel menyediakan fitur untuk melakukan validasi.

**Laravel Validation**

Laravel menyediakan fitur untuk melakukan validasi menggunakan `Class` bernama [Validator](https://laravel.com/api/10.x/Illuminate/Validation/Validator.html). Disini kita akan fokus membahas bagaimana cara menggunakan Laravel Validation, untuk mempermudah melakukan validasi data yang diterima oleh aplikasi Laravel kita.

## Validator

Validator adalah class sebagai representasi untuk melakukan validasi di Laravel. Pada Class [Validator](https://laravel.com/api/10.x/Illuminate/Validation/Validator.html) Ada banyak sekali fitur yang dimiliki, dan kita akan bahas secara bertahap.

**Membuat Validator**

Untuk membuat Validator, kita bisa menggunakan static method di Facade `Validator::make()`. Saat membuat Validator menggunakan [Support Facade Validator](https://laravel.com/api/10.x/Illuminate/Support/Facades/Validator.html), kita harus tentukan data yang akan divalidasi dan rules (aturan-aturan validasi).

sebelum menggunakan method Facade validator kita musti `use` namespace nya

```php
use Illuminate\Support\Facades\Validator;
```

```php
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
```

## Run Validation

Setelah kita membuat validator, selanjutnya yang biasa kita lakukan adalah mengecek apakah validasi sukses atau gagal. Untuk melakukan itu, kita bisa menggunakan dua method yang mengembalikan nilai boolean.

-   `fails()`, akan mengembalikan true jika gagal, false jika sukses.
-   `passes()`, akan mengembalikkan true jika sukses, false jika gagal.

```php
$validator = Validator::make($data, $rules);

$this->assertTrue($validator->passes());
$this->assertFalse($validator->fails());
```

## Error Message

Saat ini kita melakukan validasi, kita perlu tahu key mana yang bermasalah dan apa pesan error nya. Kita bisa mendapatkan detail dari error menggunakan function `messages()`, `errors()`, atau `getMessageBag()`, dimana semuanya akan mengembalikkan object yang sama yaitu class [`MessageBag`](https://laravel.com/api/10.x/Illuminate/Support/MassageBag.html).

```php
$validator = Validator::make($data, $rules);
$this->assertNotNull($validator);

$message = $validator->getMessageBag();
$message->keys();

Log::info($message->toJson(JSON_PRETTY_PRINT));
```

## Validation Exception

Pada beberapa kasus, kadang-kadang kita ingin menggunakan Exception ketika melakukan validasi. Jika data tidak valid, maka harapan kita terjadi Exception. Validator juga menyediakan fitur ini, dengan menggunakan method `validated()`.

Saat kita memanggil method `validated()`, jika data tidak valid, maka akan throw [`ValidationException`](https://laravel.com/api/10.x/Illuminate/Validation/ValidationException.html). Untuk mendapatkan detail informasi validator dan error message, bisa kita ambil dari [`ValidationException`](https://laravel.com/api/10.x/Illuminate/Validation/ValidationException.html).

```php
$validator = Validator::make($data, $rules);

try {
    $validator->validate();
    $this->fail("ValidationException not thrown");

} catch (ValidationException $exception) {
    $this->assertNotNull($exception->validator);
    $message = $exception->validator->errors();

    Log::error($message->toJson(JSON_PRETTY_PRINT));
}
```

## Validation Rules

-   Salah satu keuntungan menggunakan Laravel Validator, yaitu sudah disediakan aturan-aturan yang bisa kita gunakan untuk melakukan validasi
-   Kita bisa lihat di halaman dokumentasi untuk melihat detail aturan-aturan yang sudah disediakan di Laravel untuk validasi
-   https://laravel.com/docs/10.x/validation#available-validation-rules
-   Bagaimana jika aturan yang kita butuhkan tidak ada? Kita juga bisa membuat aturan sendiri, yang akan dibahas di materi terpisah

**Multiple Rules**

-   Saat kita membuat validasi, biasanya dalam satu attribute, kita sering menggunakan beberapa aturan
-   Misal untuk username, kita ingin menggunakan aturan wajib diisi, harus email, dan panjang tidak boleh lebih dari 100 karakter
-   Untuk menggunakan multiple Rules, kita bisa menggunakan tanda | (pagar), atau menggunakan tipe data array

```php
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
```

## Valid Data

-   Laravel Validator bisa mengembalikan data yang berisikan hanya attribute yang di validasi
-   Hal ini sangat cocok ketika kita memang tidak ingin menggunakan attribute yang tidak di validasi
-   Untuk mendapatkan data tersebut, kita bisa mengguanakan return value `validated()`

```php
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
```

## Validation Message

-   Setiap Rule di Laravel Validator, memiliki validation message
-   Secara default, message-nya menggunakan bahasa inggris, namun kita bisa mengubahnya jika kita mau
-   Semua message di Laravel akan disimpan di dalam folder `lang/{locale}`
-   Jika belum ada folder dan file nya, kita bisa gunakan perintah dibawah ini untuk membuat default message:

          php artisan lang:publish

-   Validation message, terdapat di file `validation.php`

**Custom Message untuk Attribute**

-   Kadang, pada beberapa kasus, kita tidak ingin menggunakan default message saat melakukan validasi
-   Kita bisa menambahkan Costum Message untuk Attribute, di file `validation.php`

```php
'custom' => [
    'username' => [
        'email' => 'We only accept email address for username'
    ]
]
```

**Localization**

-   Message di Laravel, mendukung multi bahasa
-   Caranya kita cukup membuat folder dengan kode locale pada folder lang, dan buat file php validation yang berisi attribute nama
-   Kita bisa mengubah nilai message nya, sesuai dengan bahasanya
-   Untuk mengaktifkan bahasa yang ingin kita gunakan, kita bisa gunakan Facade `App::setLocale()`
-   Jika locale yang kita pilih tidak tersedia, maka secara otomatis akan menggunakan default locale

```php
\Illuminate\Support\Facades\App::setLocale('id');

$data = [
    'username' => 'ucup',
    'password' => 'ucup'
];
$rules = [
    'username' => 'required|email|max:100',
    'password' => 'required|min:6|max:20'
];

$validator = Validator::make($data, $rules);
```

**Inline Message**

-   Kadang, mengubah message file di folder lang mungkin terlalu ribet
-   Kita bisa menambahkan message pada parameter ketika saat membuat Validator menggunakan `Validator::make(data, rules, message)`
-   Secara otomatis, Validator akan mengambil message yang terdapat parameter messages, dan jika tidak ada, maka akan mengambil dari folder lang

```php
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
```

## Additional Validation

-   Saat kita selesai melakukan validasi, kadang kita ingin melakukan validasi tambahan
-   Pada kasus seperti ini, kita bisa menggunakan method `after(callback)`, dimana kita bisa menambahkan function callback sebagai parameter
-   Function callback nya terdapat satu parameter yaitu Validator, sehingga kita bisa menambahkan error tambahan jika dibutuhkan

```php
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
    // ambil data di validator
    $data = $validator->getData();
    if ($data['username'] === $data['password']) {
        // menambahkan error
        $validator->errors()->add('password', 'Password tidak boleh sama dengan username');
    }
});
```

## Custom Rule

-   Walaupun Rule di Laravel sudah tersedia banyak
-   Kadang, pada beberapa kasus, kita perlu membuat Custom Rule sendiri
-   Misal untuk mengecek data ke database, dan lain-lain
-   Untuk membuat rule, kita bisa menggunakan perintah

        php artisan make:rule NamaRule

Contoh kita membuat rule untuk Uppercase:

    php artisan make:rule Uppercase

Lalu buat kode untuk rule nya:

```php
class Uppercase implements ValidationRule
{
    /**
     * Run the validation rule.
     *
     * @param  \Closure(string): \Illuminate\Translation\PotentiallyTranslatedString  $fail
     */
    public function validate(string $attribute, mixed $value, Closure $fail): void
    {
        // if value not uppercase
        if ($value !== strtoupper($value)) {
            $fail("The $attribute must be UPPERCASE");
        }
    }
}
```

Cara menggunakan:

```php
$data = [
    'username' => 'ucup@yahoo.com',
    'password' => 'ucup@yahoo.com'
];

$rules = [
    'username' => ['required', 'email', 'max:100', new \App\Rules\Uppercase()],
    'password' => ['required', 'min:6', 'max:20']
];

$validator = Validator::make($data, $rules);
```

**Translation**

-   Saat membuat Custom Rule, di function validate terdapat parameter ke-3 berupa Closure
-   Closure tersebut jika dipanggil, maka akan mengembalikan object `PotentiallyTranslatedString`
-   *https://laravel.com/api/10.x/Illuminate/Translation/PotentiallyTranslatedString.html*
-   Dengan Class itu, kita bisa membuat translation

Kode untuk translate rule validation

```php
public function validate(string $attribute, mixed $value, Closure $fail): void
{
    if ($value !== strtoupper($value)) {
        $fail("validation.custom.uppercase")->translate([
            'attribute' => $attribute,
            'value' => $value
        ]);
    }
}
```

Setelah itu tambahkan `custom.uppercase` ke dalam file `validation.php`

```php
'custom.uppercase' => 'The :attribute field with value :value must be UPPERCASE',
```

**Data Aware dan Validator Aware**

-   Saat kita membutuhkan Custom Rule yang membutuhkan bisa melihat seluruh data yang di validasi, kita bisa implement interface `DataAwareRule`
-   Dan jika kita butuh object Validator, kita bisa implement interface `ValidatorAwareRule`

Kita coba membuat Rule Registration

```bash
php artisan make:rule RegistrationRule
```

Kode dari file `RegistrationRule.php` dengan mengimplementasikan `DataAwareRule` dan `ValidatorAwareRule`:

```php
class RegistrationRule implements ValidationRule, DataAwareRule, ValidatorAwareRule
{
    private array $data;
    private Validator $validator;

    public function setData(array $data): RegistrationRule
    {
        $this->data = $data;
        return $this;
    }

    public function setValidator(Validator $validator): RegistrationRule
    {
        $this->validator = $validator;
        return $this;
    }

    /**
     * Run the validation rule.
     *
     * @param  \Closure(string): \Illuminate\Translation\PotentiallyTranslatedString  $fail
     */
    public function validate(string $attribute, mixed $value, Closure $fail): void
    {
        $password = $value;
        $username = $this->data['username'];

        if ($password == $username) {
            $fail("The $attribute must be different with username");
        }
    }
}
```

Cara menggunakan:

```php
$rules = [
    'username' => ['required', 'email', 'max:100', new \App\Rules\Uppercase()],
    'password' => ['required', 'min:6', 'max:20', new \App\Rules\RegistrationRule()]
];
```

## Custom Function Rule

-   Pada kasus tertentu kita perlu membuat Custom Rule, namun jika membuat Class Rule terlalu berlebihan, kita bisa menggunakan Custom Function Rule ketika membuat Rule
-   Kita cukup gunakan Function dimana terdapat 3 parameter, `$attribute`, `$value`, dan `$fail`

Cara menggunakan:

```php
$rules = [
    'username' => ['required', 'email', 'max:100', function (string $attribute, string $value, \Closure $fail) {
        if ($value !== strtoupper($value)) {
            $fail("The field $attribute must be UPPERCASE");
        }
    }],
];
```

## Rule Classes

-   Laravel menyediakan beberapa class Rule yang bisa kita gunakan ketika membuat Validator
-   Kita bisa lihat daftar class-class Rule yang tersedia di package `Rules`
-   *https://laravel.com/10.x/Illuminate/Validation/Rules.html*

Cara menggunakan:

```php
$data = [
    'username' => 'Otong',
    'password' => 'otong1@yahoo.com'
];

$rules = [
    'username' => ['required', new \Illuminate\Validation\Rules\In(["Asep", "Bambang", "Otong"])],
    'password' => ['required', \Illuminate\Validation\Rules\Password::min(6)->letters()->numbers()->symbols()]
];

$validator = Validator::make($data, $rules);
```

## Nested Array Validation

-   Saat kita melakukan validasi, kadang data yang kita validasi tidak hanya berformat key-value
-   Kadang terdapat nested array, misal terdapat key address, dimana di dalamnya berisi array lagi
-   Pada kasus data jenis nested array, kita bisa membuat Rule menggunakan tanda `.` (titik), misal `address.street`, `address.city`, dan lain-lain
-   Jika masih terdapat nested array, kita bisa tambahkan `.` (titik) lagi

Cara menggunakan:

```php
$data = [
    'name' => [
        'first' => 'Otong',
        'last' => 'Surotong'
    ],
    'address' => [
        'street' => 'Jl.Danau Maninjau',
        'city' => 'Kota Sorong'
    ]
];

$rules = [
    'name.first' => ['required', 'max:100'],
    'name.last' => 'max:100',
    'address.street' => 'max:150',
    'address.city' => ['required', 'max:100']
];

$validator = Validator::make($data, $rules);
```

**Indexed Array Validation**

-   Pada beberapa kasus, misal nested array nya adalah indexed, artinya bisa lebih dari satu
-   Pada kasus ini, kita tidak menggunakan `.` (titik), melainkan menggunakan `*` (bintang)

Cara menggunakan:

```php
$data = [
    'name' => [
        'first' => 'Otong',
        'last' => 'Surotong'
    ],
    'address' => [
        [
            'street' => 'Jl. Durian',
            'city' => 'Kota Sorong'
        ],
        [
            'street' => 'Jl. Nanas ',
            'city' => 'Kota Sorong'
        ]
    ]
];

$rules = [
    'name.first' => ['required', 'max:100'],
    'name.last' => 'max:100',
    'address.*.street' => 'max:150',
    'address.*.city' => ['required', 'max:100']
];

$validator = Validator::make($data, $rules);
```

## HTTP Request Validation

-   Laravel Validator sudah terintegrasi baik dengan HTTP Request di Laravel
-   Class Request memiliki method `validate()` untuk melakukan validasi data request yang dikirim oleh User, misal dari Form atau Query Parameter
-   *https://laravel.com/api/10.x/Illuminate/Http/Request.html#method_validate*

## Error Page

<br><br>

> Reference by [Programmer Zaman Now](https://programmerzamannow.com)
