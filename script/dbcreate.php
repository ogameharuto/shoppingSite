<?php
/*
 dbCreate.php（データベース初期化）

 @author  田岡勇大
 @version 2.0
 @date    6月10日
*/

/* インポート */
require_once('utilConnDB.php');
$utilConnDB = new UtilConnDB();

/*
 * データベース作成
 */
$dbSW  = $utilConnDB->createDB();  // false:not create
/*
 * データベースに接続
 */
$pdo   = $utilConnDB->connect();   // null:not found

/*
 * 外部キー制約を一時的に無効にする
 */
$pdo->exec('SET FOREIGN_KEY_CHECKS = 0;');

/*
 * テーブルを削除する関数
 */
function dropTableIfExists($pdo, $tableName) {
    $sql = "SHOW TABLES LIKE '$tableName';";
    $ret = $pdo->query($sql);
    if ($ret->fetch(PDO::FETCH_NUM)) {
        $sql = "DROP TABLE $tableName;";
        $pdo->exec($sql);
    }
}

/*
 * テーブルを削除
 */
$tables = [
    'review',
    'images',
    'cart',
    'orderDetail',
    'orderTable',
    'product',
    'dateAndTimeSettings',
    'storeCategory',
    'store',
    'customer',
    'category'
];

foreach ($tables as $table) {
    dropTableIfExists($pdo, $table);
}

/*
 * 外部キー制約を再度有効にする
 */
$pdo->exec('SET FOREIGN_KEY_CHECKS = 1;');

/*
 * テーブル作成およびデータ挿入
 */

// カテゴリテーブル作成
$sql = 'CREATE TABLE category (
  categoryNumber INT AUTO_INCREMENT PRIMARY KEY NOT NULL,
  categoryName VARCHAR(50) NOT NULL,
  parentCategoryNumber INT,
  FOREIGN KEY (parentCategoryNumber) REFERENCES category(categoryNumber) ON DELETE CASCADE ON UPDATE CASCADE
);';
$pdo->exec($sql);

