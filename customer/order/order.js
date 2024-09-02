document.addEventListener('DOMContentLoaded', function () {
    const billingAddressSelect = document.getElementById('addressee');
    const billingAddressFields = document.getElementById('billingAddress');
    const paymentRadios = document.querySelectorAll('input[name="payment"]');
    const newCardFields = document.getElementById('newCardFields');
    const expiryYearSelect = document.getElementById('expiryYear'); // 修正: expiryYearSelect 変数を追加
    const expiryMonthSelect = document.getElementById('expiryMonth'); // 修正: expiryMonthSelect 変数を追加

    // 住所セクションの表示・非表示
    if (billingAddressSelect) {
        billingAddressSelect.addEventListener('change', function () {
            if (this.value === 'その他住所を入力') {
                billingAddressFields.classList.remove('hidden');
                Array.from(billingAddressFields.querySelectorAll('input, select')).forEach(input => {
                    if (input.id !== 'billing_building') {
                        input.required = true;
                    }
                });
            } else {
                billingAddressFields.classList.add('hidden');
                Array.from(billingAddressFields.querySelectorAll('input, select')).forEach(input => input.required = false);
            }
        });
    }

    // ラジオボタンにchangeイベントリスナーを追加
    paymentRadios.forEach(radio => {
        radio.addEventListener('change', function () {
            const selectedValue = this.value;

            // すべての支払いフィールドを非表示にする
            const allPaymentFields = document.querySelectorAll('.payment-fields');
            allPaymentFields.forEach(field => {
                field.classList.add('hidden');
                Array.from(field.querySelectorAll('input, select')).forEach(input => input.required = false);
            });

            // 選択された支払い方法に応じてフィールドを表示
            if (selectedValue === '新規クレジットカード') {
                newCardFields.classList.remove('hidden');
                Array.from(newCardFields.querySelectorAll('input, select')).forEach(input => input.required = true);
                // expiringYear と expiringMonth を必須に設定
                if (expiryYearSelect) expiryYearSelect.required = true;
                if (expiryMonthSelect) expiryMonthSelect.required = true;
            } else {
                newCardFields.classList.add('hidden');
                Array.from(newCardFields.querySelectorAll('input, select')).forEach(input => input.required = false);
                // expiringYear と expiringMonth を必須から解除
                if (expiryYearSelect) expiryYearSelect.required = false;
                if (expiryMonthSelect) expiryMonthSelect.required = false;
            }
        });
    });

    // ページ読み込み時にデフォルトで選択中の支払い方法に応じたフィールドを表示
    const defaultRadio = document.querySelector('input[name="payment"]:checked');
    if (defaultRadio) {
        defaultRadio.dispatchEvent(new Event('change'));
    }
});
