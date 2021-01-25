<?php
namespace GCWorld\FormConfig\Core;

interface AutoCompleteConstants
{
    /**
     * A full list:
     * https://www.w3.org/TR/WCAG21/#input-purposes
     */
    const TYPE_FULL_NAME            = 'name';
    const TYPE_HONORIFIC_PREFIX     = 'honorific-prefix';
    const TYPE_FIRST_NAME           = 'given-name';
    const TYPE_MIDDLE_NAME          = 'additional-name';
    const TYPE_LAST_NAME            = 'family-name';
    const TYPE_HONORIFIC_SUFFIX     = 'honorific-suffix';
    const TYPE_NICKNAME             = 'nickname';
    const TYPE_ORGANIZATION         = 'organization';
    const TYPE_ORGANIZATION_TITLE   = 'organization-title';
    const TYPE_USERNAME             = 'username';
    const TYPE_NEW_PASSWORD         = 'new-password';
    const TYPE_CURRENT_PASSWORD     = 'current-password';
    const TYPE_ADDRESS_STREET       = 'street-address';
    const TYPE_ADDRESS_LINE_1       = 'address-line1';
    const TYPE_ADDRESS_LINE_2       = 'address-line2';
    const TYPE_ADDRESS_LINE_3       = 'address-line3';
    const TYPE_ADDRESS_LEVEL_4      = 'address-level4';
    const TYPE_ADDRESS_LEVEL_3      = 'address-level3';
    const TYPE_ADDRESS_CITY         = 'address-level2';
    const TYPE_ADDRESS_STATE        = 'address-level1';
    const TYPE_COUNTRY              = 'country';
    const TYPE_COUNTRY_NAME         = 'country-name';
    const TYPE_ZIP                  = 'postal-code';
    const TYPE_CC_FULL_NAME         = 'cc-name';
    const TYPE_CC_FIRST_NAME        = 'cc-given-name';
    const TYPE_CC_MIDDLE_NAME       = 'cc-additional-name';
    const TYPE_CC_LAST_NAME         = 'cc-family-name';
    const TYPE_CC_NUMBER            = 'cc-number';
    const TYPE_CC_EXP_DATE          = 'cc-exp';
    const TYPE_CC_EXP_MONTH         = 'cc-exp-month';
    const TYPE_CC_EXP_YEAR          = 'cc-exp-year';
    const TYPE_CC_SECURITY_CODE     = 'cc-csc';
    const TYPE_CC_TYPE              = 'cc-type';
    const TYPE_TRANSACTION_CURRENCY = 'transaction-currency';
    const TYPE_TRANSACTION_AMOUNT   = 'transaction-amount';
    const TYPE_LANGUAGE             = 'language';
    const TYPE_BIRTH_DATE           = 'bday';
    const TYPE_BIRTH_DAY            = 'bday-day';
    const TYPE_BIRTH_MONTH          = 'bday-month';
    const TYPE_BIRTH_YEAR           = 'bday-year';
    const TYPE_SEX                  = 'sex';
    const TYPE_URL                  = 'url';
    const TYPE_PHOTO                = 'photo';
    const TYPE_TEL                  = 'tel';
    const TYPE_TEL_COUNTRY_CODE     = 'tel-country-code';
    const TYPE_TEL_NATIONAL         = 'tel-national';
    const TYPE_TEL_AREA_CODE        = 'tel-area-code';
    const TYPE_TEL_LOCAL            = 'tel-local';
    const TYPE_TEL_LOCAL_PREFIX     = 'tel-local-prefix';
    const TYPE_TEL_LOCAL_SUFFIX     = 'tel-local-suffix';
    const TYPE_TEL_EXTENSION        = 'tel-extension';
    const TYPE_EMAIL                = 'email';
    const TYPE_IMPP                 = 'impp';
    const COMPONENTS                = [
        self::TYPE_FULL_NAME,
        self::TYPE_HONORIFIC_PREFIX,
        self::TYPE_FIRST_NAME,
        self::TYPE_MIDDLE_NAME,
        self::TYPE_LAST_NAME,
        self::TYPE_HONORIFIC_SUFFIX,
        self::TYPE_NICKNAME,
        self::TYPE_ORGANIZATION,
        self::TYPE_ORGANIZATION_TITLE,
        self::TYPE_USERNAME,
        self::TYPE_NEW_PASSWORD,
        self::TYPE_CURRENT_PASSWORD,
        self::TYPE_ADDRESS_STREET,
        self::TYPE_ADDRESS_LINE_1,
        self::TYPE_ADDRESS_LINE_2,
        self::TYPE_ADDRESS_LINE_3,
        self::TYPE_ADDRESS_LEVEL_4,
        self::TYPE_ADDRESS_LEVEL_3,
        self::TYPE_ADDRESS_CITY,
        self::TYPE_ADDRESS_STATE,
        self::TYPE_COUNTRY,
        self::TYPE_COUNTRY_NAME,
        self::TYPE_ZIP,
        self::TYPE_CC_FULL_NAME,
        self::TYPE_CC_FIRST_NAME,
        self::TYPE_CC_MIDDLE_NAME,
        self::TYPE_CC_LAST_NAME,
        self::TYPE_CC_NUMBER,
        self::TYPE_CC_EXP_DATE,
        self::TYPE_CC_EXP_MONTH,
        self::TYPE_CC_EXP_YEAR,
        self::TYPE_CC_SECURITY_CODE,
        self::TYPE_CC_TYPE,
        self::TYPE_TRANSACTION_CURRENCY,
        self::TYPE_TRANSACTION_AMOUNT,
        self::TYPE_LANGUAGE,
        self::TYPE_BIRTH_DATE,
        self::TYPE_BIRTH_DAY,
        self::TYPE_BIRTH_MONTH,
        self::TYPE_BIRTH_YEAR,
        self::TYPE_SEX,
        self::TYPE_URL,
        self::TYPE_PHOTO,
        self::TYPE_TEL,
        self::TYPE_TEL_COUNTRY_CODE,
        self::TYPE_TEL_NATIONAL,
        self::TYPE_TEL_AREA_CODE,
        self::TYPE_TEL_LOCAL,
        self::TYPE_TEL_LOCAL_PREFIX,
        self::TYPE_TEL_LOCAL_SUFFIX,
        self::TYPE_TEL_EXTENSION,
        self::TYPE_EMAIL,
        self::TYPE_IMPP,
    ];
}