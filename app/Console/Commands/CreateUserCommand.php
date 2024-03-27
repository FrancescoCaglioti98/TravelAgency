<?php

namespace App\Console\Commands;

use App\Models\Role;
use App\Models\User;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rules\Password;

class CreateUserCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'users:create';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Create a New User';

    /**
     * Execute the console command.
     */
    public function handle(): int
    {

        $user = [];

        $user["name"] = $this->ask( 'User name?' );
        $user["email"] = $this->ask( 'User Email?' );
        $user["password"] = $this->secret( 'User Password?' );

        $roleName = $this->choice( "User Role?", ["admin", "editor"], 1 );
        $role = Role::where( 'name', $roleName )->first();
        if( !$role ) {
            $this->error( "Unknown Role" );

            return -1;
        }

        $validation = Validator::make($user, [
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:App\Models\User,email' ],
            'password' => ['required', Password::defaults()]
        ]);
        if( $validation->fails() ) {
            foreach ( $validation->errors()->all() as $error) {
                $this->error( $error );
            }
            return -1;
        }


        DB::transaction( function() use ( $user, $role ){
            $user['password'] = Hash::make( $user["password"] );
            $newUserCreated = User::create($user);
            $newUserCreated->roles()->attach( $role->id );
        } );

        $this->info( "User " . $user["email"] . " created" );
        return 0;
    }
}
