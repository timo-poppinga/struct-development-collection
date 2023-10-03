<?php

declare(strict_types=1);

namespace Struct\DataType\Enum;

enum Currency: string
{
    case AFN = 'Afghani';
    case EUR = 'Euro';
    case ALL = 'Lek';
    case DZD = 'Algerian Dinar';
    case USD = 'US Dollar';
    case AOA = 'Kwanza';
    case XCD = 'East Caribbean Dollar';
    case ARS = 'Argentine Peso';
    case AMD = 'Armenian Dram';
    case AWG = 'Aruban Florin';
    case AUD = 'Australian Dollar';
    case AZN = 'Azerbaijan Manat';
    case BSD = 'Bahamian Dollar';
    case BHD = 'Bahraini Dinar';
    case BDT = 'Taka';
    case BBD = 'Barbados Dollar';
    case BYN = 'Belarusian Ruble';
    case BZD = 'Belize Dollar';
    case XOF = 'CFA Franc BCEAO';
    case BMD = 'Bermudian Dollar';
    case INR = 'Indian Rupee';
    case BTN = 'Ngultrum';
    case BOB = 'Boliviano';
    case BOV = 'Mvdol';
    case BAM = 'Convertible Mark';
    case BWP = 'Pula';
    case NOK = 'Norwegian Krone';
    case BRL = 'Brazilian Real';
    case BND = 'Brunei Dollar';
    case BGN = 'Bulgarian Lev';
    case BIF = 'Burundi Franc';
    case CVE = 'Cabo Verde Escudo';
    case KHR = 'Riel';
    case XAF = 'CFA Franc BEAC';
    case CAD = 'Canadian Dollar';
    case KYD = 'Cayman Islands Dollar';
    case CLP = 'Chilean Peso';
    case CLF = 'Unidad de Fomento';
    case CNY = 'Yuan Renminbi';
    case COP = 'Colombian Peso';
    case COU = 'Unidad de Valor Real';
    case KMF = 'Comorian Franc ';
    case CDF = 'Congolese Franc';
    case NZD = 'New Zealand Dollar';
    case CRC = 'Costa Rican Colon';
    case CUP = 'Cuban Peso';
    case CUC = 'Peso Convertible';
    case ANG = 'Netherlands Antillean Guilder';
    case CZK = 'Czech Koruna';
    case DKK = 'Danish Krone';
    case DJF = 'Djibouti Franc';
    case DOP = 'Dominican Peso';
    case EGP = 'Egyptian Pound';
    case SVC = 'El Salvador Colon';
    case ERN = 'Nakfa';
    case SZL = 'Lilangeni';
    case ETB = 'Ethiopian Birr';
    case FKP = 'Falkland Islands Pound';
    case FJD = 'Fiji Dollar';
    case XPF = 'CFP Franc';
    case GMD = 'Dalasi';
    case GEL = 'Lari';
    case GHS = 'Ghana Cedi';
    case GIP = 'Gibraltar Pound';
    case GTQ = 'Quetzal';
    case GBP = 'Pound Sterling';
    case GNF = 'Guinean Franc';
    case GYD = 'Guyana Dollar';
    case HTG = 'Gourde';
    case HNL = 'Lempira';
    case HKD = 'Hong Kong Dollar';
    case HUF = 'Forint';
    case ISK = 'Iceland Krona';
    case IDR = 'Rupiah';
    case XDR = 'SDR (Special Drawing Right)';
    case IRR = 'Iranian Rial';
    case IQD = 'Iraqi Dinar';
    case ILS = 'New Israeli Sheqel';
    case JMD = 'Jamaican Dollar';
    case JPY = 'Yen';
    case JOD = 'Jordanian Dinar';
    case KZT = 'Tenge';
    case KES = 'Kenyan Shilling';
    case KPW = 'North Korean Won';
    case KRW = 'Won';
    case KWD = 'Kuwaiti Dinar';
    case KGS = 'Som';
    case LAK = 'Lao Kip';
    case LBP = 'Lebanese Pound';
    case LSL = 'Loti';
    case ZAR = 'Rand';
    case LRD = 'Liberian Dollar';
    case LYD = 'Libyan Dinar';
    case CHF = 'Swiss Franc';
    case MOP = 'Pataca';
    case MKD = 'Denar';
    case MGA = 'Malagasy Ariary';
    case MWK = 'Malawi Kwacha';
    case MYR = 'Malaysian Ringgit';
    case MVR = 'Rufiyaa';
    case MRU = 'Ouguiya';
    case MUR = 'Mauritius Rupee';
    case XUA = 'ADB Unit of Account';
    case MXN = 'Mexican Peso';
    case MXV = 'Mexican Unidad de Inversion (UDI)';
    case MDL = 'Moldovan Leu';
    case MNT = 'Tugrik';
    case MAD = 'Moroccan Dirham';
    case MZN = 'Mozambique Metical';
    case MMK = 'Kyat';
    case NAD = 'Namibia Dollar';
    case NPR = 'Nepalese Rupee';
    case NIO = 'Cordoba Oro';
    case NGN = 'Naira';
    case OMR = 'Rial Omani';
    case PKR = 'Pakistan Rupee';
    case PAB = 'Balboa';
    case PGK = 'Kina';
    case PYG = 'Guarani';
    case PEN = 'Sol';
    case PHP = 'Philippine Peso';
    case PLN = 'Zloty';
    case QAR = 'Qatari Rial';
    case RON = 'Romanian Leu';
    case RUB = 'Russian Ruble';
    case RWF = 'Rwanda Franc';
    case SHP = 'Saint Helena Pound';
    case WST = 'Tala';
    case STN = 'Dobra';
    case SAR = 'Saudi Riyal';
    case RSD = 'Serbian Dinar';
    case SCR = 'Seychelles Rupee';
    case SLL = 'Leone';
    case SLE = 'Leone';
    case SGD = 'Singapore Dollar';
    case XSU = 'Sucre';
    case SBD = 'Solomon Islands Dollar';
    case SOS = 'Somali Shilling';
    case SSP = 'South Sudanese Pound';
    case LKR = 'Sri Lanka Rupee';
    case SDG = 'Sudanese Pound';
    case SRD = 'Surinam Dollar';
    case SEK = 'Swedish Krona';
    case CHE = 'WIR Euro';
    case CHW = 'WIR Franc';
    case SYP = 'Syrian Pound';
    case TWD = 'New Taiwan Dollar';
    case TJS = 'Somoni';
    case TZS = 'Tanzanian Shilling';
    case THB = 'Baht';
    case TOP = 'Pa’anga';
    case TTD = 'Trinidad and Tobago Dollar';
    case TND = 'Tunisian Dinar';
    case TRY = 'Turkish Lira';
    case TMT = 'Turkmenistan New Manat';
    case UGX = 'Uganda Shilling';
    case UAH = 'Hryvnia';
    case AED = 'UAE Dirham';
    case USN = 'US Dollar (Next day)';
    case UYU = 'Peso Uruguayo';
    case UYI = 'Uruguay Peso en Unidades Indexadas (UI)';
    case UYW = 'Unidad Previsional';
    case UZS = 'Uzbekistan Sum';
    case VUV = 'Vatu';
    case VES = 'Bolívar Soberano';
    case VED = 'Bolívar Soberano';
    case VND = 'Dong';
    case YER = 'Yemeni Rial';
    case ZMW = 'Zambian Kwacha';
    case ZWL = 'Zimbabwe Dollar';
    case XBA = 'Bond Markets Unit European Composite Unit (EURCO)';
    case XBB = 'Bond Markets Unit European Monetary Unit (E.M.U.-6)';
    case XBC = 'Bond Markets Unit European Unit of Account 9 (E.U.A.-9)';
    case XBD = 'Bond Markets Unit European Unit of Account 17 (E.U.A.-17)';
    case XTS = 'Codes specifically reserved for testing purposes';
    case XXX = 'The codes assigned for transactions where no currency is involved';
    case XAU = 'Gold';
    case XPD = 'Palladium';
    case XPT = 'Platinum';
    case XAG = 'Silver';
}
