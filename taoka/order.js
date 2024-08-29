document.addEventListener('DOMContentLoaded', function () {
    const billingAddressSelect = document.getElementById('addressee');
    const billingAddressFields = document.getElementById('billingAddress');
    const paymentRadios = document.querySelectorAll('input[name="payment"]');
    const newCardFields = document.getElementById('newCardFields');
    const expiryDateInput = document.getElementById('expiryDate');
    const errorMessage = document.getElementById('error-message');

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
            // 現在選択中の支払い方法を取得
            const selectedValue = this.value;

            // すべての支払いフィールドを非表示にする
            const allPaymentFields = document.querySelectorAll('.payment-fields');
            allPaymentFields.forEach(field => {
                field.classList.add('hidden');
                Array.from(field.querySelectorAll('input')).forEach(input => input.required = false);
            });

            // 選択された支払い方法に応じてフィールドを表示
            if (selectedValue === '新規クレジットカード') {
                newCardFields.classList.remove('hidden');
                Array.from(newCardFields.querySelectorAll('input')).forEach(input => input.required = true);
            }
            else {
                newCardFields.classList.add('hidden');
                Array.from(newCardFields.querySelectorAll('input')).forEach(input => input.required = false);
            }
        });
    });

    // ページ読み込み時にデフォルトで選択中の支払い方法に応じたフィールドを表示
    const defaultRadio = document.querySelector('input[name="payment"]:checked');
    if (defaultRadio) {
        defaultRadio.dispatchEvent(new Event('change'));
    };
    // フォームの送信時にバリデーションを行う
    document.getElementById('orderForm').addEventListener('submit', function (event) {
        const inputs = this.querySelectorAll('input[required]');
        let isValid = true;

        inputs.forEach(input => {
            if (!input.checkValidity()) {
                isValid = false;
                const errorMessage = input.getAttribute('data-error-message');
                input.setCustomValidity(errorMessage);
            } else {
                input.setCustomValidity('');
            }
        });

        // 有効期限のチェック
        const expiryDateInput = document.getElementById('expiryDate');
        const errorMessage = document.getElementById('expiryDateError');
        const expiryDateValue = expiryDateInput.value;
        const [month, year] = expiryDateValue.split('/').map(num => parseInt(num, 10));

        if (!isValidMonth(month) || !isValidYear(year) || !isValidDate(month, year)) {
            expiryDateInput.setCustomValidity('存在する日付を入力してください。');
            errorMessage.style.display = 'inline';
            isValid = false;
        } else {
            expiryDateInput.setCustomValidity('');
            errorMessage.style.display = 'none';
        }

        if (!isValid) {
            event.preventDefault(); // バリデーションエラーがあればフォーム送信を防ぐ
        }
    });
    function isValidDate(month, year) {
        const currentDate = new Date();
        const currentYear = currentDate.getFullYear() % 100;
        const currentMonth = currentDate.getMonth() + 1;

        // 月と年が有効かどうかチェック
        if (month < 1 || month > 12 || year < 0 || year > 99) {
            return false;
        }

        // 現在または将来の日付かどうかチェック
        if (year < currentYear || (year === currentYear && month < currentMonth)) {
            return false; // 過去の日付は無効
        }

        return true; // 現在または将来の日付は有効
    }

    function isValidMonth(month) {
        return month >= 1 && month <= 12;
    }

    function isValidYear(year) {
        return year >= 0 && year <= 99;
    }
});