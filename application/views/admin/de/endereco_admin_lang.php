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
$aLang = array(
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
    'SHOP_MODULE_sCHECKALL' => 'Auch Bestandskunden einmalig prüfen',
    'HELP_SHOP_MODULE_sCHECKALL' => 'Bestandskunden, die noch nicht geprüft wurden, werden bei einem Login und Aufruf einer Adressformular-Seite automatisch geprüft.',
    'SHOP_MODULE_sAMSBLURTRIGGER' => 'Adressprüfung sofort nach verlassen des Hausnummern Feldes auslösen',
    'HELP_SHOP_MODULE_sAMSBLURTRIGGER' => 'Ist die Funktion aktiv, wird die Adressprüfung sofort nach Eingabe der Adresse angestoßen. Ist die deaktiviert, erfolg die Prüfung beim Klick auf den "Weiter" Button.',
    'SHOP_MODULE_sSMARTFILL' => 'Felder bei nur einem verbleibenden Adressvorschlag automatisch ausfüllen (SmartAutocomplete) <i>beta</i>',

    'SHOP_MODULE_GROUP_EmailServices' => 'E-Mail Service',
    'SHOP_MODULE_bUseEmailservice'=> 'E-Mail Adressprüfung aktivieren',
    'SHOP_MODULE_GROUP_PersonalService'=> 'Anredeprüfung',
    'SHOP_MODULE_bUsePersonalService'=> 'Anredeprüfung basierend auf dem Vornamen aktivieren und Anrede automatisch setzen',
    'SHOP_MODULE_GROUP_VISUAL'=> 'Designanpassungen',
    'SHOP_MODULE_bUseCss'=> 'Standard-CSS nutzen',
    'SHOP_MODULE_sMainColor'=> 'Hauptfarbe im Dropdown',
    'SHOP_MODULE_sErrorColor'=> 'Fehlerfarbe im Modal',
    'SHOP_MODULE_sSelectionColor'=> 'Auswahlfarbe im Modal',
    'SHOP_MODULE_GROUP_ADVANCED'=> 'Entwicklereinstellungen',
    'SHOP_MODULE_sAllowedControllerClasses'=> 'Whitelist der Controller-Klassen, bei denen das Modul aktiviert wird',
    'SHOP_MODULE_bShowDebug'=> 'Debuginformationen in der Browserkonsole ausgeben',
);
