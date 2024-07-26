document.addEventListener('DOMContentLoaded', () => {
    const postalCodeInput = document.getElementById('postal_code');
    postalCodeInput.addEventListener('blur', () => {
        const postalCode = postalCodeInput.value.replace('-', '');
        if (postalCode.length === 7) {
            fetch(`https://api.zipaddress.net/?zipcode=${postalCode}`)
                .then(response => response.json())
                .then(data => {
                    console.log('API Response:', data); // レスポンスを確認
                    if (data.code === 200) {
                        const address = data.data;
                        document.getElementById('prefecture').value = address.pref || ''; // 修正: 'pref'に対応
                        document.getElementById('city').value = address.city || '';
                        document.getElementById('town').value = address.town || '';
                    } else {
                        alert('住所情報が見つかりませんでした。');
                    }
                })
                .catch(error => {
                    console.error('エラー:', error);
                    alert('住所の取得に失敗しました。');
                });
        }
    });
});
