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
                    [{oxmultilang ident="SHOP_MODULE_bPreselectCountry"}]
                </td>
                <td>
                    <input type="checkbox" class="editinput" name="cstrs[bPreselectCountry]" value="true" [{if $cstrs.bPreselectCountry == true}]checked="checked"[{/if}]>
                    &nbsp;[{ oxinputhelp ident="HELP_SHOP_MODULE_bPreselectCountry" }]
                </td>
            </tr>
            <tr>
                <td>
                    [{oxmultilang ident="SHOP_MODULE_sPreselectableCountries"}]
                </td>
                <td>
                    <select class="editinput" name="cstrs[sPreselectableCountries]">
                        <option value="de" [{if $cstrs.sPreselectableCountries == 'de'}]selected="selected"[{/if}]>[{oxmultilang ident="SHOP_MODULE_sPreselectableCountries_de"}]</option>
                        <option value="af" [{if $cstrs.sPreselectableCountries == 'af'}]selected="selected"[{/if}]>[{oxmultilang ident="SHOP_MODULE_sPreselectableCountries_af"}]</option>
                        <option value="ax" [{if $cstrs.sPreselectableCountries == 'ax'}]selected="selected"[{/if}]>[{oxmultilang ident="SHOP_MODULE_sPreselectableCountries_ax"}]</option>
                        <option value="al" [{if $cstrs.sPreselectableCountries == 'al'}]selected="selected"[{/if}]>[{oxmultilang ident="SHOP_MODULE_sPreselectableCountries_al"}]</option>
                        <option value="dz" [{if $cstrs.sPreselectableCountries == 'dz'}]selected="selected"[{/if}]>[{oxmultilang ident="SHOP_MODULE_sPreselectableCountries_dz"}]</option>
                        <option value="as" [{if $cstrs.sPreselectableCountries == 'as'}]selected="selected"[{/if}]>[{oxmultilang ident="SHOP_MODULE_sPreselectableCountries_as"}]</option>
                        <option value="ad" [{if $cstrs.sPreselectableCountries == 'ad'}]selected="selected"[{/if}]>[{oxmultilang ident="SHOP_MODULE_sPreselectableCountries_ad"}]</option>
                        <option value="ao" [{if $cstrs.sPreselectableCountries == 'ao'}]selected="selected"[{/if}]>[{oxmultilang ident="SHOP_MODULE_sPreselectableCountries_ao"}]</option>
                        <option value="ai" [{if $cstrs.sPreselectableCountries == 'ai'}]selected="selected"[{/if}]>[{oxmultilang ident="SHOP_MODULE_sPreselectableCountries_ai"}]</option>
                        <option value="aq" [{if $cstrs.sPreselectableCountries == 'aq'}]selected="selected"[{/if}]>[{oxmultilang ident="SHOP_MODULE_sPreselectableCountries_aq"}]</option>
                        <option value="ag" [{if $cstrs.sPreselectableCountries == 'ag'}]selected="selected"[{/if}]>[{oxmultilang ident="SHOP_MODULE_sPreselectableCountries_ag"}]</option>
                        <option value="ar" [{if $cstrs.sPreselectableCountries == 'ar'}]selected="selected"[{/if}]>[{oxmultilang ident="SHOP_MODULE_sPreselectableCountries_ar"}]</option>
                        <option value="am" [{if $cstrs.sPreselectableCountries == 'am'}]selected="selected"[{/if}]>[{oxmultilang ident="SHOP_MODULE_sPreselectableCountries_am"}]</option>
                        <option value="aw" [{if $cstrs.sPreselectableCountries == 'aw'}]selected="selected"[{/if}]>[{oxmultilang ident="SHOP_MODULE_sPreselectableCountries_aw"}]</option>
                        <option value="au" [{if $cstrs.sPreselectableCountries == 'au'}]selected="selected"[{/if}]>[{oxmultilang ident="SHOP_MODULE_sPreselectableCountries_au"}]</option>
                        <option value="at" [{if $cstrs.sPreselectableCountries == 'at'}]selected="selected"[{/if}]>[{oxmultilang ident="SHOP_MODULE_sPreselectableCountries_at"}]</option>
                        <option value="az" [{if $cstrs.sPreselectableCountries == 'az'}]selected="selected"[{/if}]>[{oxmultilang ident="SHOP_MODULE_sPreselectableCountries_az"}]</option>
                        <option value="bs" [{if $cstrs.sPreselectableCountries == 'bs'}]selected="selected"[{/if}]>[{oxmultilang ident="SHOP_MODULE_sPreselectableCountries_bs"}]</option>
                        <option value="bh" [{if $cstrs.sPreselectableCountries == 'bh'}]selected="selected"[{/if}]>[{oxmultilang ident="SHOP_MODULE_sPreselectableCountries_bh"}]</option>
                        <option value="bd" [{if $cstrs.sPreselectableCountries == 'bd'}]selected="selected"[{/if}]>[{oxmultilang ident="SHOP_MODULE_sPreselectableCountries_bd"}]</option>
                        <option value="bb" [{if $cstrs.sPreselectableCountries == 'bb'}]selected="selected"[{/if}]>[{oxmultilang ident="SHOP_MODULE_sPreselectableCountries_bb"}]</option>
                        <option value="by" [{if $cstrs.sPreselectableCountries == 'by'}]selected="selected"[{/if}]>[{oxmultilang ident="SHOP_MODULE_sPreselectableCountries_by"}]</option>
                        <option value="be" [{if $cstrs.sPreselectableCountries == 'be'}]selected="selected"[{/if}]>[{oxmultilang ident="SHOP_MODULE_sPreselectableCountries_be"}]</option>
                        <option value="bz" [{if $cstrs.sPreselectableCountries == 'bz'}]selected="selected"[{/if}]>[{oxmultilang ident="SHOP_MODULE_sPreselectableCountries_bz"}]</option>
                        <option value="bj" [{if $cstrs.sPreselectableCountries == 'bj'}]selected="selected"[{/if}]>[{oxmultilang ident="SHOP_MODULE_sPreselectableCountries_bj"}]</option>
                        <option value="bm" [{if $cstrs.sPreselectableCountries == 'bm'}]selected="selected"[{/if}]>[{oxmultilang ident="SHOP_MODULE_sPreselectableCountries_bm"}]</option>
                        <option value="bt" [{if $cstrs.sPreselectableCountries == 'bt'}]selected="selected"[{/if}]>[{oxmultilang ident="SHOP_MODULE_sPreselectableCountries_bt"}]</option>
                        <option value="bo" [{if $cstrs.sPreselectableCountries == 'bo'}]selected="selected"[{/if}]>[{oxmultilang ident="SHOP_MODULE_sPreselectableCountries_bo"}]</option>
                        <option value="bq" [{if $cstrs.sPreselectableCountries == 'bq'}]selected="selected"[{/if}]>[{oxmultilang ident="SHOP_MODULE_sPreselectableCountries_bq"}]</option>
                        <option value="ba" [{if $cstrs.sPreselectableCountries == 'ba'}]selected="selected"[{/if}]>[{oxmultilang ident="SHOP_MODULE_sPreselectableCountries_ba"}]</option>
                        <option value="bw" [{if $cstrs.sPreselectableCountries == 'bw'}]selected="selected"[{/if}]>[{oxmultilang ident="SHOP_MODULE_sPreselectableCountries_bw"}]</option>
                        <option value="bv" [{if $cstrs.sPreselectableCountries == 'bv'}]selected="selected"[{/if}]>[{oxmultilang ident="SHOP_MODULE_sPreselectableCountries_bv"}]</option>
                        <option value="br" [{if $cstrs.sPreselectableCountries == 'br'}]selected="selected"[{/if}]>[{oxmultilang ident="SHOP_MODULE_sPreselectableCountries_br"}]</option>
                        <option value="io" [{if $cstrs.sPreselectableCountries == 'io'}]selected="selected"[{/if}]>[{oxmultilang ident="SHOP_MODULE_sPreselectableCountries_io"}]</option>
                        <option value="bn" [{if $cstrs.sPreselectableCountries == 'bn'}]selected="selected"[{/if}]>[{oxmultilang ident="SHOP_MODULE_sPreselectableCountries_bn"}]</option>
                        <option value="bg" [{if $cstrs.sPreselectableCountries == 'bg'}]selected="selected"[{/if}]>[{oxmultilang ident="SHOP_MODULE_sPreselectableCountries_bg"}]</option>
                        <option value="bf" [{if $cstrs.sPreselectableCountries == 'bf'}]selected="selected"[{/if}]>[{oxmultilang ident="SHOP_MODULE_sPreselectableCountries_bf"}]</option>
                        <option value="bi" [{if $cstrs.sPreselectableCountries == 'bi'}]selected="selected"[{/if}]>[{oxmultilang ident="SHOP_MODULE_sPreselectableCountries_bi"}]</option>
                        <option value="cv" [{if $cstrs.sPreselectableCountries == 'cv'}]selected="selected"[{/if}]>[{oxmultilang ident="SHOP_MODULE_sPreselectableCountries_cv"}]</option>
                        <option value="kh" [{if $cstrs.sPreselectableCountries == 'kh'}]selected="selected"[{/if}]>[{oxmultilang ident="SHOP_MODULE_sPreselectableCountries_kh"}]</option>
                        <option value="cm" [{if $cstrs.sPreselectableCountries == 'cm'}]selected="selected"[{/if}]>[{oxmultilang ident="SHOP_MODULE_sPreselectableCountries_cm"}]</option>
                        <option value="ca" [{if $cstrs.sPreselectableCountries == 'ca'}]selected="selected"[{/if}]>[{oxmultilang ident="SHOP_MODULE_sPreselectableCountries_ca"}]</option>
                        <option value="ky" [{if $cstrs.sPreselectableCountries == 'ky'}]selected="selected"[{/if}]>[{oxmultilang ident="SHOP_MODULE_sPreselectableCountries_ky"}]</option>
                        <option value="cf" [{if $cstrs.sPreselectableCountries == 'cf'}]selected="selected"[{/if}]>[{oxmultilang ident="SHOP_MODULE_sPreselectableCountries_cf"}]</option>
                        <option value="td" [{if $cstrs.sPreselectableCountries == 'td'}]selected="selected"[{/if}]>[{oxmultilang ident="SHOP_MODULE_sPreselectableCountries_td"}]</option>
                        <option value="cl" [{if $cstrs.sPreselectableCountries == 'cl'}]selected="selected"[{/if}]>[{oxmultilang ident="SHOP_MODULE_sPreselectableCountries_cl"}]</option>
                        <option value="cn" [{if $cstrs.sPreselectableCountries == 'cn'}]selected="selected"[{/if}]>[{oxmultilang ident="SHOP_MODULE_sPreselectableCountries_cn"}]</option>
                        <option value="cx" [{if $cstrs.sPreselectableCountries == 'cx'}]selected="selected"[{/if}]>[{oxmultilang ident="SHOP_MODULE_sPreselectableCountries_cx"}]</option>
                        <option value="cc" [{if $cstrs.sPreselectableCountries == 'cc'}]selected="selected"[{/if}]>[{oxmultilang ident="SHOP_MODULE_sPreselectableCountries_cc"}]</option>
                        <option value="co" [{if $cstrs.sPreselectableCountries == 'co'}]selected="selected"[{/if}]>[{oxmultilang ident="SHOP_MODULE_sPreselectableCountries_co"}]</option>
                        <option value="km" [{if $cstrs.sPreselectableCountries == 'km'}]selected="selected"[{/if}]>[{oxmultilang ident="SHOP_MODULE_sPreselectableCountries_km"}]</option>
                        <option value="cg" [{if $cstrs.sPreselectableCountries == 'cg'}]selected="selected"[{/if}]>[{oxmultilang ident="SHOP_MODULE_sPreselectableCountries_cg"}]</option>
                        <option value="cd" [{if $cstrs.sPreselectableCountries == 'cd'}]selected="selected"[{/if}]>[{oxmultilang ident="SHOP_MODULE_sPreselectableCountries_cd"}]</option>
                        <option value="ck" [{if $cstrs.sPreselectableCountries == 'ck'}]selected="selected"[{/if}]>[{oxmultilang ident="SHOP_MODULE_sPreselectableCountries_ck"}]</option>
                        <option value="cr" [{if $cstrs.sPreselectableCountries == 'cr'}]selected="selected"[{/if}]>[{oxmultilang ident="SHOP_MODULE_sPreselectableCountries_cr"}]</option>
                        <option value="ci" [{if $cstrs.sPreselectableCountries == 'ci'}]selected="selected"[{/if}]>[{oxmultilang ident="SHOP_MODULE_sPreselectableCountries_ci"}]</option>
                        <option value="hr" [{if $cstrs.sPreselectableCountries == 'hr'}]selected="selected"[{/if}]>[{oxmultilang ident="SHOP_MODULE_sPreselectableCountries_hr"}]</option>
                        <option value="cu" [{if $cstrs.sPreselectableCountries == 'cu'}]selected="selected"[{/if}]>[{oxmultilang ident="SHOP_MODULE_sPreselectableCountries_cu"}]</option>
                        <option value="cw" [{if $cstrs.sPreselectableCountries == 'cw'}]selected="selected"[{/if}]>[{oxmultilang ident="SHOP_MODULE_sPreselectableCountries_cw"}]</option>
                        <option value="cy" [{if $cstrs.sPreselectableCountries == 'cy'}]selected="selected"[{/if}]>[{oxmultilang ident="SHOP_MODULE_sPreselectableCountries_cy"}]</option>
                        <option value="cz" [{if $cstrs.sPreselectableCountries == 'cz'}]selected="selected"[{/if}]>[{oxmultilang ident="SHOP_MODULE_sPreselectableCountries_cz"}]</option>
                        <option value="dk" [{if $cstrs.sPreselectableCountries == 'dk'}]selected="selected"[{/if}]>[{oxmultilang ident="SHOP_MODULE_sPreselectableCountries_dk"}]</option>
                        <option value="dj" [{if $cstrs.sPreselectableCountries == 'dj'}]selected="selected"[{/if}]>[{oxmultilang ident="SHOP_MODULE_sPreselectableCountries_dj"}]</option>
                        <option value="dm" [{if $cstrs.sPreselectableCountries == 'dm'}]selected="selected"[{/if}]>[{oxmultilang ident="SHOP_MODULE_sPreselectableCountries_dm"}]</option>
                        <option value="do" [{if $cstrs.sPreselectableCountries == 'do'}]selected="selected"[{/if}]>[{oxmultilang ident="SHOP_MODULE_sPreselectableCountries_do"}]</option>
                        <option value="ec" [{if $cstrs.sPreselectableCountries == 'ec'}]selected="selected"[{/if}]>[{oxmultilang ident="SHOP_MODULE_sPreselectableCountries_ec"}]</option>
                        <option value="eg" [{if $cstrs.sPreselectableCountries == 'eg'}]selected="selected"[{/if}]>[{oxmultilang ident="SHOP_MODULE_sPreselectableCountries_eg"}]</option>
                        <option value="sv" [{if $cstrs.sPreselectableCountries == 'sv'}]selected="selected"[{/if}]>[{oxmultilang ident="SHOP_MODULE_sPreselectableCountries_sv"}]</option>
                        <option value="gq" [{if $cstrs.sPreselectableCountries == 'gq'}]selected="selected"[{/if}]>[{oxmultilang ident="SHOP_MODULE_sPreselectableCountries_gq"}]</option>
                        <option value="er" [{if $cstrs.sPreselectableCountries == 'er'}]selected="selected"[{/if}]>[{oxmultilang ident="SHOP_MODULE_sPreselectableCountries_er"}]</option>
                        <option value="ee" [{if $cstrs.sPreselectableCountries == 'ee'}]selected="selected"[{/if}]>[{oxmultilang ident="SHOP_MODULE_sPreselectableCountries_ee"}]</option>
                        <option value="sz" [{if $cstrs.sPreselectableCountries == 'sz'}]selected="selected"[{/if}]>[{oxmultilang ident="SHOP_MODULE_sPreselectableCountries_sz"}]</option>
                        <option value="et" [{if $cstrs.sPreselectableCountries == 'et'}]selected="selected"[{/if}]>[{oxmultilang ident="SHOP_MODULE_sPreselectableCountries_et"}]</option>
                        <option value="fk" [{if $cstrs.sPreselectableCountries == 'fk'}]selected="selected"[{/if}]>[{oxmultilang ident="SHOP_MODULE_sPreselectableCountries_fk"}]</option>
                        <option value="fo" [{if $cstrs.sPreselectableCountries == 'fo'}]selected="selected"[{/if}]>[{oxmultilang ident="SHOP_MODULE_sPreselectableCountries_fo"}]</option>
                        <option value="fj" [{if $cstrs.sPreselectableCountries == 'fj'}]selected="selected"[{/if}]>[{oxmultilang ident="SHOP_MODULE_sPreselectableCountries_fj"}]</option>
                        <option value="fi" [{if $cstrs.sPreselectableCountries == 'fi'}]selected="selected"[{/if}]>[{oxmultilang ident="SHOP_MODULE_sPreselectableCountries_fi"}]</option>
                        <option value="fr" [{if $cstrs.sPreselectableCountries == 'fr'}]selected="selected"[{/if}]>[{oxmultilang ident="SHOP_MODULE_sPreselectableCountries_fr"}]</option>
                        <option value="gf" [{if $cstrs.sPreselectableCountries == 'gf'}]selected="selected"[{/if}]>[{oxmultilang ident="SHOP_MODULE_sPreselectableCountries_gf"}]</option>
                        <option value="pf" [{if $cstrs.sPreselectableCountries == 'pf'}]selected="selected"[{/if}]>[{oxmultilang ident="SHOP_MODULE_sPreselectableCountries_pf"}]</option>
                        <option value="tf" [{if $cstrs.sPreselectableCountries == 'tf'}]selected="selected"[{/if}]>[{oxmultilang ident="SHOP_MODULE_sPreselectableCountries_tf"}]</option>
                        <option value="ga" [{if $cstrs.sPreselectableCountries == 'ga'}]selected="selected"[{/if}]>[{oxmultilang ident="SHOP_MODULE_sPreselectableCountries_ga"}]</option>
                        <option value="gm" [{if $cstrs.sPreselectableCountries == 'gm'}]selected="selected"[{/if}]>[{oxmultilang ident="SHOP_MODULE_sPreselectableCountries_gm"}]</option>
                        <option value="ge" [{if $cstrs.sPreselectableCountries == 'ge'}]selected="selected"[{/if}]>[{oxmultilang ident="SHOP_MODULE_sPreselectableCountries_ge"}]</option>
                        <option value="gh" [{if $cstrs.sPreselectableCountries == 'gh'}]selected="selected"[{/if}]>[{oxmultilang ident="SHOP_MODULE_sPreselectableCountries_gh"}]</option>
                        <option value="gi" [{if $cstrs.sPreselectableCountries == 'gi'}]selected="selected"[{/if}]>[{oxmultilang ident="SHOP_MODULE_sPreselectableCountries_gi"}]</option>
                        <option value="gr" [{if $cstrs.sPreselectableCountries == 'gr'}]selected="selected"[{/if}]>[{oxmultilang ident="SHOP_MODULE_sPreselectableCountries_gr"}]</option>
                        <option value="gl" [{if $cstrs.sPreselectableCountries == 'gl'}]selected="selected"[{/if}]>[{oxmultilang ident="SHOP_MODULE_sPreselectableCountries_gl"}]</option>
                        <option value="gd" [{if $cstrs.sPreselectableCountries == 'gd'}]selected="selected"[{/if}]>[{oxmultilang ident="SHOP_MODULE_sPreselectableCountries_gd"}]</option>
                        <option value="gp" [{if $cstrs.sPreselectableCountries == 'gp'}]selected="selected"[{/if}]>[{oxmultilang ident="SHOP_MODULE_sPreselectableCountries_gp"}]</option>
                        <option value="gu" [{if $cstrs.sPreselectableCountries == 'gu'}]selected="selected"[{/if}]>[{oxmultilang ident="SHOP_MODULE_sPreselectableCountries_gu"}]</option>
                        <option value="gt" [{if $cstrs.sPreselectableCountries == 'gt'}]selected="selected"[{/if}]>[{oxmultilang ident="SHOP_MODULE_sPreselectableCountries_gt"}]</option>
                        <option value="gg" [{if $cstrs.sPreselectableCountries == 'gg'}]selected="selected"[{/if}]>[{oxmultilang ident="SHOP_MODULE_sPreselectableCountries_gg"}]</option>
                        <option value="gn" [{if $cstrs.sPreselectableCountries == 'gn'}]selected="selected"[{/if}]>[{oxmultilang ident="SHOP_MODULE_sPreselectableCountries_gn"}]</option>
                        <option value="gw" [{if $cstrs.sPreselectableCountries == 'gw'}]selected="selected"[{/if}]>[{oxmultilang ident="SHOP_MODULE_sPreselectableCountries_gw"}]</option>
                        <option value="gy" [{if $cstrs.sPreselectableCountries == 'gy'}]selected="selected"[{/if}]>[{oxmultilang ident="SHOP_MODULE_sPreselectableCountries_gy"}]</option>
                        <option value="ht" [{if $cstrs.sPreselectableCountries == 'ht'}]selected="selected"[{/if}]>[{oxmultilang ident="SHOP_MODULE_sPreselectableCountries_ht"}]</option>
                        <option value="hm" [{if $cstrs.sPreselectableCountries == 'hm'}]selected="selected"[{/if}]>[{oxmultilang ident="SHOP_MODULE_sPreselectableCountries_hm"}]</option>
                        <option value="va" [{if $cstrs.sPreselectableCountries == 'va'}]selected="selected"[{/if}]>[{oxmultilang ident="SHOP_MODULE_sPreselectableCountries_va"}]</option>
                        <option value="hn" [{if $cstrs.sPreselectableCountries == 'hn'}]selected="selected"[{/if}]>[{oxmultilang ident="SHOP_MODULE_sPreselectableCountries_hn"}]</option>
                        <option value="hk" [{if $cstrs.sPreselectableCountries == 'hk'}]selected="selected"[{/if}]>[{oxmultilang ident="SHOP_MODULE_sPreselectableCountries_hk"}]</option>
                        <option value="hu" [{if $cstrs.sPreselectableCountries == 'hu'}]selected="selected"[{/if}]>[{oxmultilang ident="SHOP_MODULE_sPreselectableCountries_hu"}]</option>
                        <option value="is" [{if $cstrs.sPreselectableCountries == 'is'}]selected="selected"[{/if}]>[{oxmultilang ident="SHOP_MODULE_sPreselectableCountries_is"}]</option>
                        <option value="in" [{if $cstrs.sPreselectableCountries == 'in'}]selected="selected"[{/if}]>[{oxmultilang ident="SHOP_MODULE_sPreselectableCountries_in"}]</option>
                        <option value="id" [{if $cstrs.sPreselectableCountries == 'id'}]selected="selected"[{/if}]>[{oxmultilang ident="SHOP_MODULE_sPreselectableCountries_id"}]</option>
                        <option value="ir" [{if $cstrs.sPreselectableCountries == 'ir'}]selected="selected"[{/if}]>[{oxmultilang ident="SHOP_MODULE_sPreselectableCountries_ir"}]</option>
                        <option value="iq" [{if $cstrs.sPreselectableCountries == 'iq'}]selected="selected"[{/if}]>[{oxmultilang ident="SHOP_MODULE_sPreselectableCountries_iq"}]</option>
                        <option value="ie" [{if $cstrs.sPreselectableCountries == 'ie'}]selected="selected"[{/if}]>[{oxmultilang ident="SHOP_MODULE_sPreselectableCountries_ie"}]</option>
                        <option value="im" [{if $cstrs.sPreselectableCountries == 'im'}]selected="selected"[{/if}]>[{oxmultilang ident="SHOP_MODULE_sPreselectableCountries_im"}]</option>
                        <option value="il" [{if $cstrs.sPreselectableCountries == 'il'}]selected="selected"[{/if}]>[{oxmultilang ident="SHOP_MODULE_sPreselectableCountries_il"}]</option>
                        <option value="it" [{if $cstrs.sPreselectableCountries == 'it'}]selected="selected"[{/if}]>[{oxmultilang ident="SHOP_MODULE_sPreselectableCountries_it"}]</option>
                        <option value="jm" [{if $cstrs.sPreselectableCountries == 'jm'}]selected="selected"[{/if}]>[{oxmultilang ident="SHOP_MODULE_sPreselectableCountries_jm"}]</option>
                        <option value="jp" [{if $cstrs.sPreselectableCountries == 'jp'}]selected="selected"[{/if}]>[{oxmultilang ident="SHOP_MODULE_sPreselectableCountries_jp"}]</option>
                        <option value="je" [{if $cstrs.sPreselectableCountries == 'je'}]selected="selected"[{/if}]>[{oxmultilang ident="SHOP_MODULE_sPreselectableCountries_je"}]</option>
                        <option value="jo" [{if $cstrs.sPreselectableCountries == 'jo'}]selected="selected"[{/if}]>[{oxmultilang ident="SHOP_MODULE_sPreselectableCountries_jo"}]</option>
                        <option value="kz" [{if $cstrs.sPreselectableCountries == 'kz'}]selected="selected"[{/if}]>[{oxmultilang ident="SHOP_MODULE_sPreselectableCountries_kz"}]</option>
                        <option value="ke" [{if $cstrs.sPreselectableCountries == 'ke'}]selected="selected"[{/if}]>[{oxmultilang ident="SHOP_MODULE_sPreselectableCountries_ke"}]</option>
                        <option value="ki" [{if $cstrs.sPreselectableCountries == 'ki'}]selected="selected"[{/if}]>[{oxmultilang ident="SHOP_MODULE_sPreselectableCountries_ki"}]</option>
                        <option value="kp" [{if $cstrs.sPreselectableCountries == 'kp'}]selected="selected"[{/if}]>[{oxmultilang ident="SHOP_MODULE_sPreselectableCountries_kp"}]</option>
                        <option value="kr" [{if $cstrs.sPreselectableCountries == 'kr'}]selected="selected"[{/if}]>[{oxmultilang ident="SHOP_MODULE_sPreselectableCountries_kr"}]</option>
                        <option value="kw" [{if $cstrs.sPreselectableCountries == 'kw'}]selected="selected"[{/if}]>[{oxmultilang ident="SHOP_MODULE_sPreselectableCountries_kw"}]</option>
                        <option value="kg" [{if $cstrs.sPreselectableCountries == 'kg'}]selected="selected"[{/if}]>[{oxmultilang ident="SHOP_MODULE_sPreselectableCountries_kg"}]</option>
                        <option value="la" [{if $cstrs.sPreselectableCountries == 'la'}]selected="selected"[{/if}]>[{oxmultilang ident="SHOP_MODULE_sPreselectableCountries_la"}]</option>
                        <option value="lv" [{if $cstrs.sPreselectableCountries == 'lv'}]selected="selected"[{/if}]>[{oxmultilang ident="SHOP_MODULE_sPreselectableCountries_lv"}]</option>
                        <option value="lb" [{if $cstrs.sPreselectableCountries == 'lb'}]selected="selected"[{/if}]>[{oxmultilang ident="SHOP_MODULE_sPreselectableCountries_lb"}]</option>
                        <option value="ls" [{if $cstrs.sPreselectableCountries == 'ls'}]selected="selected"[{/if}]>[{oxmultilang ident="SHOP_MODULE_sPreselectableCountries_ls"}]</option>
                        <option value="lr" [{if $cstrs.sPreselectableCountries == 'lr'}]selected="selected"[{/if}]>[{oxmultilang ident="SHOP_MODULE_sPreselectableCountries_lr"}]</option>
                        <option value="ly" [{if $cstrs.sPreselectableCountries == 'ly'}]selected="selected"[{/if}]>[{oxmultilang ident="SHOP_MODULE_sPreselectableCountries_ly"}]</option>
                        <option value="li" [{if $cstrs.sPreselectableCountries == 'li'}]selected="selected"[{/if}]>[{oxmultilang ident="SHOP_MODULE_sPreselectableCountries_li"}]</option>
                        <option value="lt" [{if $cstrs.sPreselectableCountries == 'lt'}]selected="selected"[{/if}]>[{oxmultilang ident="SHOP_MODULE_sPreselectableCountries_lt"}]</option>
                        <option value="lu" [{if $cstrs.sPreselectableCountries == 'lu'}]selected="selected"[{/if}]>[{oxmultilang ident="SHOP_MODULE_sPreselectableCountries_lu"}]</option>
                        <option value="mo" [{if $cstrs.sPreselectableCountries == 'mo'}]selected="selected"[{/if}]>[{oxmultilang ident="SHOP_MODULE_sPreselectableCountries_mo"}]</option>
                        <option value="mg" [{if $cstrs.sPreselectableCountries == 'mg'}]selected="selected"[{/if}]>[{oxmultilang ident="SHOP_MODULE_sPreselectableCountries_mg"}]</option>
                        <option value="mw" [{if $cstrs.sPreselectableCountries == 'mw'}]selected="selected"[{/if}]>[{oxmultilang ident="SHOP_MODULE_sPreselectableCountries_mw"}]</option>
                        <option value="my" [{if $cstrs.sPreselectableCountries == 'my'}]selected="selected"[{/if}]>[{oxmultilang ident="SHOP_MODULE_sPreselectableCountries_my"}]</option>
                        <option value="mv" [{if $cstrs.sPreselectableCountries == 'mv'}]selected="selected"[{/if}]>[{oxmultilang ident="SHOP_MODULE_sPreselectableCountries_mv"}]</option>
                        <option value="ml" [{if $cstrs.sPreselectableCountries == 'ml'}]selected="selected"[{/if}]>[{oxmultilang ident="SHOP_MODULE_sPreselectableCountries_ml"}]</option>
                        <option value="mt" [{if $cstrs.sPreselectableCountries == 'mt'}]selected="selected"[{/if}]>[{oxmultilang ident="SHOP_MODULE_sPreselectableCountries_mt"}]</option>
                        <option value="mh" [{if $cstrs.sPreselectableCountries == 'mh'}]selected="selected"[{/if}]>[{oxmultilang ident="SHOP_MODULE_sPreselectableCountries_mh"}]</option>
                        <option value="mq" [{if $cstrs.sPreselectableCountries == 'mq'}]selected="selected"[{/if}]>[{oxmultilang ident="SHOP_MODULE_sPreselectableCountries_mq"}]</option>
                        <option value="mr" [{if $cstrs.sPreselectableCountries == 'mr'}]selected="selected"[{/if}]>[{oxmultilang ident="SHOP_MODULE_sPreselectableCountries_mr"}]</option>
                        <option value="mu" [{if $cstrs.sPreselectableCountries == 'mu'}]selected="selected"[{/if}]>[{oxmultilang ident="SHOP_MODULE_sPreselectableCountries_mu"}]</option>
                        <option value="yt" [{if $cstrs.sPreselectableCountries == 'yt'}]selected="selected"[{/if}]>[{oxmultilang ident="SHOP_MODULE_sPreselectableCountries_yt"}]</option>
                        <option value="mx" [{if $cstrs.sPreselectableCountries == 'mx'}]selected="selected"[{/if}]>[{oxmultilang ident="SHOP_MODULE_sPreselectableCountries_mx"}]</option>
                        <option value="fm" [{if $cstrs.sPreselectableCountries == 'fm'}]selected="selected"[{/if}]>[{oxmultilang ident="SHOP_MODULE_sPreselectableCountries_fm"}]</option>
                        <option value="md" [{if $cstrs.sPreselectableCountries == 'md'}]selected="selected"[{/if}]>[{oxmultilang ident="SHOP_MODULE_sPreselectableCountries_md"}]</option>
                        <option value="mc" [{if $cstrs.sPreselectableCountries == 'mc'}]selected="selected"[{/if}]>[{oxmultilang ident="SHOP_MODULE_sPreselectableCountries_mc"}]</option>
                        <option value="mn" [{if $cstrs.sPreselectableCountries == 'mn'}]selected="selected"[{/if}]>[{oxmultilang ident="SHOP_MODULE_sPreselectableCountries_mn"}]</option>
                        <option value="me" [{if $cstrs.sPreselectableCountries == 'me'}]selected="selected"[{/if}]>[{oxmultilang ident="SHOP_MODULE_sPreselectableCountries_me"}]</option>
                        <option value="ms" [{if $cstrs.sPreselectableCountries == 'ms'}]selected="selected"[{/if}]>[{oxmultilang ident="SHOP_MODULE_sPreselectableCountries_ms"}]</option>
                        <option value="ma" [{if $cstrs.sPreselectableCountries == 'ma'}]selected="selected"[{/if}]>[{oxmultilang ident="SHOP_MODULE_sPreselectableCountries_ma"}]</option>
                        <option value="mz" [{if $cstrs.sPreselectableCountries == 'mz'}]selected="selected"[{/if}]>[{oxmultilang ident="SHOP_MODULE_sPreselectableCountries_mz"}]</option>
                        <option value="mm" [{if $cstrs.sPreselectableCountries == 'mm'}]selected="selected"[{/if}]>[{oxmultilang ident="SHOP_MODULE_sPreselectableCountries_mm"}]</option>
                        <option value="na" [{if $cstrs.sPreselectableCountries == 'na'}]selected="selected"[{/if}]>[{oxmultilang ident="SHOP_MODULE_sPreselectableCountries_na"}]</option>
                        <option value="nr" [{if $cstrs.sPreselectableCountries == 'nr'}]selected="selected"[{/if}]>[{oxmultilang ident="SHOP_MODULE_sPreselectableCountries_nr"}]</option>
                        <option value="np" [{if $cstrs.sPreselectableCountries == 'np'}]selected="selected"[{/if}]>[{oxmultilang ident="SHOP_MODULE_sPreselectableCountries_np"}]</option>
                        <option value="nl" [{if $cstrs.sPreselectableCountries == 'nl'}]selected="selected"[{/if}]>[{oxmultilang ident="SHOP_MODULE_sPreselectableCountries_nl"}]</option>
                        <option value="nc" [{if $cstrs.sPreselectableCountries == 'nc'}]selected="selected"[{/if}]>[{oxmultilang ident="SHOP_MODULE_sPreselectableCountries_nc"}]</option>
                        <option value="nz" [{if $cstrs.sPreselectableCountries == 'nz'}]selected="selected"[{/if}]>[{oxmultilang ident="SHOP_MODULE_sPreselectableCountries_nz"}]</option>
                        <option value="ni" [{if $cstrs.sPreselectableCountries == 'ni'}]selected="selected"[{/if}]>[{oxmultilang ident="SHOP_MODULE_sPreselectableCountries_ni"}]</option>
                        <option value="ne" [{if $cstrs.sPreselectableCountries == 'ne'}]selected="selected"[{/if}]>[{oxmultilang ident="SHOP_MODULE_sPreselectableCountries_ne"}]</option>
                        <option value="ng" [{if $cstrs.sPreselectableCountries == 'ng'}]selected="selected"[{/if}]>[{oxmultilang ident="SHOP_MODULE_sPreselectableCountries_ng"}]</option>
                        <option value="nu" [{if $cstrs.sPreselectableCountries == 'nu'}]selected="selected"[{/if}]>[{oxmultilang ident="SHOP_MODULE_sPreselectableCountries_nu"}]</option>
                        <option value="nf" [{if $cstrs.sPreselectableCountries == 'nf'}]selected="selected"[{/if}]>[{oxmultilang ident="SHOP_MODULE_sPreselectableCountries_nf"}]</option>
                        <option value="mk" [{if $cstrs.sPreselectableCountries == 'mk'}]selected="selected"[{/if}]>[{oxmultilang ident="SHOP_MODULE_sPreselectableCountries_mk"}]</option>
                        <option value="mp" [{if $cstrs.sPreselectableCountries == 'mp'}]selected="selected"[{/if}]>[{oxmultilang ident="SHOP_MODULE_sPreselectableCountries_mp"}]</option>
                        <option value="no" [{if $cstrs.sPreselectableCountries == 'no'}]selected="selected"[{/if}]>[{oxmultilang ident="SHOP_MODULE_sPreselectableCountries_no"}]</option>
                        <option value="om" [{if $cstrs.sPreselectableCountries == 'om'}]selected="selected"[{/if}]>[{oxmultilang ident="SHOP_MODULE_sPreselectableCountries_om"}]</option>
                        <option value="pk" [{if $cstrs.sPreselectableCountries == 'pk'}]selected="selected"[{/if}]>[{oxmultilang ident="SHOP_MODULE_sPreselectableCountries_pk"}]</option>
                        <option value="pw" [{if $cstrs.sPreselectableCountries == 'pw'}]selected="selected"[{/if}]>[{oxmultilang ident="SHOP_MODULE_sPreselectableCountries_pw"}]</option>
                        <option value="ps" [{if $cstrs.sPreselectableCountries == 'ps'}]selected="selected"[{/if}]>[{oxmultilang ident="SHOP_MODULE_sPreselectableCountries_ps"}]</option>
                        <option value="pa" [{if $cstrs.sPreselectableCountries == 'pa'}]selected="selected"[{/if}]>[{oxmultilang ident="SHOP_MODULE_sPreselectableCountries_pa"}]</option>
                        <option value="pg" [{if $cstrs.sPreselectableCountries == 'pg'}]selected="selected"[{/if}]>[{oxmultilang ident="SHOP_MODULE_sPreselectableCountries_pg"}]</option>
                        <option value="py" [{if $cstrs.sPreselectableCountries == 'py'}]selected="selected"[{/if}]>[{oxmultilang ident="SHOP_MODULE_sPreselectableCountries_py"}]</option>
                        <option value="pe" [{if $cstrs.sPreselectableCountries == 'pe'}]selected="selected"[{/if}]>[{oxmultilang ident="SHOP_MODULE_sPreselectableCountries_pe"}]</option>
                        <option value="ph" [{if $cstrs.sPreselectableCountries == 'ph'}]selected="selected"[{/if}]>[{oxmultilang ident="SHOP_MODULE_sPreselectableCountries_ph"}]</option>
                        <option value="pn" [{if $cstrs.sPreselectableCountries == 'pn'}]selected="selected"[{/if}]>[{oxmultilang ident="SHOP_MODULE_sPreselectableCountries_pn"}]</option>
                        <option value="pl" [{if $cstrs.sPreselectableCountries == 'pl'}]selected="selected"[{/if}]>[{oxmultilang ident="SHOP_MODULE_sPreselectableCountries_pl"}]</option>
                        <option value="pt" [{if $cstrs.sPreselectableCountries == 'pt'}]selected="selected"[{/if}]>[{oxmultilang ident="SHOP_MODULE_sPreselectableCountries_pt"}]</option>
                        <option value="pr" [{if $cstrs.sPreselectableCountries == 'pr'}]selected="selected"[{/if}]>[{oxmultilang ident="SHOP_MODULE_sPreselectableCountries_pr"}]</option>
                        <option value="qa" [{if $cstrs.sPreselectableCountries == 'qa'}]selected="selected"[{/if}]>[{oxmultilang ident="SHOP_MODULE_sPreselectableCountries_qa"}]</option>
                        <option value="re" [{if $cstrs.sPreselectableCountries == 're'}]selected="selected"[{/if}]>[{oxmultilang ident="SHOP_MODULE_sPreselectableCountries_re"}]</option>
                        <option value="ro" [{if $cstrs.sPreselectableCountries == 'ro'}]selected="selected"[{/if}]>[{oxmultilang ident="SHOP_MODULE_sPreselectableCountries_ro"}]</option>
                        <option value="ru" [{if $cstrs.sPreselectableCountries == 'ru'}]selected="selected"[{/if}]>[{oxmultilang ident="SHOP_MODULE_sPreselectableCountries_ru"}]</option>
                        <option value="rw" [{if $cstrs.sPreselectableCountries == 'rw'}]selected="selected"[{/if}]>[{oxmultilang ident="SHOP_MODULE_sPreselectableCountries_rw"}]</option>
                        <option value="bl" [{if $cstrs.sPreselectableCountries == 'bl'}]selected="selected"[{/if}]>[{oxmultilang ident="SHOP_MODULE_sPreselectableCountries_bl"}]</option>
                        <option value="sh" [{if $cstrs.sPreselectableCountries == 'sh'}]selected="selected"[{/if}]>[{oxmultilang ident="SHOP_MODULE_sPreselectableCountries_sh"}]</option>
                        <option value="kn" [{if $cstrs.sPreselectableCountries == 'kn'}]selected="selected"[{/if}]>[{oxmultilang ident="SHOP_MODULE_sPreselectableCountries_kn"}]</option>
                        <option value="lc" [{if $cstrs.sPreselectableCountries == 'lc'}]selected="selected"[{/if}]>[{oxmultilang ident="SHOP_MODULE_sPreselectableCountries_lc"}]</option>
                        <option value="mf" [{if $cstrs.sPreselectableCountries == 'mf'}]selected="selected"[{/if}]>[{oxmultilang ident="SHOP_MODULE_sPreselectableCountries_mf"}]</option>
                        <option value="pm" [{if $cstrs.sPreselectableCountries == 'pm'}]selected="selected"[{/if}]>[{oxmultilang ident="SHOP_MODULE_sPreselectableCountries_pm"}]</option>
                        <option value="vc" [{if $cstrs.sPreselectableCountries == 'vc'}]selected="selected"[{/if}]>[{oxmultilang ident="SHOP_MODULE_sPreselectableCountries_vc"}]</option>
                        <option value="ws" [{if $cstrs.sPreselectableCountries == 'ws'}]selected="selected"[{/if}]>[{oxmultilang ident="SHOP_MODULE_sPreselectableCountries_ws"}]</option>
                        <option value="sm" [{if $cstrs.sPreselectableCountries == 'sm'}]selected="selected"[{/if}]>[{oxmultilang ident="SHOP_MODULE_sPreselectableCountries_sm"}]</option>
                        <option value="st" [{if $cstrs.sPreselectableCountries == 'st'}]selected="selected"[{/if}]>[{oxmultilang ident="SHOP_MODULE_sPreselectableCountries_st"}]</option>
                        <option value="sa" [{if $cstrs.sPreselectableCountries == 'sa'}]selected="selected"[{/if}]>[{oxmultilang ident="SHOP_MODULE_sPreselectableCountries_sa"}]</option>
                        <option value="sn" [{if $cstrs.sPreselectableCountries == 'sn'}]selected="selected"[{/if}]>[{oxmultilang ident="SHOP_MODULE_sPreselectableCountries_sn"}]</option>
                        <option value="rs" [{if $cstrs.sPreselectableCountries == 'rs'}]selected="selected"[{/if}]>[{oxmultilang ident="SHOP_MODULE_sPreselectableCountries_rs"}]</option>
                        <option value="sc" [{if $cstrs.sPreselectableCountries == 'sc'}]selected="selected"[{/if}]>[{oxmultilang ident="SHOP_MODULE_sPreselectableCountries_sc"}]</option>
                        <option value="sl" [{if $cstrs.sPreselectableCountries == 'sl'}]selected="selected"[{/if}]>[{oxmultilang ident="SHOP_MODULE_sPreselectableCountries_sl"}]</option>
                        <option value="sg" [{if $cstrs.sPreselectableCountries == 'sg'}]selected="selected"[{/if}]>[{oxmultilang ident="SHOP_MODULE_sPreselectableCountries_sg"}]</option>
                        <option value="sx" [{if $cstrs.sPreselectableCountries == 'sx'}]selected="selected"[{/if}]>[{oxmultilang ident="SHOP_MODULE_sPreselectableCountries_sx"}]</option>
                        <option value="sk" [{if $cstrs.sPreselectableCountries == 'sk'}]selected="selected"[{/if}]>[{oxmultilang ident="SHOP_MODULE_sPreselectableCountries_sk"}]</option>
                        <option value="si" [{if $cstrs.sPreselectableCountries == 'si'}]selected="selected"[{/if}]>[{oxmultilang ident="SHOP_MODULE_sPreselectableCountries_si"}]</option>
                        <option value="sb" [{if $cstrs.sPreselectableCountries == 'sb'}]selected="selected"[{/if}]>[{oxmultilang ident="SHOP_MODULE_sPreselectableCountries_sb"}]</option>
                        <option value="so" [{if $cstrs.sPreselectableCountries == 'so'}]selected="selected"[{/if}]>[{oxmultilang ident="SHOP_MODULE_sPreselectableCountries_so"}]</option>
                        <option value="za" [{if $cstrs.sPreselectableCountries == 'za'}]selected="selected"[{/if}]>[{oxmultilang ident="SHOP_MODULE_sPreselectableCountries_za"}]</option>
                        <option value="gs" [{if $cstrs.sPreselectableCountries == 'gs'}]selected="selected"[{/if}]>[{oxmultilang ident="SHOP_MODULE_sPreselectableCountries_gs"}]</option>
                        <option value="ss" [{if $cstrs.sPreselectableCountries == 'ss'}]selected="selected"[{/if}]>[{oxmultilang ident="SHOP_MODULE_sPreselectableCountries_ss"}]</option>
                        <option value="es" [{if $cstrs.sPreselectableCountries == 'es'}]selected="selected"[{/if}]>[{oxmultilang ident="SHOP_MODULE_sPreselectableCountries_es"}]</option>
                        <option value="lk" [{if $cstrs.sPreselectableCountries == 'lk'}]selected="selected"[{/if}]>[{oxmultilang ident="SHOP_MODULE_sPreselectableCountries_lk"}]</option>
                        <option value="sd" [{if $cstrs.sPreselectableCountries == 'sd'}]selected="selected"[{/if}]>[{oxmultilang ident="SHOP_MODULE_sPreselectableCountries_sd"}]</option>
                        <option value="sr" [{if $cstrs.sPreselectableCountries == 'sr'}]selected="selected"[{/if}]>[{oxmultilang ident="SHOP_MODULE_sPreselectableCountries_sr"}]</option>
                        <option value="sj" [{if $cstrs.sPreselectableCountries == 'sj'}]selected="selected"[{/if}]>[{oxmultilang ident="SHOP_MODULE_sPreselectableCountries_sj"}]</option>
                        <option value="se" [{if $cstrs.sPreselectableCountries == 'se'}]selected="selected"[{/if}]>[{oxmultilang ident="SHOP_MODULE_sPreselectableCountries_se"}]</option>
                        <option value="ch" [{if $cstrs.sPreselectableCountries == 'ch'}]selected="selected"[{/if}]>[{oxmultilang ident="SHOP_MODULE_sPreselectableCountries_ch"}]</option>
                        <option value="sy" [{if $cstrs.sPreselectableCountries == 'sy'}]selected="selected"[{/if}]>[{oxmultilang ident="SHOP_MODULE_sPreselectableCountries_sy"}]</option>
                        <option value="tw" [{if $cstrs.sPreselectableCountries == 'tw'}]selected="selected"[{/if}]>[{oxmultilang ident="SHOP_MODULE_sPreselectableCountries_tw"}]</option>
                        <option value="tj" [{if $cstrs.sPreselectableCountries == 'tj'}]selected="selected"[{/if}]>[{oxmultilang ident="SHOP_MODULE_sPreselectableCountries_tj"}]</option>
                        <option value="tz" [{if $cstrs.sPreselectableCountries == 'tz'}]selected="selected"[{/if}]>[{oxmultilang ident="SHOP_MODULE_sPreselectableCountries_tz"}]</option>
                        <option value="th" [{if $cstrs.sPreselectableCountries == 'th'}]selected="selected"[{/if}]>[{oxmultilang ident="SHOP_MODULE_sPreselectableCountries_th"}]</option>
                        <option value="tl" [{if $cstrs.sPreselectableCountries == 'tl'}]selected="selected"[{/if}]>[{oxmultilang ident="SHOP_MODULE_sPreselectableCountries_tl"}]</option>
                        <option value="tg" [{if $cstrs.sPreselectableCountries == 'tg'}]selected="selected"[{/if}]>[{oxmultilang ident="SHOP_MODULE_sPreselectableCountries_tg"}]</option>
                        <option value="tk" [{if $cstrs.sPreselectableCountries == 'tk'}]selected="selected"[{/if}]>[{oxmultilang ident="SHOP_MODULE_sPreselectableCountries_tk"}]</option>
                        <option value="to" [{if $cstrs.sPreselectableCountries == 'to'}]selected="selected"[{/if}]>[{oxmultilang ident="SHOP_MODULE_sPreselectableCountries_to"}]</option>
                        <option value="tt" [{if $cstrs.sPreselectableCountries == 'tt'}]selected="selected"[{/if}]>[{oxmultilang ident="SHOP_MODULE_sPreselectableCountries_tt"}]</option>
                        <option value="tn" [{if $cstrs.sPreselectableCountries == 'tn'}]selected="selected"[{/if}]>[{oxmultilang ident="SHOP_MODULE_sPreselectableCountries_tn"}]</option>
                        <option value="tr" [{if $cstrs.sPreselectableCountries == 'tr'}]selected="selected"[{/if}]>[{oxmultilang ident="SHOP_MODULE_sPreselectableCountries_tr"}]</option>
                        <option value="tm" [{if $cstrs.sPreselectableCountries == 'tm'}]selected="selected"[{/if}]>[{oxmultilang ident="SHOP_MODULE_sPreselectableCountries_tm"}]</option>
                        <option value="tc" [{if $cstrs.sPreselectableCountries == 'tc'}]selected="selected"[{/if}]>[{oxmultilang ident="SHOP_MODULE_sPreselectableCountries_tc"}]</option>
                        <option value="tv" [{if $cstrs.sPreselectableCountries == 'tv'}]selected="selected"[{/if}]>[{oxmultilang ident="SHOP_MODULE_sPreselectableCountries_tv"}]</option>
                        <option value="ug" [{if $cstrs.sPreselectableCountries == 'ug'}]selected="selected"[{/if}]>[{oxmultilang ident="SHOP_MODULE_sPreselectableCountries_ug"}]</option>
                        <option value="ua" [{if $cstrs.sPreselectableCountries == 'ua'}]selected="selected"[{/if}]>[{oxmultilang ident="SHOP_MODULE_sPreselectableCountries_ua"}]</option>
                        <option value="ae" [{if $cstrs.sPreselectableCountries == 'ae'}]selected="selected"[{/if}]>[{oxmultilang ident="SHOP_MODULE_sPreselectableCountries_ae"}]</option>
                        <option value="gb" [{if $cstrs.sPreselectableCountries == 'gb'}]selected="selected"[{/if}]>[{oxmultilang ident="SHOP_MODULE_sPreselectableCountries_gb"}]</option>
                        <option value="us" [{if $cstrs.sPreselectableCountries == 'us'}]selected="selected"[{/if}]>[{oxmultilang ident="SHOP_MODULE_sPreselectableCountries_us"}]</option>
                        <option value="um" [{if $cstrs.sPreselectableCountries == 'um'}]selected="selected"[{/if}]>[{oxmultilang ident="SHOP_MODULE_sPreselectableCountries_um"}]</option>
                        <option value="uy" [{if $cstrs.sPreselectableCountries == 'uy'}]selected="selected"[{/if}]>[{oxmultilang ident="SHOP_MODULE_sPreselectableCountries_uy"}]</option>
                        <option value="uz" [{if $cstrs.sPreselectableCountries == 'uz'}]selected="selected"[{/if}]>[{oxmultilang ident="SHOP_MODULE_sPreselectableCountries_uz"}]</option>
                        <option value="vu" [{if $cstrs.sPreselectableCountries == 'vu'}]selected="selected"[{/if}]>[{oxmultilang ident="SHOP_MODULE_sPreselectableCountries_vu"}]</option>
                        <option value="ve" [{if $cstrs.sPreselectableCountries == 've'}]selected="selected"[{/if}]>[{oxmultilang ident="SHOP_MODULE_sPreselectableCountries_ve"}]</option>
                        <option value="vn" [{if $cstrs.sPreselectableCountries == 'vn'}]selected="selected"[{/if}]>[{oxmultilang ident="SHOP_MODULE_sPreselectableCountries_vn"}]</option>
                        <option value="vg" [{if $cstrs.sPreselectableCountries == 'vg'}]selected="selected"[{/if}]>[{oxmultilang ident="SHOP_MODULE_sPreselectableCountries_vg"}]</option>
                        <option value="vi" [{if $cstrs.sPreselectableCountries == 'vi'}]selected="selected"[{/if}]>[{oxmultilang ident="SHOP_MODULE_sPreselectableCountries_vi"}]</option>
                        <option value="wf" [{if $cstrs.sPreselectableCountries == 'wf'}]selected="selected"[{/if}]>[{oxmultilang ident="SHOP_MODULE_sPreselectableCountries_wf"}]</option>
                        <option value="eh" [{if $cstrs.sPreselectableCountries == 'eh'}]selected="selected"[{/if}]>[{oxmultilang ident="SHOP_MODULE_sPreselectableCountries_eh"}]</option>
                        <option value="ye" [{if $cstrs.sPreselectableCountries == 'ye'}]selected="selected"[{/if}]>[{oxmultilang ident="SHOP_MODULE_sPreselectableCountries_ye"}]</option>
                        <option value="zm" [{if $cstrs.sPreselectableCountries == 'zm'}]selected="selected"[{/if}]>[{oxmultilang ident="SHOP_MODULE_sPreselectableCountries_zm"}]</option>
                        <option value="zw" [{if $cstrs.sPreselectableCountries == 'zw'}]selected="selected"[{/if}]>[{oxmultilang ident="SHOP_MODULE_sPreselectableCountries_zw"}]</option>
                    </select>
                    &nbsp;[{ oxinputhelp ident="HELP_SHOP_MODULE_sPreselectableCountries" }]
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
                    [{oxmultilang ident="SHOP_MODULE_sAMSResumeSubmit"}]
                </td>
                <td>
                    <input type="checkbox" class="editinput" name="cstrs[sAMSResumeSubmit]" value="true" [{if $cstrs.sAMSResumeSubmit == true}]checked="checked"[{/if}]>
                    &nbsp;[{ oxinputhelp ident="HELP_SHOP_MODULE_sAMSResumeSubmit" }]
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

            <tr>
                <td>
                    [{oxmultilang ident="SHOP_MODULE_bChangeFieldsOrder"}]
                </td>
                <td>
                    <input type="checkbox" class="editinput" name="cstrs[bChangeFieldsOrder]" value="true" [{if $cstrs.bChangeFieldsOrder == true}]checked="checked"[{/if}]>
                    &nbsp;[{ oxinputhelp ident="HELP_SHOP_MODULE_bChangeFieldsOrder" }]
                </td>
            </tr>

            <tr>
                <td>
                    [{oxmultilang ident="SHOP_MODULE_bAllowCloseModal"}]
                </td>
                <td>
                    <input type="checkbox" class="editinput" name="cstrs[bAllowCloseModal]" value="true" [{if $cstrs.bAllowCloseModal == true}]checked="checked"[{/if}]>
                    &nbsp;[{ oxinputhelp ident="HELP_SHOP_MODULE_bAllowCloseModal" }]
                </td>
            </tr>

            <tr>
                <td>
                    [{oxmultilang ident="SHOP_MODULE_bConfirmWithCheckbox"}]
                </td>
                <td>
                    <input type="checkbox" class="editinput" name="cstrs[bConfirmWithCheckbox]" value="true" [{if $cstrs.bConfirmWithCheckbox == true}]checked="checked"[{/if}]>
                    &nbsp;[{ oxinputhelp ident="HELP_SHOP_MODULE_bConfirmWithCheckbox" }]
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
            <tr>
                <td>
                    [{oxmultilang ident="SHOP_MODULE_bShowEmailserviceErrors"}]
                </td>
                <td>
                    <input type="checkbox" class="editinput" name="cstrs[bShowEmailserviceErrors]" value="true" [{if $cstrs.bShowEmailserviceErrors == true}]checked="checked"[{/if}]>
                    &nbsp;[{ oxinputhelp ident="HELP_SHOP_MODULE_bShowEmailserviceErrors" }]
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
            <tr>
                <td>
                    [{oxmultilang ident="SHOP_MODULE_bCorrectTranspositionedNames"}]
                </td>
                <td>
                    <input type="checkbox" class="editinput" name="cstrs[bCorrectTranspositionedNames]" value="true" [{if $cstrs.bCorrectTranspositionedNames == true}]checked="checked"[{/if}]>
                    &nbsp;[{ oxinputhelp ident="HELP_SHOP_MODULE_bCorrectTranspositionedNames" }]
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
                    <input type="text" class="editinput" size="60" maxlength="255" name="cstrs[sMainColor]" value="[{$cstrs.sMainColor}]">
                    &nbsp;[{ oxinputhelp ident="HELP_SHOP_MODULE_sMainColor" }]
                </td>
            </tr>
            <tr>
                <td>
                    [{oxmultilang ident="SHOP_MODULE_sErrorColor"}]
                </td>
                <td>
                    <input type="text" class="editinput" size="60" maxlength="255" name="cstrs[sErrorColor]" value="[{$cstrs.sErrorColor}]">
                    &nbsp;[{ oxinputhelp ident="HELP_SHOP_MODULE_sErrorColor" }]
                </td>
            </tr>
            <tr>
                <td>
                    [{oxmultilang ident="SHOP_MODULE_sSelectionColor"}]
                </td>
                <td>
                    <input type="text" class="editinput" size="60" maxlength="255" name="cstrs[sSelectionColor]" value="[{$cstrs.sSelectionColor}]">
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
                    [{oxmultilang ident="SHOP_MODULE_bAllowControllerFilter"}]
                </td>
                <td>
                    <input type="checkbox" class="editinput" name="cstrs[bAllowControllerFilter]" value="true" [{if $cstrs.bAllowControllerFilter == true}]checked="checked"[{/if}]>
                    &nbsp;[{ oxinputhelp ident="HELP_SHOP_MODULE_bAllowControllerFilter" }]
                </td>
            </tr>
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
                    [{oxmultilang ident="SHOP_MODULE_sAMSSubmitTrigger"}]
                </td>
                <td>
                    <input type="checkbox" class="editinput" name="cstrs[sAMSSubmitTrigger]" value="true" [{if $cstrs.sAMSSubmitTrigger == true}]checked="checked"[{/if}]>
                    &nbsp;[{ oxinputhelp ident="HELP_SHOP_MODULE_sAMSSubmitTrigger" }]
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
