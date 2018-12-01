<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\User;

class GenerateToken extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'larabbs4:generate-token';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = '为用户生成 token';

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
     * @return mixed
     */
    public function handle()
    {
        $user_id = $this->ask('输入用户 id');

        $user = User::find($user_id);

        if ( ! $user) {
            return $this->error('用户不存在');
        }

        $ttl = 365*24*60; // 有效期一年
        $this->info(\Auth::guard('api')->setTTL($ttl)->fromUser($user));
    }
}
