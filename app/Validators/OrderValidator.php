<?php

namespace App\Validators;

use \Prettus\Validator\Contracts\ValidatorInterface;
use \Prettus\Validator\LaravelValidator;

class OrderValidator extends LaravelValidator
{

    protected $rules = [
        ValidatorInterface::RULE_CREATE => [
            'valuta_pair_id' => 'required|exists:valuta_pairs,id',
            'price' => 'required|numeric',
            'quantity' => 'required|numeric',
            'buy' => 'required|boolean',
            'type' => 'required|integer|between:0,1',
        ],
        ValidatorInterface::RULE_UPDATE => [],
   ];
}
