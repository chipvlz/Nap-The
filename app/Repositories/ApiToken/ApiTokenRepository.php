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
        if (isset($data['provider'])) {
            $apiToken->provider = $data['provider'];
        }
        return $apiToken->save();
    }

    public function update($id, $data)
    {
        $apiToken = ApiToken::find($id);
        if ($apiToken) {
            if (isset($data['active'])) {
                $apiToken->active = $data['active'];
            }
            return $apiToken->save();
        } else {
            return false;
        }
    }

    public function delete($id)
    {

    }

    public function  findAttribute($att, $val)
    {
        return ApiToken::where($att, $val)
            ->where('active',1)
            ->first();
    }
}