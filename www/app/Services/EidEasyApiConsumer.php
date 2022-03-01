<?php
namespace App\Services;

use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Crypt;

class EidEasyApiConsumer {

    private $http;

    public function __construct()
    {
        $this->http = Http::withOptions([
            'base_uri' => 'https://jsonplaceholder.typicode.com/'
        ]);
    }

    public function checkUserExist(array $params) : bool {

        $result = $this->findUserBy($params);

        if(!empty($result)){
            return $result[0][$params['by']] == $params['value'];
        }
        
        return false;
    }

    public function generateToken(string $value) : string {

        try {
            return Crypt::encryptString($value);
        } catch (DecryptException $e) {
            return '';
        }
    }

    public function decryptToken(string $value) : string {

        try {
            return Crypt::decryptString($value);
        } catch (DecryptException $e) {
            return '';
        }
    }

    public function findUserBy(array $params) : array {
        try {

            return $this->http->get('users', [
                $params['by'] => $params['value']
            ])->json()[0];

        }  catch (Exception $e) {
            return [];
        }
    }
}