<?php

namespace AppStoreServerLibrary\AppStoreServerAPIClient;

enum APIError: int
{
    /**
     * An error that indicates an invalid request.
     *
     * https://developer.apple.com/documentation/appstoreserverapi/generalbadrequesterror
     */
    case GENERAL_BAD_REQUEST = 4000000;

    /**
     * An error that indicates an invalid app identifier.
     *
     * https://developer.apple.com/documentation/appstoreserverapi/invalidappidentifiererror
     */
    case INVALID_APP_IDENTIFIER = 4000002;

    /**
     * An error that indicates an invalid request revision.
     *
     * https://developer.apple.com/documentation/appstoreserverapi/invalidrequestrevisionerror
     */
    case INVALID_REQUEST_REVISION = 4000005;

    /**
     * An error that indicates an invalid transaction identifier.
     *
     * https://developer.apple.com/documentation/appstoreserverapi/invalidtransactioniderror
     */
    case INVALID_TRANSACTION_ID = 4000006;

    /**
     * An error that indicates an invalid original transaction identifier.
     *
     * https://developer.apple.com/documentation/appstoreserverapi/invalidoriginaltransactioniderror
     */
    case INVALID_ORIGINAL_TRANSACTION_ID = 4000008;

    /**
     * An error that indicates an invalid extend-by-days value.
     *
     * https://developer.apple.com/documentation/appstoreserverapi/invalidextendbydayserror
     */
    case INVALID_EXTEND_BY_DAYS = 4000009;

    /**
     * An error that indicates an invalid reason code.
     *
     * https://developer.apple.com/documentation/appstoreserverapi/invalidextendreasoncodeerror
     */
    case INVALID_EXTEND_REASON_CODE = 4000010;

    /**
     * An error that indicates an invalid request identifier.
     *
     * https://developer.apple.com/documentation/appstoreserverapi/invalidrequestidentifiererror
     */
    case INVALID_REQUEST_IDENTIFIER = 4000011;

    /**
     * An error that indicates that the start date is earlier than the earliest allowed date.
     *
     * https://developer.apple.com/documentation/appstoreserverapi/startdatetoofarinpasterror
     */
    case START_DATE_TOO_FAR_IN_PAST = 4000012;

    /**
     * An error that indicates that the end date precedes the start date, or the two dates are equal.
     *
     * https://developer.apple.com/documentation/appstoreserverapi/startdateafterenddateerror
     */
    case START_DATE_AFTER_END_DATE = 4000013;

    /**
     * An error that indicates the pagination token is invalid.
     *
     * https://developer.apple.com/documentation/appstoreserverapi/invalidpaginationtokenerror
     */
    case INVALID_PAGINATION_TOKEN = 4000014;

    /**
     * An error that indicates the start date is invalid.
     *
     * https://developer.apple.com/documentation/appstoreserverapi/invalidstartdateerror
     */
    case INVALID_START_DATE = 4000015;

    /**
     * An error that indicates the end date is invalid.
     *
     * https://developer.apple.com/documentation/appstoreserverapi/invalidenddateerror
     */
    case INVALID_END_DATE = 4000016;

    /**
     * An error that indicates the pagination token expired.
     *
     * https://developer.apple.com/documentation/appstoreserverapi/paginationtokenexpirederror
     */
    case PAGINATION_TOKEN_EXPIRED = 4000017;

    /**
     * An error that indicates the notification type or subtype is invalid.
     *
     * https://developer.apple.com/documentation/appstoreserverapi/invalidnotificationtypeerror
     */
    case INVALID_NOTIFICATION_TYPE = 4000018;

    /**
     * An error that indicates the request is invalid because it has too many caseraints applied.
     *
     * https://developer.apple.com/documentation/appstoreserverapi/multiplefilterssuppliederror
     */
    case MULTIPLE_FILTERS_SUPPLIED = 4000019;

    /**
     * An error that indicates the test notification token is invalid.
     *
     * https://developer.apple.com/documentation/appstoreserverapi/invalidtestnotificationtokenerror
     */
    case INVALID_TEST_NOTIFICATION_TOKEN = 4000020;

    /**
     * An error that indicates an invalid sort parameter.
     *
     * https://developer.apple.com/documentation/appstoreserverapi/invalidsorterror
     */
    case INVALID_SORT = 4000021;

    /**
     * An error that indicates an invalid product type parameter.
     *
     * https://developer.apple.com/documentation/appstoreserverapi/invalidproducttypeerror
     */
    case INVALID_PRODUCT_TYPE = 4000022;

    /**
     * An error that indicates the product ID parameter is invalid.
     *
     * https://developer.apple.com/documentation/appstoreserverapi/invalidproductiderror
     */
    case INVALID_PRODUCT_ID = 4000023;

