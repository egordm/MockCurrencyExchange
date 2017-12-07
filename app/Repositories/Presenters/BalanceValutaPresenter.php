<?php

namespace App\Repositories\Presenters;

use App\Transformers\BalanceTransformer;
use App\Transformers\BalanceValutaTransformer;
use Prettus\Repository\Presenter\FractalPresenter;

/**
 * Class BalancePresenter
 *
 * @package namespace App\Repositories\Presenters;
 */
class BalanceValutaPresenter extends FractalRelationshipsPresenter
{
    /**
     * Transformer
     *
     * @return \League\Fractal\TransformerAbstract
     */
    public function getTransformer()
    {
        return new BalanceValutaTransformer();
    }
}