// カテゴリデータ挿入
$sql = "INSERT INTO category (categoryName, parentCategoryNumber) VALUES
  ('レディースファッション', NULL),
  ('メンズファッション', NULL),
  ('腕時計、アクセサリー', NULL),
  ('ベビー、キッズ、マタニティ', NULL),
  ('食品', NULL),
  ('ドリンク、水、お酒', NULL),
  ('ダイエット、健康', NULL),
  ('コスメ、美容、ヘアケア', NULL),
  ('家電', NULL),
  ('スマホ、タブレット、パソコン', NULL),
  ('テレビ、オーディオ、カメラ', NULL),
  ('家具、インテリア', NULL),
  ('DIY、工具', NULL),
  ('花、ガーデニング', NULL),
  ('キッチン、日用品、文具', NULL),
  ('ペット用品、生き物', NULL),
  ('楽器、手芸、コレクション', NULL),
  ('ゲーム、おもちゃ', NULL),
  ('スポーツ', NULL),
  ('アウトドア、釣り、旅行用品', NULL),
  ('車、バイク、自転車', NULL),
  ('CD、音楽ソフト、チケット', NULL),
  ('DVD、映像ソフト', NULL),
  ('本、雑誌、コミック', NULL),
  ('レンタル、各種サービス', NULL),
  ('トップス', 1),
  ('シューズ', 1),
  ('財布、帽子、ファッション小物', 1),
  ('バッグ', 1),
  ('下着、靴下、部屋着', 1),
  ('ボトムス、パンツ', 1),
  ('着物、浴衣', 1),
  ('水着', 1),
  ('コート、アウター', 1),
  ('ジャケット', 1),
  ('スーツ、フォーマル', 1),
  ('オールインワン,セットアップ', 1),
  ('ジャージ、スウェット', 1),
  ('学生服', 1),
  ('その他', 1),
  ('ワンピース、チュニック', 1),
  ('ドレス、ブライダル', 1),
  ('コスチューム、コスプレ衣装', 1),
  ('トップス', 2),
  ('シューズ', 2),
  ('財布、帽子、ファッション小物', 2),
  ('バッグ', 2),
  ('下着、靴下、部屋着', 2),
  ('ボトムス、パンツ', 2),
  ('着物、浴衣', 2),
  ('水着', 2),
  ('コート、アウター', 2),
  ('ジャケット', 2),
  ('スーツ、フォーマル', 2),
  ('オールインワン、つなぎ', 2),
  ('ジャージ、スウェット', 2),
  ('学生服', 2),
  ('その他', 2),
  ('ワイシャツ', 2),
  ('ネクタイ', 2),
  ('レディースアクセサリー', 3),
  ('メンズアクセサリー', 3),
  ('ペアアクセサリー', 3),
  ('メンズ腕時計', 3),
  ('レディース腕時計', 3),
  ('ペア腕時計', 3),
  ('スマートウォッチ', 3),
  ('腕時計用品', 3),
  ('懐中時計', 3),
  ('宝石ルース、裸石', 3),
  ('インゴット', 3),
  ('ブライダルアクセサリー', 3),
  ('子ども服、シューズ', 4),
  ('ベビー用寝具、ベッド', 4),
  ('おもちゃ、教材', 4),
  ('記念、行事用品', 4),
  ('バッグ、ランドセル', 4),
  ('ベビー服、シューズ', 4),
  ('子ども用家具', 4),
  ('おむつ、トイレ用品', 4),
  ('お風呂、バス用品', 4),
  ('衛生用品、ヘルスケア', 4),
  ('授乳、食事用品', 4),
  ('子ども用自転車、三輪車', 4),
  ('ベビーシート、チャイルドシート', 4),
  ('出産祝い、出産記念品', 4),
  ('ベビー用セーフティグッズ', 4),
  ('マタニティウエア', 4),
  ('ベビー用家具', 4),
  ('ベビーカー', 4),
  ('マタニティ、産後用具', 4),
  ('抱っこ紐、おんぶ紐', 4),
  ('お名前シール、ネームラベル', 4),
  ('子ども用寝具、ベッド', 4),
  ('授乳、産後ウェア', 4),
  ('子ども用セーフティグッズ', 4),
  ('スリング', 4),
  ('その他', 4),
  ('惣菜、料理', 5),
  ('米、雑穀、粉類', 5),
  ('スナック、お菓子、おつまみ', 5),
  ('魚介類、海産物', 5),
  ('調味料、料理の素、油', 5),
  ('スイーツ、洋菓子', 5),
  ('フルーツ', 5),
  ('肉、ハム、ソーセージ', 5),
  ('製菓材料、パン材料', 5),
  ('麺類、パスタ', 5),
  ('和菓子、中華菓子', 5),
  ('乾物、乾燥豆類、缶詰', 5),
  ('漬物、佃煮、ふりかけ', 5),
  ('野菜', 5),
  ('パン、シリアル', 5),
  ('チーズ、乳製品、卵', 5),
  ('豆腐、納豆、こんにゃく', 5),
  ('非常用食品', 5),
  ('その他食品', 5),
  ('ソフトドリンク、ジュース', 6),
  ('水、炭酸水', 6),
  ('コーヒー', 6),
  ('ビール、発泡酒', 6),
  ('ワイン', 6),
  ('洋酒', 6),
  ('焼酎', 6),
  ('ハイボール、チューハイ', 6),
  ('緑茶、日本茶', 6),
  ('日本酒', 6),
  ('健康茶', 6),
  ('ハーブティー', 6),
  ('紅茶', 6),
  ('中国茶', 6),
  ('リキュール', 6),
  ('梅酒、果実酒', 6),
  ('ココア', 6),
  ('韓国酒、マッコリ', 6),
  ('フレーバーティー', 6),
  ('中国酒、紹興酒', 6),
  ('カクテル', 6),
  ('その他ドリンク、水、お酒', 6),
  ('衛生日用品', 7),
  ('サプリメント', 7),
  ('コンタクトレンズ、ケア用品', 7),
  ('医薬品、医薬部外品', 7),
  ('ダイエット', 7),
  ('オーラルケア', 7),
  ('介護用品', 7),
  ('健康飲料', 7),
  ('マッサージ、リラクゼーション', 7),
  ('メガネ、老眼鏡', 7),
  ('健康管理、計測計', 7),
  ('鍼、灸、治療器', 7),
  ('暑さ対策、冷却グッズ', 7),
  ('矯正用品、補助ベルト', 7),
  ('アロマグッズ', 7),
  ('衛生医療用品、救急用品', 7),
  ('健康アクセサリー', 7),
  ('バランス栄養、栄養調整食品', 7),
  ('補聴器', 7),
  ('いびき防止グッズ', 7),
  ('冷え対策、保温グッズ', 7),
  ('特定保健用食品(トクホ)', 7),
  ('禁煙グッズ', 7),
  ('花粉症対策グッズ', 7),
  ('その他ダイエット、健康', 7),
  ('スキンケア、基礎化粧品', 8),
  ('レディースヘアケア', 8),
  ('ボディケア', 8),
  ('ベースメイク', 8),
  ('フェイスケア', 8),
  ('メイクアップ', 8),
  ('メンズシェービング用品', 8),
  ('香水', 8),
  ('ネイル', 8),
  ('メイク道具', 8),
  ('メンズヘアケア', 8),
  ('日焼け止め', 8),
  ('脱毛、除毛', 8),
  ('メンズスキンケア、メイク', 8),
  ('まつ毛、つけまつ毛用品', 8),
  ('制汗剤、デオドラント', 8),
  ('コフレ、セット', 8),
  ('冷暖房器具、空調家電', 9),
  ('キッチン家電', 9),
  ('美容家電', 9),
  ('情報家電', 9),
  ('生活家電', 9),
  ('オーディオ機器', 9),
  ('テレビ、映像機器', 9),
  ('健康家電', 9),
  ('カメラ', 9),
  ('電池、充電池', 9),
  ('望遠鏡、光学機器', 9),
  ('スマホ、タブレットアクセサリー、周辺機器', 10),
  ('パソコン周辺機器', 10),
  ('PCサプライ、アクセサリー', 10),
  ('PCパーツ', 10),
  ('スマートウォッチ、ウェアラブル端末', 10),
  ('タブレットPC', 10),
  ('ノートパソコン', 10),
  ('ソフトウェア', 10),
  ('スマホ', 10),
  ('プリンター、複合機', 10),
  ('ディスプレイ、モニター', 10),
  ('携帯電話', 10),
  ('デスクトップパソコン', 10),
  ('SIMカード', 10),
  ('その他', 10),
  ('オーディオ機器', 11),
  ('テレビ、映像機器', 11),
  ('カメラ', 11),
  ('望遠鏡、光学機器', 11),
  ('テレビ台、キャビネット', 12),
  ('布団、寝具', 12),
  ('照明、電球', 12),
  ('インテリア雑貨', 12),
  ('カーペット、ラグ、マット', 12),
  ('ベッド、マットレス', 12),
  ('椅子、スツール、座椅子', 12),
  ('クッション、座布団', 12),
  ('カーテン、ブラインド', 12),
  ('チェスト、衣類収納', 12),
  ('テーブル', 12),
  ('オフィス家具', 12),
  ('ラック、シェルフ、本棚', 12),
  ('ソファ、ソファベッド', 12),
  ('プラケース、押入れ収納', 12),
  ('キッチン収納', 12),
  ('子供部屋家具', 12),
  ('インテリア時計', 12),
  ('デスク、机', 12),
  ('ファブリック、カバー類', 12),
  ('ミラー、ドレッサー', 12),
  ('ウォールデコレーション', 12),
  ('玄関家具', 12),
  ('ランドリー、サニタリー収納', 12),
  ('こたつ', 12),
  ('パーテーション、衝立', 12),
  ('業務、産業用', 13),
  ('住宅設備', 13),
  ('材料、部品', 13),
  ('オフィス用品', 13),
  ('道具、工具', 13),
  ('庭、ガーデニング', 13),
  ('その他DIY、業務、産業用品', 13),
  ('園芸用品', 14),
  ('苗', 14),
  ('フラワーアレンジメント', 14),
  ('生花', 14),
  ('アレンジメント用品、資材', 14),
  ('種、種子', 14),
  ('造花、アートフラワー', 14),
  ('苗木、植木', 14),
  ('観葉植物', 14),
  ('プリザーブドフラワー', 14),
  ('花瓶、花台', 14),
  ('人工芝', 14),
  ('水生植物', 14),
  ('盆栽、苔玉', 14),
  ('サボテン、多肉植物', 14),
  ('人工観葉、フェイクグリーン', 14),
  ('球根、種芋', 14),
  ('ドライフラワー', 14),
  ('ハーバリウム', 14),
  ('リース', 14),
  ('その他花、ガーデニング', 14),
  ('キッチン、台所用品', 15),
  ('芳香剤、消臭剤、除湿剤', 15),
  ('防災、防犯、セーフティ', 15),
  ('バス、洗面所用品', 15),
  ('文具、ステーショナリー', 15),
  ('掃除用具', 15),
  ('洗濯用品', 15),
  ('トイレ用品', 15),
  ('蚊取り、防虫、害虫駆除', 15),
  ('タオル', 15),
  ('冠婚葬祭、宗教用品', 15),
  ('スリッパ', 15),
  ('ゴミ箱、ダストボックス', 15),
  ('カタログギフト', 15),
  ('ギフト券（券、カード販売）', 15),
  ('ギフト券（コード販売）', 15),
  ('その他キッチン、日用品、文具', 15),
  ('犬用品', 16),
  ('猫用品', 16),
  ('熱帯魚、アクアリウム用品', 16),
  ('小動物用品', 16),
  ('生き物、生体', 16),
  ('鳥用品', 16),
  ('動物用医薬品', 16),
  ('昆虫用品', 16),
  ('爬虫類、両生類用品', 16),
  ('メモリアル、オーナーズグッズ', 16),
  ('その他ペット用品、生き物', 16),
  ('楽器、器材', 17),
  ('手芸、ハンドクラフト', 17),
  ('コレクション、趣味', 17),
  ('画材、アート用品', 17),
  ('コスプレ衣装', 17),
  ('占い、開運', 17),
  ('美術、工芸品', 17),
  ('実験、工作', 17),
  ('その他楽器、手芸、コレクション', 17),
  ('テレビゲーム', 18),
  ('おもちゃ', 18),
  ('カードゲーム', 18),
  ('模型、プラモデル', 18),
  ('トレーディングカード', 18),
  ('フィギュア', 18),
  ('パーティグッズ', 18),
  ('ラジコン', 18),
  ('食玩、プライズ、カプセル', 18),
  ('ミニカー', 18),
  ('季節玩具', 18),
  ('乗用玩具', 18),
  ('パズル', 18),
  ('ボードゲーム', 18),
  ('ダーツ', 18),
  ('麻雀', 18),
  ('将棋', 18),
  ('ビリヤード', 18),
  ('囲碁', 18),
  ('その他おもちゃ', 18),
  ('ゴルフ', 19),
  ('フィットネス、トレーニング', 19),
  ('マラソン、ランニング', 19),
  ('野球', 19),
  ('マリンスポーツ', 19),
  ('テニス', 19),
  ('サッカー、フットサル', 19),
  ('水泳', 19),
  ('スポーツケア用品', 19),
  ('陸上、トラック、フィールド', 19),
  ('バスケットボール', 19),
  ('ヨガ、ピラティス', 19),
  ('バドミントン', 19),
  ('スポーツアクセサリー', 19),
  ('武道、格闘技', 19),
  ('コンプレッションウエア', 19),
  ('バレーボール', 19),
  ('ダンス、バレエ', 19),
  ('卓球', 19),
  ('ストリート系スポーツ', 19),
  ('体育器具、用品', 19),
  ('スポーツバッグ（汎用）', 19),
  ('スノーボード', 19),
  ('スキー', 19),
  ('ラグビー', 19),
  ('ソフトボール', 19),
  ('新体操、器械体操', 19),
  ('スポーツ用下着（汎用）', 19),
  ('その他の競技種目', 19),
  ('アウトドア、キャンプ、登山', 20),
  ('釣り', 20),
  ('旅行用品', 20),
  ('カヌー、カヤック、ボート', 20),
  ('プレジャーボート、ヨット', 20),
  ('海外おみやげ', 20),
  ('その他アウトドア用品', 20),
  ('自動車', 21),
  ('バイク', 21),
  ('自転車', 21),
  ('邦楽', 22),
  ('洋楽', 22),
  ('アニメ、ゲーム', 22),
  ('KーPOP', 22),
  ('クラシック', 22),
  ('サウンドトラック', 22),
  ('ワールドミュージック', 22),
  ('ジャズ、フュージョン', 22),
  ('インディーズ', 22),
  ('キッズ、ファミリー', 22),
  ('ヒーリング、ニューエイジ', 22),
  ('実用', 22),
  ('インストゥルメンタル', 22),
  ('チケット', 22),
  ('その他', 22),
  ('ミュージック', 23),
  ('アニメーション', 23),
  ('テレビドラマ', 23),
  ('洋画', 23),
  ('邦画', 23),
  ('お笑い、バラエティ', 23),
  ('趣味、実用、教養', 23),
  ('アイドル、イメージ', 23),
  ('キッズ、ファミリー', 23),
  ('スポーツ、フィットネス', 23),
  ('演劇、ミュージカル', 23),
  ('その他', 23),
  ('コミック、アニメ', 24),
  ('文芸', 24),
  ('雑誌', 24),
  ('生活', 24),
  ('ビジネス、経済', 24),
  ('子ども', 24),
  ('趣味', 24),
  ('学習参考書', 24),
  ('芸術', 24),
  ('歴史、心理、教育', 24),
  ('楽譜、音楽書', 24),
  ('理学、工学', 24),
  ('語学、辞書', 24),
  ('医学、薬学、看護', 24),
  ('法律、社会', 24),
  ('エンターテインメント', 24),
  ('就職、資格', 24),
  ('コンピュータ', 24),
  ('地図、ガイド', 24),
  ('アイドル写真集', 24),
  ('関連グッズ', 24),
  ('ゲーム攻略本', 24),
  ('洋書', 24),
  ('電子書籍', 24),
  ('レンタル', 25),
  ('クリーニング', 25),
  ('サービスクーポン、引換券', 25),
  ('お掃除、訪問サービス', 25),
  ('衣料品お直し', 25),
  ('リフォーム', 25),
  ('車関連サービス', 25),
  ('ペット関連サービス', 25),
  ('その他サービス', 25);";
