<?php
// フォームからのデータを受け取る
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
?>
<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>確認画面 - ストアクリエイターPro</title>
    <link rel="stylesheet" href="com.css">
</head>
<body>
    <div class="container">
        <h2>登録内容確認</h2>
        <form action="company.php" method="post">
            <div class="form-group">
                <label>事業形態:</label>
                <p><?php echo htmlspecialchars($business_type); ?></p>
                <input type="hidden" name="business_type" value="<?php echo htmlspecialchars($business_type); ?>">
            </div>

            <?php if ($business_type === 'corporation'): ?>
                <div class="form-group">
                    <label>企業形態:</label>
                    <p><?php echo htmlspecialchars($company_type); ?></p>
                    <input type="hidden" name="company_type" value="<?php echo htmlspecialchars($company_type); ?>">
                </div>
                <div class="form-group">
                    <label>法人番号:</label>
                    <p><?php echo htmlspecialchars($corporate_number); ?></p>
                    <input type="hidden" name="corporate_number" value="<?php echo htmlspecialchars($corporate_number); ?>">
                </div>
            <?php endif; ?>

            <div class="form-group">
                <label>会社名:</label>
                <p><?php echo htmlspecialchars($company_name); ?></p>
                <input type="hidden" name="company_name" value="<?php echo htmlspecialchars($company_name); ?>">
            </div>
            <div class="form-group">
                <label>郵便番号:</label>
                <p><?php echo htmlspecialchars($postal_code); ?></p>
                <input type="hidden" name="postal_code" value="<?php echo htmlspecialchars($postal_code); ?>">
            </div>
            <div class="form-group">
                <label>都道府県:</label>
                <p><?php echo htmlspecialchars($prefecture); ?></p>
                <input type="hidden" name="prefecture" value="<?php echo htmlspecialchars($prefecture); ?>">
            </div>
            <div class="form-group">
                <label>市区町村:</label>
                <p><?php echo htmlspecialchars($city); ?></p>
                <input type="hidden" name="city" value="<?php echo htmlspecialchars($city); ?>">
            </div>
            <div class="form-group">
                <label>町・字名:</label>
                <p><?php echo htmlspecialchars($town); ?></p>
                <input type="hidden" name="town" value="<?php echo htmlspecialchars($town); ?>">
            </div>
            <div class="form-group">
                <label>丁目・番地・号:</label>
                <p><?php echo htmlspecialchars($street_address); ?></p>
                <input type="hidden" name="street_address" value="<?php echo htmlspecialchars($street_address); ?>">
            </div>
            <div class="form-group">
                <label>ビル名:</label>
                <p><?php echo htmlspecialchars($building_name); ?></p>
                <input type="hidden" name="building_name" value="<?php echo htmlspecialchars($building_name); ?>">
            </div>
            <div class="form-group">
                <label>電話番号:</label>
                <p><?php echo htmlspecialchars($phone_number); ?></p>
                <input type="hidden" name="phone_number" value="<?php echo htmlspecialchars($phone_number); ?>">
            </div>
            <div class="form-group">
                <label>設立年月:</label>
                <p><?php echo htmlspecialchars($establishment_year); ?>年 <?php echo htmlspecialchars($establishment_month); ?>月</p>
                <input type="hidden" name="establishment_year" value="<?php echo htmlspecialchars($establishment_year); ?>">
                <input type="hidden" name="establishment_month" value="<?php echo htmlspecialchars($establishment_month); ?>">
            </div>
            <div class="form-group">
                <label>資本金:</label>
                <p><?php echo htmlspecialchars($capital); ?> 万円</p>
                <input type="hidden" name="capital" value="<?php echo htmlspecialchars($capital); ?>">
            </div>
            <div class="form-group">
                <label>売上高（前期）:</label>
                <p><?php echo htmlspecialchars($revenue); ?> 百万円</p>
                <input type="hidden" name="revenue" value="<?php echo htmlspecialchars($revenue); ?>">
            </div>
            <div class="form-actions">
                <button type="submit">登録する</button>
                <button type="button" onclick="history.back()">戻る</button>
            </div>
        </form>
    </div>
</body>
</html>


