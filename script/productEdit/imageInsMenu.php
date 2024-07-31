<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <title>画像アップロード</title>
</head>
<body>
    <h1>画像をアップロードする</h1>
    <form action="imageInsMain.php" method="post" enctype="multipart/form-data">
        <label for="image">画像ファイル:</label>
        <input type="file" name="image" id="image" required>
        <input type="submit" name="submit" value="アップロード">
    </form>
    <table border="1">
    <tr>
        <th scope="col">No.</th>
        <th scope="col">ファイル名</th>
        <th scope="col">画像</th>
        <th scope="col">追加日時</th>
    </tr>
    <?php
        for ($i = 0; $i < count($skillList); $i++) {
            $skillBeans = new SkillBeans();
            $skillBeans = $skillList[$i];
    ?>
            <tr>
                <td><?php echo $i + 1;?></td>
                <td><?php echo $skillBeans->getSyainBangou(); ?></td>
                <td><?php echo $skillBeans->getSyainMei(); ?></td>
                <td><?php echo $skillBeans->getSikakuRyakusyou(); ?></td>
                <td><?php echo $skillBeans->getSikakuSyutokubi(); ?></td>
            </tr>
    <?php
        }
    ?>
    
</table>
</body>
</html>
