document.addEventListener('DOMContentLoaded', () => {
    const postalCodeInput = document.getElementById('postalCode');
    postalCodeInput.addEventListener('blur', () => {
        const postalCode = postalCodeInput.value.replace('-', '');
        if (postalCode.length === 7) {
            fetch(`https://api.zipaddress.net/?zipcode=${postalCode}`)
                .then(response => response.json())
                .then(data => {
                    console.log('API Response:', data);
                    if (data.code === 200) {
                        const address = data.data;
                        const fullAddress = `${address.pref}${address.city}${address.town}`;
                        document.getElementById('fullAddress').value = fullAddress || '';
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
