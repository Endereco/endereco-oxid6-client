[{$smarty.block.parent}]
[{if $oView->getClassName() != 'oxUBase'}]
    [{oxid_include_widget cl="enderecoconfig" curClass=$oView->getClassName()}]
[{/if}]

