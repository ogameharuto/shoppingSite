<?php

class StoreBeans{

    /* 変数 */
    private $storeNumber; // 店舗番号
    private $companyName; // 会社名
    private $companyPostalCode; // 会社郵便番号
    private $companyAddress; // 会社住所
    private $companyRepresentative; // 会社代表者
    private $storeName; // 店舗名
    private $furigana; // フリガナ
    private $telephoneNumber; // 電話番号
    private $mailAddress; // メールアドレス
    private $storeDescription; // 店舗紹介文
    private $storeImageURL; // 店舗画像URL
    private $storeAdditionalInfo; // 店舗情報補足
    private $operationsManager; // 運営責任者
    private $contactAddress; // お問い合わせ先住所
    private $contactPostalCode; // お問い合わせ先郵便番号
    private $contactPhoneNumber; // お問い合わせ先電話番号
    private $contactEmailAddress; // お問い合わせ先メールアドレス
    private $password; // パスワード

    /* コンストラクタ */
    public function __construct() {
        $this->storeNumber = '';
        $this->companyName = '';
        $this->companyPostalCode = '';
        $this->companyAddress = '';
        $this->companyRepresentative = '';
        $this->storeName = '';
        $this->furigana = '';
        $this->telephoneNumber = '';
        $this->mailAddress = '';
        $this->storeDescription = '';
        $this->storeImageURL = '';
        $this->storeAdditionalInfo = '';
        $this->operationsManager = '';
        $this->contactAddress = '';
        $this->contactPostalCode = '';
        $this->contactPhoneNumber = '';
        $this->contactEmailAddress = '';
        $this->password = '';
    }

    /* クリアメソッド */
    public function clear() {
        $this->storeNumber = '';
        $this->companyName = '';
        $this->companyPostalCode = '';
        $this->companyAddress = '';
        $this->companyRepresentative = '';
        $this->storeName = '';
        $this->furigana = '';
        $this->telephoneNumber = '';
        $this->mailAddress = '';
        $this->storeDescription = '';
        $this->storeImageURL = '';
        $this->storeAdditionalInfo = '';
        $this->operationsManager = '';
        $this->contactAddress = '';
        $this->contactPostalCode = '';
        $this->contactPhoneNumber = '';
        $this->contactEmailAddress = '';
        $this->password = '';
    }

    /* 店舗番号 */
    public function getStoreNumber() {
        return $this->storeNumber;
    }

    public function setStoreNumber($storeNumber) {
        $this->storeNumber = $storeNumber;
    }

    /* 会社名 */
    public function getCompanyName() {
        return $this->companyName;
    }

    public function setCompanyName($companyName) {
        $this->companyName = $companyName;
    }

    /* 会社郵便番号 */
    public function getCompanyPostalCode() {
        return $this->companyPostalCode;
    }

    public function setCompanyPostalCode($companyPostalCode) {
        $this->companyPostalCode = $companyPostalCode;
    }

    /* 会社住所 */
    public function getCompanyAddress() {
        return $this->companyAddress;
    }

    public function setCompanyAddress($companyAddress) {
        $this->companyAddress = $companyAddress;
    }

    /* 会社代表者 */
    public function getCompanyRepresentative() {
        return $this->companyRepresentative;
    }

    public function setCompanyRepresentative($companyRepresentative) {
        $this->companyRepresentative = $companyRepresentative;
    }

    /* 店舗名 */
    public function getStoreName() {
        return $this->storeName;
    }

    public function setStoreName($storeName) {
        $this->storeName = $storeName;
    }

    /* フリガナ */
    public function getFurigana() {
        return $this->furigana;
    }

    public function setFurigana($furigana) {
        $this->furigana = $furigana;
    }

    /* 電話番号 */
    public function getTelephoneNumber() {
        return $this->telephoneNumber;
    }

    public function setTelephoneNumber($telephoneNumber) {
        $this->telephoneNumber = $telephoneNumber;
    }

    /* メールアドレス */
    public function getMailAddress() {
        return $this->mailAddress;
    }

    public function setMailAddress($mailAddress) {
        $this->mailAddress = $mailAddress;
    }

    /* 店舗紹介文 */
    public function getStoreDescription() {
        return $this->storeDescription;
    }

    public function setStoreDescription($storeDescription) {
        $this->storeDescription = $storeDescription;
    }

    /* 店舗画像URL */
    public function getStoreImageURL() {
        return $this->storeImageURL;
    }

    public function setStoreImageURL($storeImageURL) {
        $this->storeImageURL = $storeImageURL;
    }

    /* 店舗情報補足 */
    public function getStoreAdditionalInfo() {
        return $this->storeAdditionalInfo;
    }

    public function setStoreAdditionalInfo($storeAdditionalInfo) {
        $this->storeAdditionalInfo = $storeAdditionalInfo;
    }

    /* 運営責任者 */
    public function getOperationsManager() {
        return $this->operationsManager;
    }

    public function setOperationsManager($operationsManager) {
        $this->operationsManager = $operationsManager;
    }

    /* お問い合わせ先住所 */
    public function getContactAddress() {
        return $this->contactAddress;
    }

    public function setContactAddress($contactAddress) {
        $this->contactAddress = $contactAddress;
    }

    /* お問い合わせ先郵便番号 */
    public function getContactPostalCode() {
        return $this->contactPostalCode;
    }

    public function setContactPostalCode($contactPostalCode) {
        $this->contactPostalCode = $contactPostalCode;
    }

    /* お問い合わせ先電話番号 */
    public function getContactPhoneNumber() {
        return $this->contactPhoneNumber;
    }

    public function setContactPhoneNumber($contactPhoneNumber) {
        $this->contactPhoneNumber = $contactPhoneNumber;
    }

    /* お問い合わせ先メールアドレス */
    public function getContactEmailAddress() {
        return $this->contactEmailAddress;
    }

    public function setContactEmailAddress($contactEmailAddress) {
        $this->contactEmailAddress = $contactEmailAddress;
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