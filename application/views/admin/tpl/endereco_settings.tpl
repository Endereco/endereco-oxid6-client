[{include file="headitem.tpl" title="[ Endereco Einstellungen ]"}]
[{ if $readonly }]
    [{assign var="readonly" value="readonly disabled"}]
[{ else }]
    [{assign var="readonly" value=""}]
[{ /if }]

<link rel="stylesheet" href="[{$oViewConf->getModuleUrl("endereco-oxid6-client", "out/admin/css/styles.css")}]">
<div class="endereco-admin-page">

<form name="myedit" id="myedit" action="[{ $oViewConf->getSelfLink() }]" method="post">
    [{$oViewConf->getHiddenSid()}]
    <input type="hidden" name="cl" value="enderecosettings" />
    <input type="hidden" name="fnc" value="" />
    <input type="hidden" name="oxid" value="[{$oxid}]" />

    <fieldset>
        <legend><strong>[{oxmultilang ident="SHOP_MODULE_GROUP_ACCESS"}]</strong></legend>
        <table class="ettm-table">
            <tr>
                <td>
                    [{oxmultilang ident="SHOP_MODULE_sAPIKEY"}]
                </td>
                <td>
                    <input type="text" class="editinput" size="60" maxlength="255" name="cstrs[sAPIKEY]" value="[{$cstrs.sAPIKEY}]">
                    &nbsp;[{ oxinputhelp ident="HELP_SHOP_MODULE_sAPIKEY" }]
                </td>
            </tr>
            <tr>
                <td>
                    [{oxmultilang ident="ENDERECOCLIENTOX_SETTINGS_STATUS"}]
                </td>
                <td>
                    [{if $cstrs.bHasConnection}]
                    <span class="endereco-green-status">
                            <strong>
                                [{oxmultilang ident="ENDERECOCLIENTOX_SETTINGS_STATUS_OK"}]
                            </strong>
                            [{oxmultilang ident="ENDERECOCLIENTOX_SETTINGS_STATUS_OK_LONG"}]
                            &nbsp;[{ oxinputhelp ident="ENDERECOCLIENTOX_SETTINGS_STATUS_OK_HELP" }]
                        </span>
                    [{else}]
                    <span class="endereco-red-status">
                            <strong>
                                [{oxmultilang ident="ENDERECOCLIENTOX_SETTINGS_STATUS_FAIL"}]
                            </strong>
                            [{oxmultilang ident="ENDERECOCLIENTOX_SETTINGS_STATUS_FAIL_LONG"}]
                            &nbsp;[{ oxinputhelp ident="ENDERECOCLIENTOX_SETTINGS_STATUS_FAIL_HELP" }]
                        </span>
                    [{/if}]
                </td>
            </tr>

            <tr>
                <td>
                    [{oxmultilang ident="SHOP_MODULE_sSERVICEURL"}]
                </td>
                <td>
                    <input type="text" class="editinput" size="60" maxlength="255" name="cstrs[sSERVICEURL]" value="[{$cstrs.sSERVICEURL}]">
                    &nbsp;[{ oxinputhelp ident="HELP_SHOP_MODULE_sSERVICEURL" }]
                </td>
            </tr>
        </table>
    </fieldset>

    <fieldset>
        <legend><strong>[{oxmultilang ident="SHOP_MODULE_GROUP_AMS"}]</strong></legend>
        <table class="ettm-table">
            <tr>
                <td>
                    [{oxmultilang ident="SHOP_MODULE_sUSEAMS"}]
                </td>
                <td>
                    <input type="checkbox" class="editinput" name="cstrs[sUSEAMS]" value="true" [{if $cstrs.sUSEAMS == true}]checked="checked"[{/if}]>
                    &nbsp;[{ oxinputhelp ident="HELP_SHOP_MODULE_sUSEAMS" }]
                </td>
            </tr>
            <tr>
                <td>
                    [{oxmultilang ident="SHOP_MODULE_sCHECKALL"}]
                </td>
                <td>
                    <input type="checkbox" class="editinput" name="cstrs[sCHECKALL]" value="true" [{if $cstrs.sCHECKALL == true}]checked="checked"[{/if}]>
                    &nbsp;[{ oxinputhelp ident="HELP_SHOP_MODULE_sCHECKALL" }]
                </td>
            </tr>
            <tr>
                <td>
                    [{oxmultilang ident="SHOP_MODULE_sAMSBLURTRIGGER"}]
                </td>
                <td>
                    <input type="checkbox" class="editinput" name="cstrs[sAMSBLURTRIGGER]" value="true" [{if $cstrs.sAMSBLURTRIGGER == true}]checked="checked"[{/if}]>
                    &nbsp;[{ oxinputhelp ident="HELP_SHOP_MODULE_sAMSBLURTRIGGER" }]
                </td>
            </tr>
            <tr>
                <td>
                    [{oxmultilang ident="SHOP_MODULE_sSMARTFILL"}]
                </td>
                <td>
                    <input type="checkbox" class="editinput" name="cstrs[sSMARTFILL]" value="true" [{if $cstrs.sSMARTFILL == true}]checked="checked"[{/if}]>
                    &nbsp;[{ oxinputhelp ident="HELP_SHOP_MODULE_sSMARTFILL" }]
                </td>
            </tr>
        </table>
    </fieldset>

    <fieldset>
        <legend><strong>[{oxmultilang ident="SHOP_MODULE_GROUP_EmailServices"}]</strong></legend>
        <table class="ettm-table">
            <tr>
                <td>
                    [{oxmultilang ident="SHOP_MODULE_bUseEmailservice"}]
                </td>
                <td>
                    <input type="checkbox" class="editinput" name="cstrs[bUseEmailservice]" value="true" [{if $cstrs.bUseEmailservice == true}]checked="checked"[{/if}]>
                    &nbsp;[{ oxinputhelp ident="HELP_SHOP_MODULE_bUseEmailservice" }]
                </td>
            </tr>
        </table>
    </fieldset>

    <fieldset>
        <legend><strong>[{oxmultilang ident="SHOP_MODULE_GROUP_PersonalService"}]</strong></legend>
        <table class="ettm-table">
            <tr>
                <td>
                    [{oxmultilang ident="SHOP_MODULE_bUsePersonalService"}]
                </td>
                <td>
                    <input type="checkbox" class="editinput" name="cstrs[bUsePersonalService]" value="true" [{if $cstrs.bUsePersonalService == true}]checked="checked"[{/if}]>
                    &nbsp;[{ oxinputhelp ident="HELP_SHOP_MODULE_bUsePersonalService" }]
                </td>
            </tr>
        </table>
    </fieldset>

    <fieldset>
        <legend><strong>[{oxmultilang ident="SHOP_MODULE_GROUP_VISUAL"}]</strong></legend>
        <table class="ettm-table">
            <tr>
                <td>
                    [{oxmultilang ident="SHOP_MODULE_bUseCss"}]
                </td>
                <td>
                    <input type="checkbox" class="editinput" name="cstrs[bUseCss]" value="true" [{if $cstrs.bUseCss == true}]checked="checked"[{/if}]>
                    &nbsp;[{ oxinputhelp ident="HELP_SHOP_MODULE_bUseCss" }]
                </td>
            </tr>
            <tr>
                <td>
                    [{oxmultilang ident="SHOP_MODULE_sMainColor"}]
                </td>
                <td>
                    <input type="color" class="editinput" size="60" maxlength="255" name="cstrs[sMainColor]" value="[{$cstrs.sMainColor}]">
                    &nbsp;[{ oxinputhelp ident="HELP_SHOP_MODULE_sMainColor" }]
                </td>
            </tr>
            <tr>
                <td>
                    [{oxmultilang ident="SHOP_MODULE_sErrorColor"}]
                </td>
                <td>
                    <input type="color" class="editinput" size="60" maxlength="255" name="cstrs[sErrorColor]" value="[{$cstrs.sErrorColor}]">
                    &nbsp;[{ oxinputhelp ident="HELP_SHOP_MODULE_sErrorColor" }]
                </td>
            </tr>
            <tr>
                <td>
                    [{oxmultilang ident="SHOP_MODULE_sSelectionColor"}]
                </td>
                <td>
                    <input type="color" class="editinput" size="60" maxlength="255" name="cstrs[sSelectionColor]" value="[{$cstrs.sSelectionColor}]">
                    &nbsp;[{ oxinputhelp ident="HELP_SHOP_MODULE_sSelectionColor" }]
                </td>
            </tr>
        </table>
    </fieldset>

    <fieldset>
        <legend><strong>[{oxmultilang ident="SHOP_MODULE_GROUP_ADVANCED"}]</strong></legend>
        <table class="ettm-table">
            <tr>
                <td>
                    [{oxmultilang ident="SHOP_MODULE_sAllowedControllerClasses"}]
                </td>
                <td>
                    <input type="text" class="editinput" size="60" maxlength="255" name="cstrs[sAllowedControllerClasses]" value="[{$cstrs.sAllowedControllerClasses}]">
                    &nbsp;[{ oxinputhelp ident="HELP_SHOP_MODULE_sAllowedControllerClasses" }]
                </td>
            </tr>
            <tr>
                <td>
                    [{oxmultilang ident="SHOP_MODULE_bShowDebug"}]
                </td>
                <td>
                    <input type="checkbox" class="editinput" name="cstrs[bShowDebug]" value="true" [{if $cstrs.bShowDebug == true}]checked="checked"[{/if}]>
                    &nbsp;[{ oxinputhelp ident="HELP_SHOP_MODULE_bShowDebug" }]
                </td>
            </tr>
        </table>
    </fieldset>

    <input type="submit" class="edittext" name="save" value="&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;[{oxmultilang ident="GENERAL_SAVE"}]&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;" onClick="Javascript:document.myedit.fnc.value='save'"><br>

</form>

</div>

[{include file="bottomitem.tpl"}]
