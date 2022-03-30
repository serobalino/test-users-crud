<?php

namespace App\Actions\Fortify;

use App\Models\Team;
use App\Models\User;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Laravel\Fortify\Contracts\CreatesNewUsers;
use Laravel\Jetstream\Jetstream;

class CreateNewUser implements CreatesNewUsers
{
    use PasswordValidationRules;

    /**
     * Create a newly registered user.
     *
     * @param  array  $input
     * @return \App\Models\User
     */
    public function create(array $input)
    {
        Validator::make($input, [
            'name' => ['required', 'string', 'max:255'],
            'lastName' => ['required', 'string', 'max:255'],
            'address' => ['required', 'string', 'max:255'],
            'birthDate' => ['required', 'date'],
            'phone' => ['required', 'string', 'max:10','min:9'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'password' => $this->passwordRules(),
            'terms' => Jetstream::hasTermsAndPrivacyPolicyFeature() ? ['accepted', 'required'] : '',
        ])->validate();

        return DB::transaction(function () use ($input) {
            $new = new User();
            $new->name = $input['name'];
            $new->lastName = $input['lastName'];
            $new->address = $input['address'];
            $new->birthDate = $input['birthDate'];
            $new->phone = $input['phone'];
            $new->email = $input['email'];
            $new->password = Hash::make($input['password']);
            $new->save();
            return tap($new, function (User $user) {
                $this->setDefaultTeam($user);
            });
        });
    }


    /**
     * Assig default team
     * @param User $user
     */
    protected function setDefaultTeam(User $user){
        $team = Team::where('is_default',true)->first();
        if($team){
            $user->teams()->attach($team);
            $user->switchTeam($team);
        }
    }
}
