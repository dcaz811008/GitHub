<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\MessageBag;

class NeedLogin
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        // var_dump($request->route()->getPrefix());

        // return $next($request);

        # 取得 route prefix 來選擇要判斷的 SESSION
        $routePrefix = $request->route()->getPrefix();

        $sessionName = $routePrefix . 'Login';
        $urlPath = $routePrefix . '/login';

        if (false == $request->session()->exists($sessionName))
        # session 沒有 $sessionName ，判定為沒有登入，丟回 login
        {
            # 上方為丟一次的 session 處理，改用 MessageBag 進行統一包裝
            $messageBag = new MessageBag();
            $messageBag->add('text', '請先登入');
            return redirect($urlPath)->withErrors($messageBag->all());
        }
        return $next($request);
    }
}
