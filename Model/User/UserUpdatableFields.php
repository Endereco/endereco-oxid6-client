<?php
namespace Endereco\Oxid6Client\Model\User;

class UserUpdatableFields extends UserUpdatableFields_parent
{

    public function getUpdatableFields()
    {
        $aReturn = parent::getUpdatableFields();
        $aReturn[] = 'MOJOAMSTS';
        $aReturn[] = 'MOJOAMSSTATUS';

        return $aReturn;
    }
}