$pdo->exec($sql);

// 顧客テーブル作成
$sql = 'CREATE TABLE customer (
  customerNumber INT AUTO_INCREMENT PRIMARY KEY NOT NULL,
  customerName VARCHAR(50) NOT NULL,
  furigana VARCHAR(50) NOT NULL,
  address VARCHAR(100) NOT NULL,
  postCode VARCHAR(10) NOT NULL,
  dateOfBirth DATE NOT NULL,
  mailAddress VARCHAR(50) UNIQUE NOT NULL,
  telephoneNumber VARCHAR(20) NOT NULL,
  password VARCHAR(50) NOT NULL
);';
$pdo->exec($sql);

// 顧客データ挿入
$sql = "INSERT INTO customer (customerName, furigana, address, postCode, dateOfBirth, mailAddress, telephoneNumber, password) VALUES
  ('山田 太郎', 'ヤマダ タロウ', '東京都千代田区', '1000001', '1980-01-01', 'yamada@example.com', '09012345678', 'password123'),
  ('佐藤 花子', 'サトウ ハナコ', '大阪府大阪市', '5400001', '1990-05-05', 'sato@example.com', '08098765432', 'password456');";
$pdo->exec($sql);

// 店舗テーブル作成
$sql = 'CREATE TABLE store (
  storeNumber INT AUTO_INCREMENT PRIMARY KEY NOT NULL,
  companyName VARCHAR(50) NOT NULL,
  companyPostalCode VARCHAR(10) NOT NULL,
  companyAddress VARCHAR(100) NOT NULL,
  companyRepresentative VARCHAR(50) NOT NULL,
  storeName VARCHAR(50) NOT NULL,
  furigana VARCHAR(50) NOT NULL,
  telephoneNumber VARCHAR(20) NOT NULL,
  mailAddress VARCHAR(50) NOT NULL,
  storeDescription VARCHAR(2000) NOT NULL,
  storeImageURL VARCHAR(255) NOT NULL,
  storeAdditionalInfo VARCHAR(2000) NOT NULL,
  operationsManager VARCHAR(50) NOT NULL,
  contactAddress VARCHAR(100) NOT NULL,
  contactPostalCode VARCHAR(10) NOT NULL,
  contactPhoneNumber VARCHAR(20) NOT NULL,
  contactEmailAddress VARCHAR(50) NOT NULL,
  password VARCHAR(50) NOT NULL
);';
$pdo->exec($sql);

