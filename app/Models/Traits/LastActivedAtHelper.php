<?php

namespace App\Models\Traits;

use Carbon\Carbon;

trait LastActivedAtHelper
{
    protected $hash_prefix = 'larabbs4_last_actived_at';
    protected $field_prefix = 'user_';

    public function recordLastActivedAt()
    {
        $hash = $this->getHashFromDate(Carbon::now()->toDateString());

        $field = $this->getHashField();

        $now = Carbon::now()->toDateTimeString();

        \Redis::hSet($hash, $field, $now);
    }

    public function syncUserActivedAt()
    {
        $hash = $this->getHashFromDate(Carbon::yesterday()->toDateString());

        $times = \Redis::hGetAll($hash);

        foreach ($times as $id => $time) {
            $user_id = str_replace($this->field_prefix, '', $id);

            if ($user = $this->find($user_id)) {
                $user->last_actived_at = $time;
                $user->save();
            }
        }

        \Redis::del($hash);
    }

    public function getLastActivedAtAttribute($value)
    {
        $hash = $this->getHashFromDate(Carbon::now()->toDateString());

        $field = $this->getHashField();

        $time = \Redis::hGet($hash, $field) ? : $value;

        if ($time) {
            return new Carbon($time);
        } else {
            return $this->created_at;
        }
    }

    private function getHashFromDate($date)
    {
        return $this->hash_prefix . $date;
    }

    private function getHashField()
    {
        return $this->field_prefix . $this->id;
    }
}