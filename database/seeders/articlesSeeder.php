<?php

namespace Database\Seeders;

use App\Models\Article;
use DateTime;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class articlesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //現データの削除
        $articles = Article::all();
        $articles->each->delete();
        //データの追加
        DB::table('articles')->insert([
            [
                'title' => "トップ",
                'introductory' => "top",
                'body' => "東京杉並にあるソフトウェア開発会社です。「誠心誠意」をモットーとして、お客様の予算に合わせて最適なシステムを提供いたします。",
                'category' => 1,
                'created_at' => new DateTime(),
                'updated_at' => new DateTime()
            ],
            [
                'title' => "事業内容",
                'introductory' => "business",
                'body' =>
                "■システム開発
急速に進歩する技術と製品の多様化による高度化・複雑化が進む一方で、一層の信頼性と安定稼動が求められています。
システムにかかわるすべての事柄に、お客様の立場に立ってコンサルティングからOS、ミドルウェア、パッケージ等の選定・カストマイズ・導入・サポートまで一貫したサービスをご提供致します。
■機械学習プラットフォーム
AIはデータの解析や自動化など、多くの業務領域で革新的な効果を発揮します。当社の技術者は、高度な専門知識を持ち、お客様のニーズに合わせたシステムを開発します。 データ処理、予測分析、自動化タスクなどを実現し、業務の効率化と品質向上に貢献します。
■WEBシステム開発
企業や個人のホームページ、ショッピングサイト、会員制サイト、企業内システムなどお客様のニーズと予算に合わせた実用性の高いWEBシステムを構築します。 使用技術：Laravel(PHP),React,jQuery等
■モバイルアプリ開発
お客様のビジネスに合わせたカスタムアプリを提供します。使いやすさ、スタイリッシュなデザイン、高パフォーマンスなど、お客様の要件に応じて最適なソリューションをご提供します。",
                'category' => 1,
                'created_at' => new DateTime(),
                'updated_at' => new DateTime()
            ],
            [
                'title' => "開発実績のページを追加しました",
                'introductory' => "",
                'body' => "直近の当社が開発したシステムのページを追加しました。上部リンクをクリックしてご参照ください。",
                'category' => 2,
                'created_at' => "2024-10-15 23:43:56",
                'updated_at' => "2024-10-15 23:43:56"
            ],
            [
                'title' => "企業理念",
                'introductory' => "corporate",
                'body' =>
                "いま時代が大きく変革しようとしている中で、社会から問われているのは、いかに物事を直視し、その解決策を提示できるかということだと私たちは考えます。
そのために、私たちは最新の技術とサービスでその答えを導き出すべく、日々努力を重ねております。
そして、その根底に流れるものは、誠心誠意お客様の立場になって考え、かけがえのない存在になることです。
これからは、社会に貢献し、お客様と社会から信頼される企業となることを目標として、さらなる努力を重ねていきたいと考えています。
代表取締役　宮島 郁夫",
                'category' => 3,
                'created_at' => new DateTime(),
                'updated_at' => new DateTime()
            ],
            [
                'title' => "会社概要",
                'introductory' => "company",
                'body' =>
                "■社名
株式会社グローバル (Global Co., Ltd.)
■設立
平成 4年 10月 16日
■資本金
1,500万円
■所在地
〒167-0032 東京都杉並区天沼 1-31-6
■事務所
〒166-0004 東京都杉並区阿佐谷南 1-14-20 ファーストビル阿佐谷 3F 地図
■連絡先
TEL 03-3292-5461　FAX 03-5929-8730
■許認可
全省庁統一資格　等級D（物品の販売、役務の提供等　0000076035）
■役員
代表取締役　　　宮島　郁夫
取締役　　　　　国松　勇次
取締役　　　　　宮坂　栄一
■主要取引先
日本郵政グループ    
株式会社ＳＡＫＵＲＵＧ
富士ソフト株式会社
株式会社フォーカスシステムズ
交通安全協会
日本行政書士政治連盟
(敬称略・順不同)",
                'category' => 3,
                'created_at' => new DateTime(),
                'updated_at' => new DateTime()
            ],
            [
                'title' => "お問合せ",
                'introductory' => "contact",
                'body' => "<span class='text-danger'>※</span>印は必須です。",
                'category' => 3,
                'created_at' => new DateTime(),
                'updated_at' => new DateTime()
            ],
            [
                'title' => "お知らせ",
                'introductory' => "information",
                'body' => "お知らせ一覧です",
                'category' => 3,
                'created_at' => new DateTime(),
                'updated_at' => new DateTime()
            ],
            [
                'title' => "開発実績",
                'introductory' => "item1",
                'body' =>
                "最近の開発事例を紹介します
■ OpenAI APIを活用したQ&Aシステム
社内マニュアルなどの固有情報に関する質問に回答するwebシステム。 素のChatGPTには回答できない非公開の（マニアックな）内容にも、RAG(Retrieval-Augmented Generation)技術で正確に回答することができます。音声での入出力にも対応しており、自然に会話する感じで質問できます。
<使用技術>
フレームワーク:Nextjs
データベース:PostgreSQL(pgvector)
キャラクターボイス合成:AWS ECS/Fargate

■ 手話翻訳システム
手の形、位置、動きを読み取って手話の意味を解読するiOSアプリケーション。郵便局や役所などの受付窓口での使用を想定しています。手話の仕組みを一から勉強し、その仕組みを読み取ることができるようにオリジナルAIを開発しました。
<使用技術>
言語: Swift。学習済みのオリジナルkerasモデルをiOS用に変換して組み込んでいるので、手話翻訳（推論）はスマホでのエッジコンピューティングで動作します。
機械学習:Python、ライブラリはTensorflow/Keras
データベース: Firebase(GCP)

■クイズで知識をつけるアプリ
・WEBなのでインストール不要で、すぐに始められる学習クイズアプリです
・直接入力の問題もあるため、記憶に残りやすくなっています
・ランダムで問題が出題されますので、飽きずに何度でもチャレンジできます
・ユーザーランキングシステムもあり、ゲーム感覚で楽しめます
・段階的に出題され、初めは簡単な問題が出されるため、取り組みやすいです
<使用技術>
言語: PHP(Laravel)TypeScript(React)
データベース:MySQL
<サンプルサイト>
クイズで知識をつけよう",
                'category' => 4,
                'created_at' => new DateTime(),
                'updated_at' => new DateTime()
            ],
        ]);
    }
}