// 店舗データ挿入
$sql = "INSERT INTO store (companyName, companyPostalCode, companyAddress, companyRepresentative, storeName, furigana, telephoneNumber, mailAddress, storeDescription, storeImageURL, storeAdditionalInfo, operationsManager, contactAddress, contactPostalCode, contactPhoneNumber, contactEmailAddress, password) VALUES
  ('株式会社ストアA', '1000001', '東京都千代田区', '田中 一郎', 'ストアA', 'ストア エー', '0355556666', 'storea@example.com', '電子機器とガジェット', 'https://example.com/storea.jpg', '営業時間: 9:00 - 18:00', '田中 一郎', '東京都千代田区', '1000001', '0355556666', 'contacta@example.com', 'password789'),
  ('株式会社ストアB', '5400001', '大阪府大阪市', '鈴木 二郎', 'ストアB', 'ストア ビー', '0677778888', 'storeb@example.com', '書籍と文房具', 'https://example.com/storeb.jpg', '営業時間: 10:00 - 19:00', '鈴木 二郎', '大阪府大阪市', '5400001', '0677778888', 'contactb@example.com', 'password101');";
$pdo->exec($sql);

// 店舗カテゴリテーブル作成
$sql = 'CREATE TABLE storeCategory (
  storeCategoryNumber INT AUTO_INCREMENT PRIMARY KEY NOT NULL,
  storeCategoryName VARCHAR(50) NOT NULL,
  parentStoreCategoryNumber INT,
  storeNumber INT,
  FOREIGN KEY (parentStoreCategoryNumber) REFERENCES storeCategory(storeCategoryNumber) ON DELETE CASCADE ON UPDATE CASCADE,
  FOREIGN KEY (storeNumber) REFERENCES store(storeNumber) ON DELETE CASCADE ON UPDATE CASCADE
);';
$pdo->exec($sql);

