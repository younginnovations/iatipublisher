<?php

declare(strict_types=1);

use Illuminate\Encryption\Encrypter;

if (!function_exists('customDecryptString')) {
    /**
     * Decryption using the encryption method of application.
     *
     * @param string      $encryptedString
     * @param string|null $key
     *
     * @return bool|string|null
     */
    function customDecryptString(string $encryptedString, string $key = null): bool|string|null
    {
        $frontendEncryptor = new Encrypter($key ?? env('MIX_ENCRYPTION_KEY'), Config::get('app.cipher'));

        return $frontendEncryptor->decrypt($encryptedString);
    }
}

if (!function_exists('customEncryptString')) {
    /**
     * Encryption using encryption method of application.
     *
     * @param string      $string
     * @param string|null $key
     *
     * @return bool|string|null
     */
    function customEncryptString(string $string, string $key = null): bool|string|null
    {
        $frontendEncryptor = new Encrypter($key ?? env('MIX_ENCRYPTION_KEY'), Config::get('app.cipher'));

        return $frontendEncryptor->encrypt($string);
    }
}

if (!function_exists('encryptString')) {
    /**
     * Encrypts string.
     *
     * @param string $string
     *
     * @return bool|string|null
     * @throws Exception
     */
    function encryptString(string $string): bool|string|null
    {
        $iv = random_bytes(16);
        $salt = random_bytes(256);
        $iterations = 999;
        $encryptMethodLength = 256 / 4;
        $hashKey = hash_pbkdf2('sha512', env('MIX_ENCRYPTION_KEY'), $salt, $iterations, $encryptMethodLength);
        $encryptedData = openssl_encrypt($string, 'AES-256-CBC', hex2bin($hashKey), OPENSSL_RAW_DATA, $iv);
        $output = ['ciphertext' => base64_encode($encryptedData), 'iv' => bin2hex($iv), 'salt' => bin2hex($salt), 'iterations' => $iterations];

        return base64_encode(json_encode($output, JSON_THROW_ON_ERROR));
    }
}