    /**
     * An error that indicates an invalid subscription group identifier.
     *
     * https://developer.apple.com/documentation/appstoreserverapi/invalidsubscriptiongroupidentifiererror
     */
    case INVALID_SUBSCRIPTION_GROUP_IDENTIFIER = 4000024;

    /**
     * An error that indicates the query parameter exclude-revoked is invalid.
     *
     * https://developer.apple.com/documentation/appstoreserverapi/invalidexcluderevokederror
     *
     * @deprecated 1.5
     */
    case INVALID_EXCLUDE_REVOKED = 4000025;

    /**
     * An error that indicates an invalid in-app ownership type parameter.
     *
     * https://developer.apple.com/documentation/appstoreserverapi/invalidinappownershiptypeerror
     */
    case INVALID_IN_APP_OWNERSHIP_TYPE = 4000026;

    /**
     * An error that indicates a required storefront country code is empty.
     *
     * https://developer.apple.com/documentation/appstoreserverapi/invalidemptystorefrontcountrycodelisterror
     */
    case INVALID_EMPTY_STOREFRONT_COUNTRY_CODE_LIST = 4000027;

    /**
     * An error that indicates a storefront code is invalid.
     *
     * https://developer.apple.com/documentation/appstoreserverapi/invalidstorefrontcountrycodeerror
     */
    case INVALID_STOREFRONT_COUNTRY_CODE = 4000028;

    /**
     * An error that indicates the revoked parameter contains an invalid value.
     *
     * https://developer.apple.com/documentation/appstoreserverapi/invalidrevokederror
     */
    case INVALID_REVOKED = 4000030;

    /**
     * An error that indicates the status parameter is invalid.
     *
     * https://developer.apple.com/documentation/appstoreserverapi/invalidstatuserror
     */
    case INVALID_STATUS = 4000031;

    /**
     * An error that indicates the value of the account tenure field is invalid.
     *
     * https://developer.apple.com/documentation/appstoreserverapi/invalidaccounttenureerror
     */
    case INVALID_ACCOUNT_TENURE = 4000032;

    /**
     * An error that indicates the value of the app account token field is invalid.
     *
     * https://developer.apple.com/documentation/appstoreserverapi/invalidappaccounttokenerror
     */
    case INVALID_APP_ACCOUNT_TOKEN = 4000033;

    /**
     * An error that indicates the value of the consumption status field is invalid.
     *
     * https://developer.apple.com/documentation/appstoreserverapi/invalidconsumptionstatuserror
     */
    case INVALID_CONSUMPTION_STATUS = 4000034;

    /**
     * An error that indicates the customer consented field is invalid or doesn't indicate that the customer consented.
     *
     * https://developer.apple.com/documentation/appstoreserverapi/invalidcustomerconsentederror
     */
    case INVALID_CUSTOMER_CONSENTED = 4000035;

    /**
     * An error that indicates the value in the delivery status field is invalid.
     *
     * https://developer.apple.com/documentation/appstoreserverapi/invaliddeliverystatuserror
     */
    case INVALID_DELIVERY_STATUS = 4000036;

    /**
     * An error that indicates the value in the lifetime dollars purchased field is invalid.
     *
     * https://developer.apple.com/documentation/appstoreserverapi/invalidlifetimedollarspurchasederror
     */
    case INVALID_LIFETIME_DOLLARS_PURCHASED = 4000037;

    /**
     * An error that indicates the value in the lifetime dollars refunded field is invalid.
     *
     * https://developer.apple.com/documentation/appstoreserverapi/invalidlifetimedollarsrefundederror
     */
    case INVALID_LIFETIME_DOLLARS_REFUNDED = 4000038;

    /**
     * An error that indicates the value in the platform field is invalid.
     *
     * https://developer.apple.com/documentation/appstoreserverapi/invalidplatformerror
     */
    case INVALID_PLATFORM = 4000039;

    /**
     * An error that indicates the value in the playtime field is invalid.
     *
     * https://developer.apple.com/documentation/appstoreserverapi/invalidplaytimeerror
     */
    case INVALID_PLAY_TIME = 4000040;

    /**
     * An error that indicates the value in the sample content provided field is invalid.
     *
     * https://developer.apple.com/documentation/appstoreserverapi/invalidsamplecontentprovidederror
     */
    case INVALID_SAMPLE_CONTENT_PROVIDED = 4000041;

    /**
     * An error that indicates the value in the user status field is invalid.
     *
     * https://developer.apple.com/documentation/appstoreserverapi/invaliduserstatuserror
     */
    case INVALID_USER_STATUS = 4000042;

    /**
     * An error that indicates the transaction identifier doesn't represent a consumable in-app purchase.
     *
     * https://developer.apple.com/documentation/appstoreserverapi/invalidtransactionnotconsumableerror
     *
     * @deprecated 1.11
     */
    case INVALID_TRANSACTION_NOT_CONSUMABLE = 4000043;

