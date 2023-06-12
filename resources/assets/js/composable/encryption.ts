import CryptoJS from 'crypto-js';

function encrypt(string: string, key: string) {
  const iv = CryptoJS.lib.WordArray.random(16);
  const salt = CryptoJS.lib.WordArray.random(256);
  const iterations = 999;
  const encryptMethodLength = 256 / 4;
  const hashKey = CryptoJS.PBKDF2(key, salt, {
    hasher: CryptoJS.algo.SHA512,
    keySize: encryptMethodLength / 8,
    iterations: iterations,
  });

  const encrypted = CryptoJS.AES.encrypt(string, hashKey, {
    mode: CryptoJS.mode.CBC,
    iv: iv,
  });
  const encryptedString = CryptoJS.enc.Base64.stringify(encrypted.ciphertext);

  const output = {
    ciphertext: encryptedString,
    iv: CryptoJS.enc.Hex.stringify(iv),
    salt: CryptoJS.enc.Hex.stringify(salt),
    iterations: iterations,
  };

  return CryptoJS.enc.Base64.stringify(
    CryptoJS.enc.Utf8.parse(JSON.stringify(output))
  );
}

export default encrypt;
