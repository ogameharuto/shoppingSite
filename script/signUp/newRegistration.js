// UserSinkiTouroku.js

function validateForm() {
    // フォーム要素を取得
    const form = document.getElementById('registrationForm');
    const elements = form.elements;

    // 未入力のフィールドをチェック
    for (let element of elements) {
        if (element.type !== 'submit' && element.value.trim() === '') {
            alert('すべての必須項目を入力してください。');
            return false; // フォーム送信をキャンセル
        }
    }

    // フォーム送信を許可
    return true;
}

document.getElementById('registrationForm').addEventListener('submit', function(event) {
    event.preventDefault(); // フォームの送信を一時的に止める
    
    const email = document.getElementById('mailAddress').value;
    const phone = document.getElementById('telephoneNumber').value;
    
    // Ajaxリクエストを送信
    fetch('checkDuplicate.php', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json'
        },
        body: JSON.stringify({ mailAddress: email, telephoneNumber: phone })
    })
    .then(response => response.json())
    .then(data => {
        if (data.emailExists) {
            alert('このメールアドレスはすでに登録されています。別のメールアドレスを使用してください。');
        } else if (data.phoneExists) {
            alert('この電話番号はすでに登録されています。別の電話番号を使用してください。');
        } else {
            // メールアドレスと電話番号が重複していない場合はフォームを送信
            document.getElementById('registrationForm').submit();
        }
    })
    .catch(error => {
        console.error('エラーが発生しました:', error);
    });
});


