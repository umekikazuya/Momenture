<?php

namespace App\Http\Middleware;

use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class BasicAuthMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     *
     * @description
     * リクエストヘッダーからBasic認証情報を検証。
     * 認証情報が欠落しているか無効な場合は、401 Unauthorizedステータスでレスポンスを返す。
     * また、レスポンスのブラウザキャッシュを無効化。
     *
     * 注意: 本ミドルウェアはHTTPS接続上で使用することを強く推奨。
     */
    public function handle(Request $request, \Closure $next): Response
    {
        // 本番環境でHTTPSを強制
        if (app()->environment('production') && ! $request->secure()) {
            return redirect()->secure($request->getRequestUri());
        }

        // 構成からユーザー名・パスワードを取得.
        $user = config('auth.basic.username');
        $pass = config('auth.basic.password');

        // ブラウザキャッシュを無効化.
        header('Cache-Control: no-cache, no-store, must-revalidate');
        header('Pragma: no-cache');
        header('Expires: 0');

        // リクエストヘッダーからBasic認証情報を取得.
        $auth = $request->header('Authorization');

        // Basic認証情報がない場合は、Basic認証を要求.
        if (! $auth) {
            return response('Unauthorized', 401)
                ->header('WWW-Authenticate', 'Basic realm="Protected Area"')
                ->header('Cache-Control', 'no-cache, no-store, must-revalidate')
                ->header('Pragma', 'no-cache')
                ->header('Expires', '0');
        }

        // Basic認証情報がある場合は、デコードしてユーザー名・パスワードを取得.
        try {
            $credentials = str_replace('Basic ', '', $auth);
            $decoded = base64_decode($credentials, true);

            if ($decoded === false) {
                return response('Unauthorized', 401)
                    ->header('WWW-Authenticate', 'Basic realm="Protected Area"')
                    ->header('Cache-Control', 'no-cache, no-store, must-revalidate')
                    ->header('Pragma', 'no-cache')
                    ->header('Expires', '0');
            }

            $parts = explode(':', $decoded, 2);

            if (count($parts) !== 2) {
                return response('Unauthorized', 401)
                    ->header('WWW-Authenticate', 'Basic realm="Protected Area"')
                    ->header('Cache-Control', 'no-cache, no-store, must-revalidate')
                    ->header('Pragma', 'no-cache')
                    ->header('Expires', '0');
            }

            [$inputUser, $inputPass] = $parts;
        } catch (\Exception $e) {
            return response('Unauthorized', 401)
                ->header('WWW-Authenticate', 'Basic realm="Protected Area"')
                ->header('Cache-Control', 'no-cache, no-store, must-revalidate')
                ->header('Pragma', 'no-cache')
                ->header('Expires', '0');
        }

        // 認証チェック.
        if ($inputUser !== $user || $inputPass !== $pass) {
            return response('Unauthorized', 401)
                ->header('WWW-Authenticate', 'Basic realm="Protected Area"')
                ->header('Cache-Control', 'no-cache, no-store, must-revalidate')
                ->header('Pragma', 'no-cache')
                ->header('Expires', '0');
        }

        return $next($request);
    }
}
