<?php

namespace App\Http\Middleware;

use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class BasicAuthMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response) $next
     */
    public function handle(Request $request, \Closure $next): Response
    {
        // 環境変数からユーザー名・パスワードを取得
        $user = env('BASIC_AUTH_USER', 'admin');
        $pass = env('BASIC_AUTH_PASS', 'secret');

        // ブラウザキャッシュを無効化
        header('Cache-Control: no-cache, no-store, must-revalidate');
        header('Pragma: no-cache');
        header('Expires: 0');

        // リクエストヘッダーからBasic認証情報を取得
        $auth = $request->header('Authorization');

        // Basic認証情報がない場合は、Basic認証ダイアログを要求するヘッダーを付与
        if (! $auth) {
            header('WWW-Authenticate: Basic realm="Protected Area"');

            return response('Unauthorized', 401);
        }

        // Basic認証情報がある場合は、デコードしてユーザー名・パスワードを取得
        $auth = base64_decode(str_replace('Basic ', '', $auth));
        [$inputUser, $inputPass] = explode(':', $auth);

        // 認証チェック
        if ($inputUser !== $user || $inputPass !== $pass) {
            return response('Unauthorized', 401);
        }

        return $next($request);
    }
}
