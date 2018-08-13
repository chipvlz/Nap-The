<?php
namespace  App\Repositories\User;


use App\Models\User;

class UserRepository implements  UserRepositoryInterface
{
    public function all()
    {

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
        if (isset($data['password'])) {
            $user->password = bcrypt($data['password']);
        }


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

    }

}