<?php

namespace Endereco\Oxid6Client\Model\User;

class UserShippingAddressUpdatableFields extends UserShippingAddressUpdatableFields_parent
{

    public function getUpdatableFields()
    {
        $aReturn = parent::getUpdatableFields();
        $aReturn[] = 'MOJOAMSTS';
        $aReturn[] = 'MOJOAMSSTATUS';
        $aReturn[] = 'MOJOAMSPREDICTIONS';
        $aReturn[] = 'MOJONAMESCORE';

        return $aReturn;
    }
}