    /**
     * An error that indicates the transaction identifier represents an unsupported in-app purchase type.
     *
     * https://developer.apple.com/documentation/appstoreserverapi/invalidtransactiontypenotsupportederror
     */
    case INVALID_TRANSACTION_TYPE_NOT_SUPPORTED = 4000047;

    /**
     * An error that indicates the endpoint doesn't support an app transaction ID.
     *
     * https://developer.apple.com/documentation/appstoreserverapi/apptransactionidnotsupportederror
     */
    case APP_TRANSACTION_ID_NOT_SUPPORTED_ERROR = 4000048;

    /**
     * An error that indicates the image that's uploading is invalid.
     *
     * https://developer.apple.com/documentation/retentionmessaging/invalidimageerror
     */
    case INVALID_IMAGE = 4000161;

    /**
     * An error that indicates the header text is too long.
     *
     * https://developer.apple.com/documentation/retentionmessaging/headertoolongerror
     */
    case HEADER_TOO_LONG = 4000162;

    /**
     * An error that indicates the body text is too long.
     *
     * https://developer.apple.com/documentation/retentionmessaging/bodytoolongerror
     */
    case BODY_TOO_LONG = 4000163;

    /**
     * An error that indicates the locale is invalid.
     *
     * https://developer.apple.com/documentation/retentionmessaging/invalidlocaleerror
     */
    case INVALID_LOCALE = 4000164;

    /**
     * An error that indicates the alternative text for an image is too long.
     *
     * https://developer.apple.com/documentation/retentionmessaging/alttexttoolongerror
     */
    case ALT_TEXT_TOO_LONG = 4000175;

    /**
     * An error that indicates the app account token value is not a valid UUID.
     *
     * https://developer.apple.com/documentation/appstoreserverapi/invalidappaccounttokenuuiderror
     */
    case INVALID_APP_ACCOUNT_TOKEN_UUID_ERROR = 4000183;

    /**
     * An error that indicates the transaction is for a product the customer obtains through Family Sharing,
     * which the endpoint doesn’t support.
     *
     * https://developer.apple.com/documentation/appstoreserverapi/familytransactionnotsupportederror
     */
    case FAMILY_TRANSACTION_NOT_SUPPORTED_ERROR = 4000185;

    /**
     * An error that indicates the endpoint expects an original transaction identifier.
     *
     * https://developer.apple.com/documentation/appstoreserverapi/transactionidisnotoriginaltransactioniderror
     */
    case TRANSACTION_ID_IS_NOT_ORIGINAL_TRANSACTION_ID_ERROR = 4000187;

    /**
     * An error that indicates the subscription doesn't qualify for a renewal-date extension due to its subscription
     * state.
     *
     * https://developer.apple.com/documentation/appstoreserverapi/subscriptionextensionineligibleerror
     */
    case SUBSCRIPTION_EXTENSION_INELIGIBLE = 4030004;

    /**
     * An error that indicates the subscription doesn't qualify for a renewal-date extension because it has already
     * received the maximum extensions.
     *
     * https://developer.apple.com/documentation/appstoreserverapi/subscriptionmaxextensionerror
     */
    case SUBSCRIPTION_MAX_EXTENSION = 4030005;

    /**
     * An error that indicates a subscription isn't directly eligible for a renewal date extension because the user
     * obtained it through Family Sharing.
     *
     * https://developer.apple.com/documentation/appstoreserverapi/familysharedsubscriptionextensionineligibleerror
     */
    case FAMILY_SHARED_SUBSCRIPTION_EXTENSION_INELIGIBLE = 4030007;

    /**
     * An error that indicates when you reach the maximum number of uploaded images.
     *
     * https://developer.apple.com/documentation/retentionmessaging/maximumnumberofimagesreachederror
     */
    case MAXIMUM_NUMBER_OF_IMAGES_REACHED = 4030014;

    /**
     * An error that indicates when you reach the maximum number of uploaded messages.
     *
     * https://developer.apple.com/documentation/retentionmessaging/maximumnumberofmessagesreachederror
     */
    case MAXIMUM_NUMBER_OF_MESSAGES_REACHED = 4030016;

    /**
     * An error that indicates the message isn't in the approved state, so you can't configure it as a default message.
     *
     * https://developer.apple.com/documentation/retentionmessaging/messagenotapprovederror
     */
    case MESSAGE_NOT_APPROVED = 4030017;

    /**
     * An error that indicates the image isn't in the approved state, so you can't configure it as part of a default
     * message.
     *
     * https://developer.apple.com/documentation/retentionmessaging/imagenotapprovederror
     */
    case IMAGE_NOT_APPROVED = 4030018;