// 店舗カテゴリデータ挿入
//$sql = "INSERT INTO storeCategory (categoryName, parentCategoryNumber) VALUES
 // ('家電', NULL),
//  ('本', NULL),
//  ('スマホ', 1),
//  ('ノートパソコン', 1);";
//$pdo->exec($sql);

// 画像テーブル作成
$sql = 'CREATE TABLE images (
  imageNumber INT AUTO_INCREMENT PRIMARY KEY NOT NULL,
  imageHash VARCHAR(256) NOT NULL,
  imageName VARCHAR(255) NOT NULL,
  addedDate date NOT NULL,
  storeNumber INT NOT NULL,
  FOREIGN KEY (storeNumber) REFERENCES store(storeNumber) ON DELETE CASCADE ON UPDATE CASCADE
);';
$pdo->exec($sql);

// 画像データを挿入
$sql = "INSERT INTO images (imageHash, imageName, addedDate, storeNumber) VALUES
  ('abc123hash', 'スマホ.png', '2024-01-09', 1),
  ('def456hash', 'ノートパソコン.jpg', '2024-02-14', 1),
  ('ghi789hash', '本.jpg', '2024-02-28', 2);";
$pdo->exec($sql);

// 商品テーブル作成
$sql = 'CREATE TABLE product (
  productNumber INT AUTO_INCREMENT PRIMARY KEY NOT NULL,
  productName VARCHAR(50) NOT NULL,
  price DECIMAL(10, 2) NOT NULL,
  categoryNumber INT NOT NULL,
  storeCategoryNumber INT,
  stockQuantity INT NOT NULL,
  productDescription VARCHAR(500) NOT NULL,
  dateAdded DATE NOT NULL,
  releaseDate DATE NOT NULL,
  storeNumber INT NOT NULL,
  pageDisplayStatus BOOLEAN NOT NULL,
  imageNumber INT,
  FOREIGN KEY (categoryNumber) REFERENCES category(categoryNumber) ON DELETE CASCADE ON UPDATE CASCADE,
  FOREIGN KEY (storeCategoryNumber) REFERENCES storeCategory(storeCategoryNumber) ON DELETE CASCADE ON UPDATE CASCADE,
  FOREIGN KEY (storeNumber) REFERENCES store(storeNumber) ON DELETE CASCADE ON UPDATE CASCADE,
  FOREIGN KEY (imageNumber) REFERENCES images(imageNumber) ON DELETE CASCADE ON UPDATE CASCADE

);';
$pdo->exec($sql);

