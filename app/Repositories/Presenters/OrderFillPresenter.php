<?php

namespace App\Repositories\Presenters;

use App\Transformers\OrderFillTransformer;
use Prettus\Repository\Presenter\FractalPresenter;

/**
 * Class OrderFillPresenter
 *
 * @package namespace App\Repositories\Presenters;
 */
class OrderFillPresenter extends FractalRelationshipsPresenter
{
    /**
     * Transformer
     *
     * @return \League\Fractal\TransformerAbstract
     */
    public function getTransformer()
    {
        return new OrderFillTransformer();
    }
}
