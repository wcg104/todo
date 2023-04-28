<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class makeadmin extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'make:admin';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'make admin';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $name = $this->ask('Enter Name');
        // $number = $this->ask('Enter Number');
        $email = $this->ask('Enter Email');
        $password = $this->ask('Enter Password');

        DB::table('users')->insert([
            'name' =>  $name,
            'number' => '0',
            'email' => $email,
            'password' => Hash::make($password),
            'role' => 'admin',

        ]);

        echo "admin created...";

    }
}