// 商品データ挿入
$sql = "INSERT INTO product (productName, price, categoryNumber, stockQuantity, productDescription, dateAdded, releaseDate, storeNumber, pageDisplayStatus, imageNumber) VALUES
  ('iPhone 13', 799.99, 3, 100, '最新のAppleスマートフォン', '2024-01-10', '2024-01-20', 1, 1,1),
  ('MacBook Air', 999.99, 4, 50, 'Appleの薄型ノートPC', '2024-02-15', '2024-02-25', 1, 0,2),
  ('Harry Potterq', 15.99, 2, 200, '人気のファンタジー小説', '2024-03-01', '2024-03-10', 2, 0,3);";
$pdo->exec($sql);


// 注文テーブル作成
$sql = 'CREATE TABLE orderTable (
  orderNumber INT AUTO_INCREMENT PRIMARY KEY NOT NULL,
  customerNumber INT NOT NULL,
  orderDateTime DATETIME NOT NULL,
  orderStatus VARCHAR(50) NOT NULL,
  deliveryAddress VARCHAR(100) NOT NULL,
  paymentMethodStatus VARCHAR(50) NOT NULL,
  billingName VARCHAR(50) NOT NULL,
  billingAddress VARCHAR(100) NOT NULL,
  purchaserName VARCHAR(50),
  purchaserFurigana VARCHAR(50),
  FOREIGN KEY (customerNumber) REFERENCES customer(customerNumber) ON DELETE CASCADE ON UPDATE CASCADE
);';
$pdo->exec($sql);

