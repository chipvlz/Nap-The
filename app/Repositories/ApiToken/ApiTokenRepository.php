<?php
namespace  App\Repositories\ApiToken;

use App\Models\ApiToken;

class ApiTokenRepository implements  ApiTokenRepositoryInterface
{
    public function all()
    {
        return ApiToken::all();
    }

    public function save($data)
    {
        $apiToken = new ApiToken();
        if (isset($data['token'])) {
            $apiToken->token = $data['token'];
        }
        return $apiToken->save();
    }

    public function update($id, $data)
    {

    }

    public function delete($id)
    {

    }

    public function  findAttribute($att, $val)
    {
        return ApiToken::where($att, $val)->first();
    }
}