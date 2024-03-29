<?php
/**
 * This file contains translations.
 *
 * PHP Version 7
 *
 * @package   Endereco\OxidClient\Translations
 * @author    Ilja Weber <ilja.weber@mobilemojo.de>
 * @copyright 2019 mobilemojo – Apps & eCommerce UG (haftungsbeschränkt) & Co. KG
 *            (https://www.mobilemojo.de/)
 * @license   http://opensource.org/licenses/gpl-3.0 GNU General Public License,
 *            version 3 (GPLv3)
 * @link      https://www.endereco.de/
 */

$sLangName  = "Deutsch";
// -------------------------------
// RESOURCE IDENTITFIER = STRING
// -------------------------------
$aLang = [
    'charset' => 'UTF-8',
    'ENDERECO_OXID6_CLIENT_MAIN' => 'Endereco',
    'ENDERECO_OXID6_CLIENT_HOME' => 'Modul',
    'ENDERECO_OXID6_CLIENT_SETTINGS' => 'Einstellungen',
    'ENDERECOCLIENTOX_SETTINGS_STATUS' => 'Status:',
    'ENDERECOCLIENTOX_SETTINGS_STATUS_OK' => 'Ok',
    'ENDERECOCLIENTOX_SETTINGS_STATUS_OK_LONG' => ' - Die Verbindung zum Endereco-Server wurde erfolgreich hergestellt.',
    'ENDERECOCLIENTOX_SETTINGS_STATUS_OK_HELP' => 'Du wurdest erfolgreich mit dem Endereco-Server verbunden. Die gebuchten Dienste können genutzt werden.',
    'ENDERECOCLIENTOX_SETTINGS_STATUS_FAIL' => 'Verbindungsfehler',
    'ENDERECOCLIENTOX_SETTINGS_STATUS_FAIL_LONG' => ' - Die Verbindung zum Endereco-Server konnte nicht hergestellt werden. Prüfe deinen API-Key.',
    'ENDERECOCLIENTOX_SETTINGS_STATUS_FAIL_HELP' => 'Verbindung zum Endereco-Server fehlgeschlagen. Bitte überprüfe den API-Schlüssel. Kein API-Schlüssel? Kontaktiere uns unter info@endereco.de',

    'SHOP_MODULE_GROUP_ACCESS' => 'Zugangsdaten',
    'SHOP_MODULE_sAPIKEY' => 'API Schlüssel',
    'HELP_SHOP_MODULE_sAPIKEY' => 'Den API Key kannst du kostenfrei unter <a href="mailto:info@endereco.de">info@endereco.de</a> beantragen',
    'SHOP_MODULE_sSERVICEURL' => 'Service URL',
    'HELP_SHOP_MODULE_sSERVICEURL' => 'Hier sollte nur die Live URL in den ausgelieferten Modulen hinterlegt werden',

    'SHOP_MODULE_GROUP_AMS' => 'Adress-Services Konfiguration',
    'SHOP_MODULE_sUSEAMS' => 'Adressprüfung und Eingabe-Assistent aktivieren',
    'SHOP_MODULE_sCHECKALL' => 'Bestandskunden einmalig prüfen',
    'SHOP_MODULE_sCHECKPAYPAL' => 'PayPal Express Checkout Kunden prüfen (BETA)',
    'HELP_SHOP_MODULE_sCHECKALL' => 'Bestandskunden, die noch nicht geprüft wurden, werden beim Betretten der Prüfen und Bestellen Seite automatisch geprüft.',
    'SHOP_MODULE_sAMSBLURTRIGGER' => 'Adressprüfung sofort nach verlassen des Hausnummern Feldes auslösen',
    'SHOP_MODULE_sAMSSubmitTrigger' => 'Adressprüfung beim Absenden des Formulars auslösen',
    'SHOP_MODULE_sAMSResumeSubmit' => 'Das Absenden des Formulars nach der Adressauswahl fortsetzen',
    'HELP_SHOP_MODULE_sAMSBLURTRIGGER' => 'Ist die Funktion aktiv, wird die Adressprüfung sofort nach Eingabe der Adresse angestoßen. Ist die deaktiviert, erfolg die Prüfung beim Klick auf den "Weiter" Button.',
    'SHOP_MODULE_sSMARTFILL' => 'Felder bei nur einem verbleibenden Adressvorschlag automatisch ausfüllen (SmartAutocomplete) <i>beta</i>',
    'SHOP_MODULE_bChangeFieldsOrder' => 'Felderreihenfolge optimieren',

    'SHOP_MODULE_bAllowCloseModal' => 'Das Schließen des Modals erlauben',
    'SHOP_MODULE_bConfirmWithCheckbox' => 'Kunde muss eine fehlerhafte Adresse mit einer Checkbox bestätigen',

    'SHOP_MODULE_GROUP_EmailServices' => 'E-Mail Service',
    'SHOP_MODULE_bShowEmailserviceErrors' => 'E-Mail Statusmeldungen anzeigen',
    'SHOP_MODULE_bUseEmailservice'=> 'E-Mail Adressprüfung aktivieren',
    'SHOP_MODULE_GROUP_PersonalService'=> 'Anredeprüfung',
    'SHOP_MODULE_bUsePersonalService'=> 'Anredeprüfung basierend auf dem Vornamen aktivieren und Anrede automatisch setzen',
    'SHOP_MODULE_GROUP_VISUAL'=> 'Designanpassungen',
    'SHOP_MODULE_bUseCss'=> 'Standard-CSS nutzen',
    'SHOP_MODULE_sMainColor'=> 'Hauptfarbe im Dropdown',
    'SHOP_MODULE_sErrorColor'=> 'Fehlerfarbe im Modal',
    'SHOP_MODULE_sSelectionColor'=> 'Auswahlfarbe im Modal',
    'SHOP_MODULE_GROUP_ADVANCED'=> 'Entwicklereinstellungen',
    'SHOP_MODULE_bAllowControllerFilter' => 'Whitelist der Controller-Klassen aktivieren',
    'SHOP_MODULE_sAllowedControllerClasses'=> 'Whitelist der Controller-Klassen, bei denen das Modul aktiviert wird',
    'SHOP_MODULE_bShowDebug'=> 'Debuginformationen in der Browserkonsole ausgeben',

    'SHOP_MODULE_bPreselectCountry' => 'Standardland vorausw&auml;hlen',
    'SHOP_MODULE_sPreselectableCountries' => 'Standardland',
    'SHOP_MODULE_sPreselectableCountries_af' => 'Afghanistan',
    'SHOP_MODULE_sPreselectableCountries_ax' => 'Åland-Inseln',
    'SHOP_MODULE_sPreselectableCountries_al' => 'Albanien',
    'SHOP_MODULE_sPreselectableCountries_dz' => 'Algerien',
    'SHOP_MODULE_sPreselectableCountries_as' => 'Amerikanisch-Samoa',
    'SHOP_MODULE_sPreselectableCountries_ad' => 'Andorra',
    'SHOP_MODULE_sPreselectableCountries_ao' => 'Angola',
    'SHOP_MODULE_sPreselectableCountries_ai' => 'Anguilla',
    'SHOP_MODULE_sPreselectableCountries_aq' => 'Antarktis',
    'SHOP_MODULE_sPreselectableCountries_ag' => 'Antigua und Barbuda',
    'SHOP_MODULE_sPreselectableCountries_ar' => 'Argentinien',
    'SHOP_MODULE_sPreselectableCountries_am' => 'Armenien',
    'SHOP_MODULE_sPreselectableCountries_aw' => 'Aruba',
    'SHOP_MODULE_sPreselectableCountries_au' => 'Australien',
    'SHOP_MODULE_sPreselectableCountries_at' => 'Österreich',
    'SHOP_MODULE_sPreselectableCountries_az' => 'Aserbaidschan',
    'SHOP_MODULE_sPreselectableCountries_bs' => 'Bahamas',
    'SHOP_MODULE_sPreselectableCountries_bh' => 'Bahrain',
    'SHOP_MODULE_sPreselectableCountries_bd' => 'Bangladesch',
    'SHOP_MODULE_sPreselectableCountries_bb' => 'Barbados',
    'SHOP_MODULE_sPreselectableCountries_by' => 'Weißrussland',
    'SHOP_MODULE_sPreselectableCountries_be' => 'Belgien',
    'SHOP_MODULE_sPreselectableCountries_bz' => 'Belize',
    'SHOP_MODULE_sPreselectableCountries_bj' => 'Benin',
    'SHOP_MODULE_sPreselectableCountries_bm' => 'Bermuda',
    'SHOP_MODULE_sPreselectableCountries_bt' => 'Bhutan',
    'SHOP_MODULE_sPreselectableCountries_bo' => 'Bolivien (Plurinationaler Staat)',
    'SHOP_MODULE_sPreselectableCountries_bq' => 'Bonaire, Sint Eustatius und Saba',
    'SHOP_MODULE_sPreselectableCountries_ba' => 'Bosnien und Herzegowina',
    'SHOP_MODULE_sPreselectableCountries_bw' => 'Botswana',
    'SHOP_MODULE_sPreselectableCountries_bv' => 'Bouvet-Insel',
    'SHOP_MODULE_sPreselectableCountries_br' => 'Brasilien',
    'SHOP_MODULE_sPreselectableCountries_io' => 'Britisches Territorium im Indischen Ozean',
    'SHOP_MODULE_sPreselectableCountries_bn' => 'Brunei Darussalam',
    'SHOP_MODULE_sPreselectableCountries_bg' => 'Bulgarien',
    'SHOP_MODULE_sPreselectableCountries_bf' => 'Burkina Faso',
    'SHOP_MODULE_sPreselectableCountries_bi' => 'Burundi',
    'SHOP_MODULE_sPreselectableCountries_cv' => 'Cabo Verde',
    'SHOP_MODULE_sPreselectableCountries_kh' => 'Kambodscha',
    'SHOP_MODULE_sPreselectableCountries_cm' => 'Kamerun',
    'SHOP_MODULE_sPreselectableCountries_ca' => 'Kanada',
    'SHOP_MODULE_sPreselectableCountries_ky' => 'Kaimaninseln',
    'SHOP_MODULE_sPreselectableCountries_cf' => 'Zentralafrikanische Republik',
    'SHOP_MODULE_sPreselectableCountries_td' => 'Tschad',
    'SHOP_MODULE_sPreselectableCountries_cl' => 'Chile',
    'SHOP_MODULE_sPreselectableCountries_cn' => 'China',
    'SHOP_MODULE_sPreselectableCountries_cx' => 'Weihnachtsinsel',
    'SHOP_MODULE_sPreselectableCountries_cc' => 'Kokosinseln (Keeling)',
    'SHOP_MODULE_sPreselectableCountries_co' => 'Kolumbien',
    'SHOP_MODULE_sPreselectableCountries_km' => 'Komoren',
    'SHOP_MODULE_sPreselectableCountries_cg' => 'Kongo',
    'SHOP_MODULE_sPreselectableCountries_cd' => 'Kongo, Demokratische Republik Kongo',
    'SHOP_MODULE_sPreselectableCountries_ck' => 'Cook-Inseln',
    'SHOP_MODULE_sPreselectableCountries_cr' => 'Costa Rica',
    'SHOP_MODULE_sPreselectableCountries_ci' => 'Côte d\'Ivoire',
    'SHOP_MODULE_sPreselectableCountries_hr' => 'Kroatien',
    'SHOP_MODULE_sPreselectableCountries_cu' => 'Kuba',
    'SHOP_MODULE_sPreselectableCountries_cw' => 'Curaçao',
    'SHOP_MODULE_sPreselectableCountries_cy' => 'Zypern',
    'SHOP_MODULE_sPreselectableCountries_cz' => 'Tschechien',
    'SHOP_MODULE_sPreselectableCountries_dk' => 'Dänemark',
    'SHOP_MODULE_sPreselectableCountries_dj' => 'Dschibuti',
    'SHOP_MODULE_sPreselectableCountries_dm' => 'Dominica',
    'SHOP_MODULE_sPreselectableCountries_do' => 'Dominikanische Republik',
    'SHOP_MODULE_sPreselectableCountries_ec' => 'Ecuador',
    'SHOP_MODULE_sPreselectableCountries_eg' => 'Ägypten',
    'SHOP_MODULE_sPreselectableCountries_sv' => 'El Salvador',
    'SHOP_MODULE_sPreselectableCountries_gq' => 'Äquatorialguinea',
    'SHOP_MODULE_sPreselectableCountries_er' => 'Eritrea',
    'SHOP_MODULE_sPreselectableCountries_ee' => 'Estland',
    'SHOP_MODULE_sPreselectableCountries_sz' => 'Eswatini',
    'SHOP_MODULE_sPreselectableCountries_et' => 'Äthiopien',
    'SHOP_MODULE_sPreselectableCountries_fk' => 'Falkland-Inseln (Malwinen)',
    'SHOP_MODULE_sPreselectableCountries_fo' => 'Färöer-Inseln',
    'SHOP_MODULE_sPreselectableCountries_fj' => 'Fidschi',
    'SHOP_MODULE_sPreselectableCountries_fi' => 'Finnland',
    'SHOP_MODULE_sPreselectableCountries_fr' => 'Frankreich',
    'SHOP_MODULE_sPreselectableCountries_gf' => 'Französisch-Guayana',
    'SHOP_MODULE_sPreselectableCountries_pf' => 'Französisch-Polynesien',
    'SHOP_MODULE_sPreselectableCountries_tf' => 'Französische Süd-Territorien',
    'SHOP_MODULE_sPreselectableCountries_ga' => 'Gabun',
    'SHOP_MODULE_sPreselectableCountries_gm' => 'Gambia',
    'SHOP_MODULE_sPreselectableCountries_ge' => 'Georgien',
    'SHOP_MODULE_sPreselectableCountries_de' => 'Deutschland',
    'SHOP_MODULE_sPreselectableCountries_gh' => 'Ghana',
    'SHOP_MODULE_sPreselectableCountries_gi' => 'Gibraltar',
    'SHOP_MODULE_sPreselectableCountries_gr' => 'Griechenland',
    'SHOP_MODULE_sPreselectableCountries_gl' => 'Grönland',
    'SHOP_MODULE_sPreselectableCountries_gd' => 'Grenada',
    'SHOP_MODULE_sPreselectableCountries_gp' => 'Guadeloupe',
    'SHOP_MODULE_sPreselectableCountries_gu' => 'Guam',
    'SHOP_MODULE_sPreselectableCountries_gt' => 'Guatemala',
    'SHOP_MODULE_sPreselectableCountries_gg' => 'Guernsey',
    'SHOP_MODULE_sPreselectableCountries_gn' => 'Guinea',
    'SHOP_MODULE_sPreselectableCountries_gw' => 'Guinea-Bissau',
    'SHOP_MODULE_sPreselectableCountries_gy' => 'Guyana',
    'SHOP_MODULE_sPreselectableCountries_ht' => 'Haiti',
    'SHOP_MODULE_sPreselectableCountries_hm' => 'Heard Island und McDonaldinseln',
    'SHOP_MODULE_sPreselectableCountries_va' => 'Heiliger Stuhl',
    'SHOP_MODULE_sPreselectableCountries_hn' => 'Honduras',
    'SHOP_MODULE_sPreselectableCountries_hk' => 'Hongkong',
    'SHOP_MODULE_sPreselectableCountries_hu' => 'Ungarn',
    'SHOP_MODULE_sPreselectableCountries_is' => 'Island',
    'SHOP_MODULE_sPreselectableCountries_in' => 'Indien',
    'SHOP_MODULE_sPreselectableCountries_id' => 'Indonesien',
    'SHOP_MODULE_sPreselectableCountries_ir' => 'Iran (Islamische Republik)',
    'SHOP_MODULE_sPreselectableCountries_iq' => 'Irak',
    'SHOP_MODULE_sPreselectableCountries_ie' => 'Irland',
    'SHOP_MODULE_sPreselectableCountries_im' => 'Insel Man',
    'SHOP_MODULE_sPreselectableCountries_il' => 'Israel',
    'SHOP_MODULE_sPreselectableCountries_it' => 'Italien',
    'SHOP_MODULE_sPreselectableCountries_jm' => 'Jamaika',
    'SHOP_MODULE_sPreselectableCountries_jp' => 'Japan',
    'SHOP_MODULE_sPreselectableCountries_je' => 'Jersey',
    'SHOP_MODULE_sPreselectableCountries_jo' => 'Jordanien',
    'SHOP_MODULE_sPreselectableCountries_kz' => 'Kasachstan',
    'SHOP_MODULE_sPreselectableCountries_ke' => 'Kenia',
    'SHOP_MODULE_sPreselectableCountries_ki' => 'Kiribati',
    'SHOP_MODULE_sPreselectableCountries_kp' => 'Korea (Demokratische Volksrepublik)',
    'SHOP_MODULE_sPreselectableCountries_kr' => 'Korea, Republik',
    'SHOP_MODULE_sPreselectableCountries_kw' => 'Kuwait',
    'SHOP_MODULE_sPreselectableCountries_kg' => 'Kirgisistan',
    'SHOP_MODULE_sPreselectableCountries_la' => 'Demokratische Volksrepublik Laos',
    'SHOP_MODULE_sPreselectableCountries_lv' => 'Lettland',
    'SHOP_MODULE_sPreselectableCountries_lb' => 'Libanon',
    'SHOP_MODULE_sPreselectableCountries_ls' => 'Lesotho',
    'SHOP_MODULE_sPreselectableCountries_lr' => 'Liberia',
    'SHOP_MODULE_sPreselectableCountries_ly' => 'Libyen',
    'SHOP_MODULE_sPreselectableCountries_li' => 'Liechtenstein',
    'SHOP_MODULE_sPreselectableCountries_lt' => 'Litauen',
    'SHOP_MODULE_sPreselectableCountries_lu' => 'Luxemburg',
    'SHOP_MODULE_sPreselectableCountries_mo' => 'Macao',
    'SHOP_MODULE_sPreselectableCountries_mg' => 'Madagaskar',
    'SHOP_MODULE_sPreselectableCountries_mw' => 'Malawi',
    'SHOP_MODULE_sPreselectableCountries_my' => 'Malaysia',
    'SHOP_MODULE_sPreselectableCountries_mv' => 'Malediven',
    'SHOP_MODULE_sPreselectableCountries_ml' => 'Mali',
    'SHOP_MODULE_sPreselectableCountries_mt' => 'Malta',
    'SHOP_MODULE_sPreselectableCountries_mh' => 'Marshall-Inseln',
    'SHOP_MODULE_sPreselectableCountries_mq' => 'Martinique',
    'SHOP_MODULE_sPreselectableCountries_mr' => 'Mauretanien',
    'SHOP_MODULE_sPreselectableCountries_mu' => 'Mauritius',
    'SHOP_MODULE_sPreselectableCountries_yt' => 'Mayotte',
    'SHOP_MODULE_sPreselectableCountries_mx' => 'Mexiko',
    'SHOP_MODULE_sPreselectableCountries_fm' => 'Mikronesien (Föderierte Staaten von)',
    'SHOP_MODULE_sPreselectableCountries_md' => 'Moldawien, Republik',
    'SHOP_MODULE_sPreselectableCountries_mc' => 'Monaco',
    'SHOP_MODULE_sPreselectableCountries_mn' => 'Mongolei',
    'SHOP_MODULE_sPreselectableCountries_me' => 'Montenegro',
    'SHOP_MODULE_sPreselectableCountries_ms' => 'Montserrat',
    'SHOP_MODULE_sPreselectableCountries_ma' => 'Marokko',
    'SHOP_MODULE_sPreselectableCountries_mz' => 'Mosambik',
    'SHOP_MODULE_sPreselectableCountries_mm' => 'Myanmar',
    'SHOP_MODULE_sPreselectableCountries_na' => 'Namibia',
    'SHOP_MODULE_sPreselectableCountries_nr' => 'Nauru',
    'SHOP_MODULE_sPreselectableCountries_np' => 'Nepal',
    'SHOP_MODULE_sPreselectableCountries_nl' => 'Niederlande',
    'SHOP_MODULE_sPreselectableCountries_nc' => 'Neukaledonien',
    'SHOP_MODULE_sPreselectableCountries_nz' => 'Neuseeland',
    'SHOP_MODULE_sPreselectableCountries_ni' => 'Nicaragua',
    'SHOP_MODULE_sPreselectableCountries_ne' => 'Niger',
    'SHOP_MODULE_sPreselectableCountries_ng' => 'Nigeria',
    'SHOP_MODULE_sPreselectableCountries_nu' => 'Niue',
    'SHOP_MODULE_sPreselectableCountries_nf' => 'Norfolkinsel',
    'SHOP_MODULE_sPreselectableCountries_mk' => 'Nord-Mazedonien',
    'SHOP_MODULE_sPreselectableCountries_mp' => 'Nördliche Marianen-Inseln',
    'SHOP_MODULE_sPreselectableCountries_no' => 'Norwegen',
    'SHOP_MODULE_sPreselectableCountries_om' => 'Oman',
    'SHOP_MODULE_sPreselectableCountries_pk' => 'Pakistan',
    'SHOP_MODULE_sPreselectableCountries_pw' => 'Palau',
    'SHOP_MODULE_sPreselectableCountries_ps' => 'Palästina, Staat',
    'SHOP_MODULE_sPreselectableCountries_pa' => 'Panama',
    'SHOP_MODULE_sPreselectableCountries_pg' => 'Papua-Neuguinea',
    'SHOP_MODULE_sPreselectableCountries_py' => 'Paraguay',
    'SHOP_MODULE_sPreselectableCountries_pe' => 'Peru',
    'SHOP_MODULE_sPreselectableCountries_ph' => 'Philippinen',
    'SHOP_MODULE_sPreselectableCountries_pn' => 'Pitcairn',
    'SHOP_MODULE_sPreselectableCountries_pl' => 'Polen',
    'SHOP_MODULE_sPreselectableCountries_pt' => 'Portugal',
    'SHOP_MODULE_sPreselectableCountries_pr' => 'Puerto Rico',
    'SHOP_MODULE_sPreselectableCountries_qa' => 'Katar',
    'SHOP_MODULE_sPreselectableCountries_re' => 'Réunion',
    'SHOP_MODULE_sPreselectableCountries_ro' => 'Rumänien',
    'SHOP_MODULE_sPreselectableCountries_ru' => 'Russische Föderation',
    'SHOP_MODULE_sPreselectableCountries_rw' => 'Ruanda',
    'SHOP_MODULE_sPreselectableCountries_bl' => 'Sankt Barthélemy',
    'SHOP_MODULE_sPreselectableCountries_sh' => 'Heilige Helena, Himmelfahrt und Tristan da Cunha',
    'SHOP_MODULE_sPreselectableCountries_kn' => 'St. Kitts und Nevis',
    'SHOP_MODULE_sPreselectableCountries_lc' => 'St. Lucia',
    'SHOP_MODULE_sPreselectableCountries_mf' => 'Saint Martin (französischer Teil)',
    'SHOP_MODULE_sPreselectableCountries_pm' => 'St. Pierre und Miquelon',
    'SHOP_MODULE_sPreselectableCountries_vc' => 'St. Vincent und die Grenadinen',
    'SHOP_MODULE_sPreselectableCountries_ws' => 'Samoa',
    'SHOP_MODULE_sPreselectableCountries_sm' => 'San Marino',
    'SHOP_MODULE_sPreselectableCountries_st' => 'São Tomé und Príncipe',
    'SHOP_MODULE_sPreselectableCountries_sa' => 'Saudi-Arabien',
    'SHOP_MODULE_sPreselectableCountries_sn' => 'Senegal',
    'SHOP_MODULE_sPreselectableCountries_rs' => 'Serbien',
    'SHOP_MODULE_sPreselectableCountries_sc' => 'Seychellen',
    'SHOP_MODULE_sPreselectableCountries_sl' => 'Sierra Leone',
    'SHOP_MODULE_sPreselectableCountries_sg' => 'Singapur',
    'SHOP_MODULE_sPreselectableCountries_sx' => 'Sint Maarten (niederländischer Teil)',
    'SHOP_MODULE_sPreselectableCountries_sk' => 'Slowakei',
    'SHOP_MODULE_sPreselectableCountries_si' => 'Slowenien',
    'SHOP_MODULE_sPreselectableCountries_sb' => 'Salomon-Inseln',
    'SHOP_MODULE_sPreselectableCountries_so' => 'Somalia',
    'SHOP_MODULE_sPreselectableCountries_za' => 'Südafrika',
    'SHOP_MODULE_sPreselectableCountries_gs' => 'Südgeorgien und die Südlichen Sandwichinseln',
    'SHOP_MODULE_sPreselectableCountries_ss' => 'Südsudan',
    'SHOP_MODULE_sPreselectableCountries_es' => 'Spanien',
    'SHOP_MODULE_sPreselectableCountries_lk' => 'Sri Lanka',
    'SHOP_MODULE_sPreselectableCountries_sd' => 'Sudan',
    'SHOP_MODULE_sPreselectableCountries_sr' => 'Surinam',
    'SHOP_MODULE_sPreselectableCountries_sj' => 'Svalbard und Jan Mayen',
    'SHOP_MODULE_sPreselectableCountries_se' => 'Schweden',
    'SHOP_MODULE_sPreselectableCountries_ch' => 'Schweiz',
    'SHOP_MODULE_sPreselectableCountries_sy' => 'Arabische Republik Syrien',
    'SHOP_MODULE_sPreselectableCountries_tw' => 'Taiwan, Provinz China',
    'SHOP_MODULE_sPreselectableCountries_tj' => 'Tadschikistan',
    'SHOP_MODULE_sPreselectableCountries_tz' => 'Tansania, Vereinigte Republik',
    'SHOP_MODULE_sPreselectableCountries_th' => 'Thailand',
    'SHOP_MODULE_sPreselectableCountries_tl' => 'Timor-Leste',
    'SHOP_MODULE_sPreselectableCountries_tg' => 'Togo',
    'SHOP_MODULE_sPreselectableCountries_tk' => 'Tokelau',
    'SHOP_MODULE_sPreselectableCountries_to' => 'Tonga',
    'SHOP_MODULE_sPreselectableCountries_tt' => 'Trinidad und Tobago',
    'SHOP_MODULE_sPreselectableCountries_tn' => 'Tunesien',
    'SHOP_MODULE_sPreselectableCountries_tr' => 'Türkei',
    'SHOP_MODULE_sPreselectableCountries_tm' => 'Turkmenistan',
    'SHOP_MODULE_sPreselectableCountries_tc' => 'Turks- und Caicosinseln',
    'SHOP_MODULE_sPreselectableCountries_tv' => 'Tuvalu',
    'SHOP_MODULE_sPreselectableCountries_ug' => 'Uganda',
    'SHOP_MODULE_sPreselectableCountries_ua' => 'Ukraine',
    'SHOP_MODULE_sPreselectableCountries_ae' => 'Vereinigte Arabische Emirate',
    'SHOP_MODULE_sPreselectableCountries_gb' => 'Vereinigtes Königreich von Großbritannien und Nordirland',
    'SHOP_MODULE_sPreselectableCountries_us' => 'Vereinigte Staaten von Amerika',
    'SHOP_MODULE_sPreselectableCountries_um' => 'U.S.-Minderjährige abgelegene Inseln',
    'SHOP_MODULE_sPreselectableCountries_uy' => 'Uruguay',
    'SHOP_MODULE_sPreselectableCountries_uz' => 'Usbekistan',
    'SHOP_MODULE_sPreselectableCountries_vu' => 'Vanuatu',
    'SHOP_MODULE_sPreselectableCountries_ve' => 'Venezuela (Bolivarische Republik)',
    'SHOP_MODULE_sPreselectableCountries_vn' => 'Vietnam',
    'SHOP_MODULE_sPreselectableCountries_vg' => 'Jungferninseln (Britisch)',
    'SHOP_MODULE_sPreselectableCountries_vi' => 'Jungferninseln (Vereinigte Staaten)',
    'SHOP_MODULE_sPreselectableCountries_wf' => 'Wallis und Futuna',
    'SHOP_MODULE_sPreselectableCountries_eh' => 'Westsahara',
    'SHOP_MODULE_sPreselectableCountries_ye' => 'Jemen',
    'SHOP_MODULE_sPreselectableCountries_zm' => 'Sambia',
    'SHOP_MODULE_sPreselectableCountries_zw' => 'Simbabwe',
    'SHOP_MODULE_bCorrectTranspositionedNames' => 'Vertauschten Vor- und Nachnamen korrigieren (BETA)',
];
