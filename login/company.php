<?php
// データベース接続設定
$host = 'localhost'; // データベースサーバーのホスト名
$dbname = 'syain_db'; // データベース名
$username = 's20225002'; // データベースのユーザー名
$password = '20040106'; // データベースのパスワード

try {
    $pdo = new PDO("mysql:host=$host;dbname=$dbname;charset=utf8", $username, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    // POSTデータを受け取る
    $business_type = $_POST['business_type'];
    $company_type = $_POST['company_type'];
    $corporate_number = $_POST['corporate_number'];
    $company_name = $_POST['company_name'];
    $postal_code = $_POST['postal_code'];
    $prefecture = $_POST['prefecture'];
    $city = $_POST['city'];
    $town = $_POST['town'];
    $street_address = $_POST['street_address'];
    $building_name = $_POST['building_name'];
    $phone_number = $_POST['phone_number'];
    $establishment_year = $_POST['establishment_year'];
    $establishment_month = $_POST['establishment_month'];
    $capital = $_POST['capital'];
    $revenue = isset($_POST['revenue']) ? $_POST['revenue'] : null;

    // 設立年月を「YYYY-MM」の形式に変換
    $establishment_date = $establishment_year . '-' . $establishment_month;

    // SQLクエリの準備
    $sql = "INSERT INTO company_info (
                business_type, company_type, corporate_number, company_name,
                postal_code, prefecture, city, town, street_address, building_name,
                phone_number, establishment_date, capital, revenue
            ) VALUES (
                :business_type, :company_type, :corporate_number, :company_name,
                :postal_code, :prefecture, :city, :town, :street_address, :building_name,
                :phone_number, :establishment_date, :capital, :revenue
            )";

    // SQLクエリの実行
    $stmt = $pdo->prepare($sql);
    $stmt->execute([
        ':business_type' => $business_type,
        ':company_type' => $company_type,
        ':corporate_number' => $corporate_number,
        ':company_name' => $company_name,
        ':postal_code' => $postal_code,
        ':prefecture' => $prefecture,
        ':city' => $city,
        ':town' => $town,
        ':street_address' => $street_address,
        ':building_name' => $building_name,
        ':phone_number' => $phone_number,
        ':establishment_date' => $establishment_date,
        ':capital' => $capital,
        ':revenue' => $revenue
    ]);

    // 成功メッセージを表示
    echo "登録が完了しました。<br>";
    echo "<a href='index.php'>戻る</a>"; // 適切なリンク先に変更

} catch (PDOException $e) {
    echo "エラー: " . $e->getMessage();
}
//header('Location: newLog.php');
?>

