<?php

namespace App\Repositories\Presenters;

use App\Transformers\BalanceTransformer;
use Prettus\Repository\Presenter\FractalPresenter;

/**
 * Class BalancePresenter
 *
 * @package namespace App\Repositories\Presenters;
 */
class BalancePresenter extends FractalPresenter
{
    /**
     * Transformer
     *
     * @return \League\Fractal\TransformerAbstract
     */
    public function getTransformer()
    {
        return new BalanceTransformer();
    }
}
