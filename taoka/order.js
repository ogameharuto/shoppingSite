document.addEventListener('DOMContentLoaded', function () {
    const billingAddressSelect = document.getElementById('addressee');
    const billingAddressFields = document.getElementById('billingAddress');
    const newCardRadio = document.getElementById('newCard');
    const newCardFields = document.getElementById('newCardFields');
    const expiryDateInput = document.getElementById('expiryDate');
    const errorMessage = document.getElementById('error-message');

    // 住所セクションの表示・非表示
    if (billingAddressSelect) {
        billingAddressSelect.addEventListener('change', function() {
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

    // 支払い方法の切り替え
    if (newCardRadio) {
        newCardRadio.addEventListener('change', function () {
            if (this.checked) {
                newCardFields.classList.remove('hidden');
                Array.from(newCardFields.querySelectorAll('input')).forEach(input => input.required = true);
            } else {
                newCardFields.classList.add('hidden');
                Array.from(newCardFields.querySelectorAll('input')).forEach(input => input.required = false);
            }
        });
    }

    // ページロード時に選択状態を確認
    if (newCardRadio && newCardRadio.checked) {
        newCardFields.classList.remove('hidden');
        Array.from(newCardFields.querySelectorAll('input')).forEach(input => input.required = true);
    } else {
        newCardFields.classList.add('hidden');
        Array.from(newCardFields.querySelectorAll('input')).forEach(input => input.required = false);
    }

    // 日付の存在確認
    function isValidDate(month, year) {
        const currentDate = new Date();
        const currentYear = currentDate.getFullYear() % 100;
        const currentMonth = currentDate.getMonth() + 1;

        if (year < currentYear || (year === currentYear && month < currentMonth)) {
            return false; // 過去の日付は無効
        }

        return true; // 現在または将来の日付は有効
    }

    // カスタムエラーメッセージの設定
    document.getElementById('orderForm').addEventListener('submit', function (event) {
        const inputs = this.querySelectorAll('input[pattern]');
        inputs.forEach(input => {
            if (input.validity.patternMismatch) {
                const errorMessage = input.getAttribute('data-error-message');
                input.setCustomValidity(errorMessage);
            } else {
                input.setCustomValidity('');
            }
        });

        // 有効期限の日付チェック
        const expiryDateValue = expiryDateInput.value;
        const [month, year] = expiryDateValue.split('/').map(num => parseInt(num, 10));

        if (!isValidMonth(month) || !isValidYear(year) || !isValidDate(month, year)) {
            expiryDateInput.setCustomValidity('存在する日付を入力してください。');
            errorMessage.style.display = 'inline';
            event.preventDefault();
        } else {
            expiryDateInput.setCustomValidity('');
            errorMessage.style.display = 'none';
        }
    });

    function isValidMonth(month) {
        return month >= 1 && month <= 12;
    }

    function isValidYear(year) {
        return year >= 0 && year <= 99;
    }
});