// 注文データ挿入
$sql = "INSERT INTO orderTable (customerNumber, orderDateTime, orderStatus, deliveryAddress, paymentMethodStatus, billingName, billingAddress) VALUES
  (1, '2024-07-28 10:00:00', 'Processing', '東京都千代田区', 'Paid', '山田 太郎', '東京都千代田区'),
  (2, '2024-07-29 15:30:00', 'Shipped', '大阪府大阪市', 'Pending', '佐藤 花子', '大阪府大阪市');";
$pdo->exec($sql);

// 注文詳細テーブル作成
$sql = 'CREATE TABLE orderDetail (
  orderDetailNumber INT AUTO_INCREMENT PRIMARY KEY NOT NULL,
  orderNumber INT NOT NULL,
  productNumber INT NOT NULL,
  quantity INT NOT NULL,
  price DECIMAL(10, 2) NOT NULL,
  FOREIGN KEY (orderNumber) REFERENCES orderTable(orderNumber) ON DELETE CASCADE ON UPDATE CASCADE,
  FOREIGN KEY (productNumber) REFERENCES product(productNumber) ON DELETE CASCADE ON UPDATE CASCADE
);';
$pdo->exec($sql);

// 注文詳細データ挿入
$sql = "INSERT INTO orderDetail (orderNumber, productNumber, quantity, price) VALUES
  (1, 1, 2, 799.99),
  (1, 2, 1, 999.99),
  (2, 3, 3, 15.99);";
