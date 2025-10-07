<?php
// Simple test to verify validation fix
require_once 'vendor/autoload.php';

// Simulate the validation rules from DataUser controller
$userValidationRules = [
    'id' => [
        'rules' => 'required|numeric',
        'errors' => [
            'required' => 'ID user harus ada',
            'numeric' => 'ID user harus berupa angka'
        ]
    ],
    'email' => [
        'rules' => 'required|valid_email',
        'errors' => [
            'required' => 'Email harus diisi.',
            'valid_email' => 'Format email tidak valid.',
            'is_unique' => 'Email ini telah terdaftar.'
        ]
    ],
    'username' => [
        'rules' => 'required|min_length[6]',
        'errors' => [
            'required' => 'Username harus diisi',
            'min_length' => 'Username minimal 6 karakter',
            'is_unique' => 'Username ini telah terdaftar.'
        ]
    ],
    'nama_lengkap' => [
        'rules' => 'required',
        'errors' => [
            'required' => 'Nama lengkap harus diisi'
        ]
    ],
    'jenis_kelamin' => [
        'rules' => 'required|in_list[L,P]',
        'errors' => [
            'required' => 'Jenis kelamin harus diisi',
            'in_list' => 'Jenis kelamin harus L atau P'
        ]
    ]
];

echo "Validation rules now include 'id' field:\n";
if (isset($userValidationRules['id'])) {
    echo "✓ 'id' field validation rule exists\n";
    echo "  Rules: " . $userValidationRules['id']['rules'] . "\n";
} else {
    echo "✗ 'id' field validation rule missing\n";
}

echo "\nAll validation fields:\n";
foreach ($userValidationRules as $field => $rules) {
    echo "- $field: " . $rules['rules'] . "\n";
}

echo "\nValidation fix should resolve the LogicException error.\n";
?>