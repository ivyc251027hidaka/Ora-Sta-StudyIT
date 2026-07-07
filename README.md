# Study IT — Oracle Silver SQL 学習アプリ

Oracle Silver SQL 資格取得を目指すための学習支援Webアプリです。  
SQL用語の暗記・クイズ・お気に入り管理・学習履歴の確認ができます。

---

## 機能一覧

| 機能 | 説明 |
|------|------|
| ユーザー認証 | 新規登録・ログイン・ログアウト |
| ダッシュボード | 学習状況の概要表示（正答率・今日の単語・最近の学習） |
| 単語一覧 | SQL用語をカード形式で一覧表示。キーワード・カテゴリ・難易度で絞り込み可能 |
| 単語詳細 | 用語の説明・SQL使用例・学習情報を表示 |
| お気に入り | 単語をお気に入り登録・解除・一覧表示 |
| クイズ | カテゴリ・難易度・問題数を設定して4択クイズに挑戦 |
| 学習履歴 | クイズの解答履歴と正答率を確認 |
| 管理画面 | 管理者のみ単語のCRUD操作が可能 |

---

## 使用技術

| 種別 | 技術 |
|------|------|
| バックエンド | PHP 8.3 / Laravel 13 |
| フロントエンド | Blade / Tailwind CSS |
| データベース | MySQL 8.0 |
| 認証 | Laravel Breeze |
| 開発環境 | Docker（PHP-FPM / Nginx / MySQL / phpMyAdmin） |
| バージョン管理 | Git / GitHub |

---

## DB設計

### テーブル一覧

| テーブル名 | 説明 |
|-----------|------|
| users | ユーザー情報（role: admin/user） |
| words | SQL用語マスタ |
| favorites | お気に入り（users と words の中間テーブル） |
| quiz_histories | クイズ解答履歴 |
| user_word_progress | 単語ごとの習熟度（users と words の中間テーブル） |

---

## 環境構築手順

### 必要なもの
- Docker Desktop
- Git

### セットアップ

```bash
# リポジトリをクローン
git clone https://github.com/ivyc251027hidaka/Ora-Sta-StudyIT.git
cd Ora-Sta-StudyIT

# Dockerコンテナを起動
docker compose up -d

# Laravelの依存パッケージをインストール
docker compose exec app composer install

# .envファイルを作成
cp .env.example .env

# .envのDB設定を変更
DB_CONNECTION=mysql
DB_HOST=db
DB_PORT=3306
DB_DATABASE=study_it
DB_USERNAME=study_it_user
DB_PASSWORD=study_it_pass

# アプリケーションキーを生成
docker compose exec app php artisan key:generate

# マイグレーション実行
docker compose exec app php artisan migrate

# 単語データを投入
docker compose exec app php artisan db:seed --class=WordSeeder

# フロントエンドをビルド
npm install
npm run build
```

### アクセス先

| サービス | URL |
|---------|-----|
| アプリ | http://localhost:8080 |
| phpMyAdmin | http://localhost:8081 |

---

## 画面一覧

| 画面 | URL |
|------|-----|
| ログイン | /login |
| 新規登録 | /register |
| ダッシュボード | /dashboard |
| 単語一覧 | /words |
| 単語詳細 | /words/{id} |
| クイズ設定 | /quiz |
| クイズ挑戦中 | /quiz/play |
| クイズ結果 | /quiz/result |
| お気に入り | /favorites |
| 学習履歴 | /history |
| 管理画面 | /admin |

---

## 開発者

日高 祥