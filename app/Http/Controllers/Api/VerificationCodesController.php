<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use Overtrue\EasySms\EasySms;
use App\Http\Requests\Api\VerificationCodeRequest;

class VerificationCodesController extends Controller
{
    public function store(VerificationCodeRequest $request, EasySms $easysms)
    {
        $captchaData = \Cache::get($request->captcha_key);

        if ( ! $captchaData) {
            return $this->response->error('图片验证码已失效', 422);
        }

        if ( ! hash_equals($captchaData['code'], $request->captcha_code)) {
            \Cache::forget($request->captcha_key);
            return $this->response->errorUnauthorized('验证码错误');
        }

        $phone = $captchaData['phone'];

        // 开发环境下可用假的 code
        if ( ! app()->environment('production')) {
            $code = '1234';
        } else {
            // 生成 4 位随机数作为验证码
            $code = str_pad(random_int(1, 9999), 4, 0, STR_PAD_LEFT);

            // 发送
            try {
                $result = $easysms->send($phone, [
                    'content' => "【呵呵橙】您的验证码是{$code}。如非本人操作，请忽略本短信"
                ]);
            } catch (\Overtrue\EasySms\Exceptions\NoGatewayAvailableException $e) {
                $message = $e->getException('yunpian')->getMessage();
                return $this->response->errorInternal($message ?? '短信发送异常');
            }
        }


        // 缓存验证码，15 分钟后过期
        $key = 'verificationCode_' . str_random(15);
        $expiredAt = now()->addMinutes(15);

        \Cache::put($key, ['phone' => $phone, 'code' => $code], $expiredAt);

        return $this->response->array([
            'key' => $key,
            'expired_at' => $expiredAt->toDateTimeString(),
        ])->setStatusCode(201);
    }
}
