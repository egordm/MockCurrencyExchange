<?php

namespace App\Repositories\Presenters;

use App\Transformers\ValutaTransformer;
use Prettus\Repository\Presenter\FractalPresenter;

/**
 * Class ValutaPresenter
 *
 * @package namespace App\Repositories\Presenters;
 */
class ValutaPresenter extends FractalRelationshipsPresenter
{
    /**
     * Transformer
     *
     * @return \League\Fractal\TransformerAbstract
     */
    public function getTransformer()
    {
        return new ValutaTransformer();
    }
}