    /**
     * An error that indicates the image is currently in use as part of a message, so you can't delete it.
     *
     * https://developer.apple.com/documentation/retentionmessaging/imageinuseerror
     */
    case IMAGE_IN_USE = 4030019;

    /**
     * An error that indicates the App Store account wasn't found.
     *
     * https://developer.apple.com/documentation/appstoreserverapi/accountnotfounderror
     */
    case ACCOUNT_NOT_FOUND = 4040001;

    /**
     * An error response that indicates the App Store account wasn't found, but you can try again.
     *
     * https://developer.apple.com/documentation/appstoreserverapi/accountnotfoundretryableerror
     */
    case ACCOUNT_NOT_FOUND_RETRYABLE = 4040002;

    /**
     * An error that indicates the app wasn't found.
     *
     * https://developer.apple.com/documentation/appstoreserverapi/appnotfounderror
     */
    case APP_NOT_FOUND = 4040003;

    /**
     * An error response that indicates the app wasn't found, but you can try again.
     *
     * https://developer.apple.com/documentation/appstoreserverapi/appnotfoundretryableerror
     */
    case APP_NOT_FOUND_RETRYABLE = 4040004;

    /**
     * An error that indicates an original transaction identifier wasn't found.
     *
     * https://developer.apple.com/documentation/appstoreserverapi/originaltransactionidnotfounderror
     */
    case ORIGINAL_TRANSACTION_ID_NOT_FOUND = 4040005;

    /**
     * An error response that indicates the original transaction identifier wasn't found, but you can try again.
     *
     * https://developer.apple.com/documentation/appstoreserverapi/originaltransactionidnotfoundretryableerror
     */
    case ORIGINAL_TRANSACTION_ID_NOT_FOUND_RETRYABLE = 4040006;

    /**
     * An error that indicates that the App Store server couldn't find a notifications URL for your app in this
     * environment.
     *
     * https://developer.apple.com/documentation/appstoreserverapi/servernotificationurlnotfounderror
     */
    case SERVER_NOTIFICATION_URL_NOT_FOUND = 4040007;

    /**
     * An error that indicates that the test notification token is expired or the test notification status isn't
     * available.
     *
     * https://developer.apple.com/documentation/appstoreserverapi/testnotificationnotfounderror
     */
    case TEST_NOTIFICATION_NOT_FOUND = 4040008;

    /**
     * An error that indicates the server didn't find a subscription-renewal-date extension request for the request
     * identifier and product identifier you provided.
     *
     * https://developer.apple.com/documentation/appstoreserverapi/statusrequestnotfounderror
     */
    case STATUS_REQUEST_NOT_FOUND = 4040009;

    /**
     * An error that indicates a transaction identifier wasn't found.
     *
     * https://developer.apple.com/documentation/appstoreserverapi/transactionidnotfounderror
     */
    case TRANSACTION_ID_NOT_FOUND = 4040010;

    /**
     * An error that indicates the system can't find the image identifier.
     *
     * https://developer.apple.com/documentation/retentionmessaging/imagenotfounderror
     */
    case IMAGE_NOT_FOUND = 4040014;

    /**
     * An error that indicates the system can't find the message identifier.
     *
     * https://developer.apple.com/documentation/retentionmessaging/messagenotfounderror
     */
    case MESSAGE_NOT_FOUND = 4040015;

    /**
     * An error response that indicates an app transaction doesn’t exist for the specified customer.
     *
     * https://developer.apple.com/documentation/appstoreserverapi/apptransactiondoesnotexisterror
     */
    case APP_TRANSACTION_DOES_NOT_EXIST_ERROR = 4040019;

    /**
     * An error that indicates the image identifier already exists.
     *
     * https://developer.apple.com/documentation/retentionmessaging/imagealreadyexistserror
     */
    case IMAGE_ALREADY_EXISTS = 4090000;

    /**
     * An error that indicates the message identifier already exists.
     *
     * https://developer.apple.com/documentation/retentionmessaging/messagealreadyexistserror
     */
    case MESSAGE_ALREADY_EXISTS = 4090001;

    /**
     * An error that indicates that the request exceeded the rate limit.
     *
     * https://developer.apple.com/documentation/appstoreserverapi/ratelimitexceedederror
     */
    case RATE_LIMIT_EXCEEDED = 4290000;

    /**
     * An error that indicates a general internal error.
     *
     * https://developer.apple.com/documentation/appstoreserverapi/generalinternalerror
     */
    case GENERAL_INTERNAL = 5000000;

    /**
     * An error response that indicates an unknown error occurred, but you can try again.
     *
     * https://developer.apple.com/documentation/appstoreserverapi/generalinternalretryableerror
     */
    case GENERAL_INTERNAL_RETRYABLE = 5000001;
}
