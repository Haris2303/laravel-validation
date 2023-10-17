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
