<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>社情報登録 - ストアクリエイターPro</title>
    <link rel="stylesheet" href="newLog.css">
</head>
<body>
    <div class="container">
        <h2>社情報登録</h2>
        <form action="com.php" method="post">
            <div class="form-group">
                <label for="business_type">事業形態<span class="required">必須</span></label>
                <select id="business_type" name="business_type" required>
                    <option value="">選択してください</option>
                    <option value="corporation">法人</option>
                    <option value="sole_proprietor">個人事業主</option>
                </select>
            </div>
            <div class="form-group" id="company_type_container">
                <label for="company_type">企業形態<span class="required">必須</span></label>
                <select id="company_type" name="company_type" required>
                <option value="" selected="selected">選択してください</option>
                  <option value="株式会社">株式会社</option>
                  <option value="有限会社">有限会社</option>
                  <option value="合資会社">合資会社</option>
                  <option value="財団法人">財団法人</option>
                  <option value="社団法人">社団法人</option>
                  <option value="宗教法人">宗教法人</option>
                  <option value="学校法人">学校法人</option>
                  <option value="合名会社">合名会社</option>
                  <option value="特定非営利活動法人">特定非営利活動法人</option>
                  <option value="合同会社">合同会社</option>
                  <option value="協同組合">協同組合</option>
                  <option value="その他法人">その他法人</option>
                </select>
            </div>
            <div class="form-group" id="corporate_number_container">
                <label for="corporate_number">法人番号<span class="optional">条件付必須</span></label>
                <input type="text" id="corporate_number" name="corporate_number" placeholder="例）1234567890123">
                <small>13桁の法人番号を入力してください。</small>
            </div>
            <div class="form-group">
                <label for="company_name">会社名<span class="required">必須</span></label>
                <input type="text" id="company_name" name="company_name" placeholder="例）矢風商事" required>
            </div>
            <div class="form-group">
                <label for="postal_code">郵便番号<span class="required">必須</span></label>
                <input type="text" id="postal_code" name="postal_code" placeholder="例）102-8282" required>
            </div>
            <div class="form-group">
                <label for="prefecture">都道府県<span class="required">必須</span></label>
                <input type="text" id="prefecture" name="prefecture" placeholder="例）東京都">
            </div>
            <div class="form-group">
                <label for="city">市区町村<span class="required">必須</span></label>
                <input type="text" id="city" name="city" placeholder="例）千代田区" required>
            </div>
            <div class="form-group">
                <label for="town">町・字名<span class="required">必須</span></label>
                <input type="text" id="town" name="town" placeholder="例）紀尾井町" required>
            </div>
            <div class="form-group">
                <label for="street_address">丁目・番地・号<span class="required">必須</span></label>
                <input type="text" id="street_address" name="street_address" placeholder="例）1-3" required>
            </div>
            <div class="form-group">
                <label for="building_name">ビル名<span class="optional">任意</span></label>
                <input type="text" id="building_name" name="building_name" placeholder="例）紀尾井町タワー">
            </div>
            <div class="form-group">
                <label for="phone_number">電話番号<span class="required">必須</span></label>
                <input type="text" id="phone_number" name="phone_number" placeholder="例）03-1234-5678" required>
            </div>
            <div class="form-group">
                <label for="establishment_date">設立年月<span class="required">必須</span></label>
                <div class="date-container">
                    <div class="date-item">
                        <label for="establishment_year">年</label>
                        <select id="establishment_year" name="establishment_year" required>
                            <option value="" selected="selected">年を選択してください</option>
                            <?php
                            $currentYear = date("Y");
                            for ($year = $currentYear; $year >= 1900; $year--) {
                                echo "<option value=\"$year\">$year</option>";
                            }
                            ?>
                        </select>
                    </div>
                    <div class="date-item">
                        <label for="establishment_month">月</label>
                        <select id="establishment_month" name="establishment_month" required>
                            <option value="" selected="selected">月を選択してください</option>
                            <?php
                            for ($month = 1; $month <= 12; $month++) {
                                $monthFormatted = str_pad($month, 2, '0', STR_PAD_LEFT);
                                echo "<option value=\"$monthFormatted\">$monthFormatted</option>";
                            }
                            ?>
                        </select>
                    </div>
                </div>
            </div>
            <div class="form-group">
                <label for="capital">資本金<span class="required">必須</span></label>
                <input type="number" id="capital" name="capital" placeholder="例）1000" required> 万円
            </div>
            <div class="form-group">
                <label for="revenue">売上高（前期）<span class="optional">任意</span></label>
                <input type="number" id="revenue" name="revenue" placeholder="例）10"> 百万円
            </div>
            <button type="submit">登録する</button>
        </form>
    </div>
    <script>
        document.addEventListener('DOMContentLoaded', () => {
            const businessTypeSelect = document.getElementById('business_type');
            const companyTypeContainer = document.getElementById('company_type_container');
            const corporateNumberContainer = document.getElementById('corporate_number_container');

            function toggleBusinessFields() {
                const selectedBusinessType = businessTypeSelect.value;
                if (selectedBusinessType === 'sole_proprietor') {
                    companyTypeContainer.style.display = 'none';
                    corporateNumberContainer.style.display = 'none';
                } else {
                    companyTypeContainer.style.display = 'block';
                    corporateNumberContainer.style.display = 'block';
                }
            }

            businessTypeSelect.addEventListener('change', toggleBusinessFields);

            // 初期表示設定
            toggleBusinessFields();
        });
    </script>
    <script src="addressAutoFill.js"></script>
</body>
</html>

