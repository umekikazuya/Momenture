# コーディングスタイル

APIファースト + ドメイン駆動設計（DDD）+ テスト駆動開発（TDD）

## 目的

このメタプロンプトは、Next.js（フロントエンド）と統合するAPIファーストなLaravelアプリケーション を DDD をベースに構築するための設計指針 を提供する。
特に、以下の点を重視する：
- ビジネスロジックの独立性（ドメイン駆動設計）
- エラーハンドリングの統一（例外ベース）
- テスト駆動開発（TDD）の徹底
- 型安全なDTOと値オブジェクトの活用
- APIドキュメントとの整合性
- SOLID原則に基づいた設計
- 適切なレイヤー分離（オニオンアーキテクチャ）

## 1. 原則（Principles）

### 1.1. APIファースト
- Next.js フロントエンドとの統合を前提としたバックエンド
- RESTful 設計に準拠し、エラーハンドリング・認証・レスポンスフォーマットを統一
- OpenAPI 仕様を活用し、API の設計と実装の整合性を確保

### 1.2. DDD（ドメイン駆動設計）の適用

DDD の原則に基づき、以下のレイヤーに分割する

1️⃣ ドメイン層（Domain Layer）
- ビジネスロジックの中心となるレイヤー
- エンティティ（Entity）
- 値オブジェクト（ValueObject）
- ドメインサービス（DomainService）
- ドメインイベント（DomainEvent）
- 集約ルート（Aggregate Root）

2️⃣ アプリケーション層（Application Layer）
- ドメイン層の機能をユースケース単位で実行
- ユースケース（UseCase）
- DTO（Data Transfer Object）
- クエリサービス（QueryService）

3️⃣ インフラストラクチャ層（Infrastructure Layer）
- 永続化のためのデータアクセス（Eloquent, Redis, S3, 外部API など）
- リポジトリ（Repository）
- キャッシュサービス（CacheService）
- 外部APIクライアント（ExternalApiClient）

4️⃣ プレゼンテーション層（Presentation Layer）
- リクエストのバリデーションを行い、アプリケーション層のユースケースを呼び出す
- コントローラ（Controller）
- リクエストバリデーション（FormRequest）
- APIレスポンス整形（JsonResource）


### 1.3. 例外ベースのエラーハンドリング
- ドメインエラー（DomainException）
- アプリケーションエラー（ApplicationException）
- インフラエラー（InfrastructureException）
- 統一したエラーレスポンスの設計
```json
{
  "status": "error",
  "message": "対象のデータが見つかりません",
  "code": 404
}
```

### 1.4. TDD（テスト駆動開発）の適用

Red-Green-Refactor のサイクルを厳密に適用：
  1.  Red → まず失敗するテストを書く
  2.  Green → 最小の実装でテストを通す
  3.  Refactor → 設計を改善し、再テスト

テストレイヤー
- ユニットテスト（ドメイン層）
- ユースケーステスト（アプリケーション層）
- APIテスト（プレゼンテーション層）
- 統合テスト（データアクセスを含めた全体）


## 2. 実装手順（Implementation Workflow）
1. ユビキタス言語の定義（チーム内での用語統一）
2. ドメインの設計（エンティティ、値オブジェクト、集約ルート）
3. リポジトリのインターフェース設計
4. ユースケースの設計（DTOを定義）
5. ユースケースのテスト作成（TDD）
6. リポジトリの実装（Eloquent などの具体的な実装）
7. プレゼンテーション層の実装（Controller, API, Validation）
8. APIドキュメントの作成・更新
9. 統合テスト・リファクタリング

## 3. ディレクトリ構成
```text
app/
│── Domain/         # ドメイン層（ビジネスロジックの核）
│   ├── Entities/
│   ├── ValueObjects/
│   ├── Services/
│   ├── Events/
│── Application/    # アプリケーション層（ユースケースの実装）
│   ├── UseCases/
│   ├── DTOs/
│   ├── Queries/
│── Infrastructure/ # インフラ層（永続化・外部API・キャッシュなど）
│   ├── Repositories/
│   ├── ExternalApis/
│   ├── Cache/
│── Http/          # プレゼンテーション層（リクエスト処理）
│   ├── Controllers/
│   ├── Requests/
│   ├── Resources/
│── Exceptions/    # 例外クラス
│── Providers/     # DI 設定
tests/
│── Unit/          # ユニットテスト（ドメイン層）
│── Feature/       # 機能テスト（API & ユースケース）
│── Integration/   # 統合テスト（DBを含む）
```

## 4. API設計のベストプラクティス
- エンドポイントはリソースベース（/articles, /users）に統一
- エラーレスポンスのフォーマットを統一
- OpenAPI / JSON:API 準拠
- リクエスト/レスポンスの DTO を必ず設計
- キャッシュやレートリミットの適用を検討


## 5. TDDによるテスト設計

✅ ドメイン層のテスト
- 値オブジェクト・エンティティの動作を保証
- ビジネスルールの検証

✅ ユースケースのテスト
- リポジトリをモック化し、ユースケースのロジックをテスト

✅ APIテスト
- FeatureTest でリクエストをシミュレートし、期待したレスポンスを検証

✅ 統合テスト
- DBを含むエンドツーエンドのテスト


## 6. CI/CD & デプロイ
- GitHub Actions などを利用して CI/CD を構築
- テストが通らない場合はデプロイをブロック
- 環境ごとに .env を管理
- 本番環境では Redis などを活用したキャッシュを導入
- エラーログの監視（Sentry, Datadog など）を設定


## 7. 運用・保守
- API のバージョン管理（v1, v2 など）
- パフォーマンス改善（キャッシュ・DB最適化）
- 定期的なコードレビュー & リファクタリング
