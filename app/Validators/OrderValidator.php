<?php

namespace App\Validators;

use \Prettus\Validator\Contracts\ValidatorInterface;
use \Prettus\Validator\LaravelValidator;

class OrderValidator extends LaravelValidator
{

    protected $rules = [
        ValidatorInterface::RULE_CREATE => [
            'user_id' => 'required|exists:users,id',
            'valuta_pair_id' => 'required|exists:valuta_pairs,id',
            'price' => 'required|numeric',
            'fee' => 'required|numeric',
            'quantity' => 'required|numeric',
            'buy' => 'required|boolean',
        ],
        ValidatorInterface::RULE_UPDATE => [],
   ];
}
