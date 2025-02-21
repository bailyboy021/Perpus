<?php

return [
    'required' => ':attribute wajib diisi.',
    'integer' => ':attribute harus berupa angka.',
    'min' => [
        'string' => ':attribute minimal harus terdiri dari :min karakter.',
    ],
	'max' => [
        'numeric' => ':attribute tidak boleh lebih dari :max.',
    ],
    'exists' => ':attribute tidak ditemukan di database.',
    'unique' => ':attribute sudah digunakan, pilih yang lain.',
	'confirmed' => ':attribute tidak cocok dengan konfirmasi password.',
	'regex' => ':attribute harus terdiri dari 8 Karakter Alphanumeric dan harus mengandung setidaknya 1 huruf kapital, tidak boleh mengandung special karakter.',
];
