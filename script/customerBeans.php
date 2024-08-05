<?php

class CustomerBeans{

    /* 変数 */
    private $storeNumber; // 顧客番号
    private $customerName; // 名前
    private $furigana; // フリガナ
    private $address; // 住所
    private $postCode; // 郵便番号
    private $dateOfBirth; // 生年月日
    private $mailAddress; // メールアドレス
    private $telephoneNumber; // 電話番号
    private $password; // パスワード

    /* コンストラクタ */
    public function __construct() {
        $this->storeNumber = '';
        $this->customerName = '';
        $this->furigana = '';
        $this->address = '';
        $this->postCode = '';
        $this->dateOfBirth = '';
        $this->mailAddress = '';
        $this->telephoneNumber = '';
        $this->password = '';
    }
    /* クリアメソッド */
    public function clear() {
        $this->storeNumber = '';
        $this->customerName = '';
        $this->furigana = '';
        $this->address = '';
        $this->postCode = '';
        $this->dateOfBirth = '';
        $this->mailAddress = '';
        $this->telephoneNumber = '';
        $this->password = '';
    }

    /* 店舗番号 */
    public function getStoreNumber() {
        return $this->storeNumber;
    }

    public function setStoreNumber($storeNumber) {
        $this->storeNumber = $storeNumber;
    }

    /* 名前 */
    public function getcustomerName() {
        return $this->customerName;
    }

    public function setcustomerName($customerName) {
        $this->customerName = $customerName;
    }

    /* フリガナ */
    public function getFurigana(){
        return $this->furigana;
    }

    public function setFurigana($furigana){
        $this->furigana = $furigana;
    }

    /* 住所 */
    public function getAddress(){
        return $this->address;
    }

    public function setAddress($address){
        $this->address = $address;
    }

    /* 郵便番号 */
    public function getPostCode(){
        return $this->postCode;
    }

    public function setPostCode($postCode){
        $this->postCode = $postCode;
    }

    /* 生年月日 */
    public function getDateOfBirth(){
        return $this->dateOfBirth;
    }

    public function setDateOfBirth($dateOfBirth){
        $this->dateOfBirth = $dateOfBirth;
    }

    /* メールアドレス */
    public function getMailAddress(){
        return $this->mailAddress;
    }

    public function setMailAddress($mailAddress){
        $this->mailAddress = $mailAddress;
    }

    /* 電話番号 */
    public function getTelephoneNumber(){
        return $this->telephoneNumber;
    }

    public function setTelephoneNumber($telephoneNumber){
        $this->telephoneNumber = $telephoneNumber;
    }

    /* パスワード */
    public function getPassword() {
        return $this->password;
    }

    public function setPassword($password) {
        $this->password = $password;
    }
}
?>