$pdo->exec($sql);

// カートテーブル作成
$sql = 'CREATE TABLE cart (
  customerNumber INT NOT NULL,
  productNumber INT NOT NULL,
  quantity INT NOT NULL,
  dateAdded DATETIME NOT NULL,
  PRIMARY KEY (customerNumber, productNumber),
  FOREIGN KEY (customerNumber) REFERENCES customer(customerNumber) ON DELETE CASCADE ON UPDATE CASCADE,
  FOREIGN KEY (productNumber) REFERENCES product(productNumber) ON DELETE CASCADE ON UPDATE CASCADE
);';
$pdo->exec($sql);

// カートデータ挿入
$sql = "INSERT INTO cart (customerNumber, productNumber, quantity, dateAdded) VALUES
  (1, 1, 1, '2024-07-29 09:00:00'),
  (1, 3, 2, '2024-07-29 09:05:00'),
  (2, 2, 1, '2024-07-29 09:10:00');";
$pdo->exec($sql);

// お問い合わせ対応日時設定番号テーブル作成
$sql = 'CREATE TABLE dateAndTimeSettings (
  dateAndTimeSettingsNumber INT AUTO_INCREMENT PRIMARY KEY NOT NULL,
  storeNumber INT NOT NULL,
  businessStartDate DATE NOT NULL,
  businessEndDate DATE NOT NULL,
  supportStartTime TIME NOT NULL,
  supportEndTime TIME NOT NULL,
  FOREIGN KEY (storeNumber) REFERENCES store(storeNumber) ON DELETE CASCADE ON UPDATE CASCADE
);';
$pdo->exec($sql);

// お問い合わせ対応日時設定番号データ挿入
$sql = "INSERT INTO dateAndTimeSettings (storeNumber, businessStartDate, businessEndDate, supportStartTime, supportEndTime) VALUES
  (1, '2024-01-01', '2024-12-31', '09:00:00', '18:00:00'),
  (2, '2024-01-01', '2024-12-31', '10:00:00', '19:00:00');";
$pdo->exec($sql);

// レビューテーブル作成
$sql = 'CREATE TABLE review (
  reviewNumber INT AUTO_INCREMENT PRIMARY KEY NOT NULL,
  customerNumber INT NOT NULL,
  productNumber INT NOT NULL,
  reviewText VARCHAR(300),
  purchaseFlag BOOLEAN NOT NULL,
  evaluation VARCHAR(10),
  FOREIGN KEY (customerNumber) REFERENCES customer(customerNumber) ON DELETE CASCADE ON UPDATE CASCADE,
  FOREIGN KEY (productNumber) REFERENCES product(productNumber) ON DELETE CASCADE ON UPDATE CASCADE
);';
$pdo->exec($sql);

// レビューデータ挿入
$sql = "INSERT INTO review (customerNumber, productNumber, reviewText, purchaseFlag, evaluation) VALUES
  (1, 1, '素晴らしい製品です！', 1, '5'),
  (2, 2, 'とても満足しています。', 1, '4'),
  (1, 3, '少し期待外れでした。', 1, '3');";
$pdo->exec($sql);

/*
 * SQL文実行
 */
function sql_exec($pdo, $sql) {
    $count = $pdo->exec($sql);

    return $count;
}
?>
<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <title>ショッピングサイト</title>
</head>
<body>

<form name="myForm1" action="../taoka/index.php" method="post">
  <h2>実習No.3 データベース初期化（デバッグ用）</h2>
  データベースを初期化しました。<p />
  <input type="submit" value="戻る" />
</form>
</body>
</html>