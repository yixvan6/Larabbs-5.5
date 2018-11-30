<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Http\Requests\Api\CaptchaRequest;
use Gregwar\Captcha\CaptchaBuilder;

class CaptchasController extends Controller
{
    public function store(CaptchaRequest $request, CaptchaBuilder $builder)
    {
        $phone = $request->phone;

        // 生成图片验证码
        $captcha = $builder->build();

        // 缓存验证码数据，2 分钟后过期
        $key = 'captcha-' . str_random(15);
        $expiredAt = now()->addMinutes(2);

        \Cache::put($key, ['phone' => $phone, 'code' => $captcha->getPhrase()], $expiredAt);

        return $this->response->array([
            'captcha_key' => $key,
            'captcha_image_content' => $captcha->inline(),
            'expired_at' => $expiredAt->toDateTimeString()
        ])->setStatusCode(201);
    }
}
