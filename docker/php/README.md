# PHP Configuration Files

## 概要

このプロジェクトでは、PHP設定を環境別に分離し、優先順位を明確にするため番号付きファイル名を使用しています。

## ファイル構成と読み込み順序

PHPは設定ファイルを**アルファベット順**で読み込み、**後から読み込まれた設定が優先**されます。

### 1. `00-laravel.ini` (基本設定 - 最低優先度)
- Laravel最適化の基本設定
- 全環境共通の基礎設定
- 最初に読み込まれる

### 2. `10-development.ini` (開発環境設定 - 中優先度)  
- 開発環境専用の設定
- `00-laravel.ini`の設定を上書き
- デバッグ有効、制限緩和など

### 3. `20-production.ini` (本番環境設定 - 最高優先度)
- 本番環境専用の設定  
- 前の設定をすべて上書き
- セキュリティ重視、パフォーマンス最適化

## 設定の優先順位

```
00-laravel.ini → 10-development.ini → 20-production.ini
    ↓               ↓                    ↓
基本設定        開発環境上書き      本番環境最終上書き
```

## Docker環境での使用

### 開発環境 (Dockerfile.dev)
```dockerfile
COPY docker/php/00-laravel.ini "$PHP_INI_DIR/conf.d/00-laravel.ini"
COPY docker/php/10-development.ini "$PHP_INI_DIR/conf.d/10-development.ini"
```

### 本番環境 (Dockerfile)
```dockerfile  
COPY docker/php/00-laravel.ini "$PHP_INI_DIR/conf.d/00-laravel.ini"
COPY docker/php/20-production.ini "$PHP_INI_DIR/conf.d/20-production.ini"
```

## 設定変更時の注意点

1. **重複設定の確認**: 複数ファイルで同じディレクティブを設定する場合、番号の大きいファイルが優先されることを確認
2. **環境固有設定**: 環境固有の設定は適切なファイル（10-development.ini または 20-production.ini）に配置
3. **コメント記載**: 設定変更時は理由と影響範囲をコメントで明記
4. **開発環境の安全性**: 開発環境でも暴走プロセス検知のため適切な制限値を設定
5. **一時的な制限解除**: 必要に応じて `php -d memory_limit=-1 artisan command` で一時的に制限を解除可能

## 設定確認方法

コンテナ内で設定値を確認：
```bash
php -i | grep "設定名"
# または
php -r "echo ini_get('設定名');"
```

## 開発時の制限解除方法

重い処理を実行する際の一時的な制限解除：
```bash
# メモリ制限解除
php -d memory_limit=-1 artisan migrate:fresh --seed

# 実行時間制限解除  
php -d max_execution_time=0 artisan queue:work

# 複数設定の同時変更
php -d memory_limit=-1 -d max_execution_time=0 artisan heavy:command
```
