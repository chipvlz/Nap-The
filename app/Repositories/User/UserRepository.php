<?php
namespace  App\Repositories\User;


use App\Models\User;

class UserRepository implements  UserRepositoryInterface
{
    public function all()
    {
        return User::all();
    }
    public function save($data)
    {
        $user = new User();
        if (isset($data['name'])) {
            $user->name = $data['name'];
        }
        if (isset($data['fullname'])) {
            $user->fullname = $data['fullname'];
        }
        if (isset($data['email'])) {
            $user->email = $data['email'];
        }
        if (isset($data['phone'])) {
            $user->phone = $data['phone'];
        }
        if (isset($data['token'])) {
            $user->token = $data['token'];
        }
        if (isset($data['is_admin'])) {
            $user->is_admin = $data['is_admin'];
        }
        if (isset($data['image'])) {
            $user->image = $data['image'];
        }
        if (isset($data['password'])) {
            $user->password = bcrypt($data['password']);
        }

        return $user->save();


    }

    public function update($id, $data)
    {
        $user = User::find($id);

        if ($user) {
            if (isset($data['name'])) {
                $user->name = $data['name'];
            }
            if (isset($data['fullname'])) {
                $user->fullname = $data['fullname'];
            }
            if (isset($data['password'])) {
                $user->password = bcrypt($data['password']);
            }
            return $user->save();
        } else {
            return false;
        }

    }

    public function delete($id)
    {
        $user =  User::find($id);
        if ($user) {
            return $user->delete();
        } else {
            return false;
        }
    }
    public function countUser()
    {
        return User::count();
    }

    public  function  findAbtribute($att, $val)
    {
        return User::where($att, $val)->first();
    }

}