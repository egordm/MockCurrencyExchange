<?php

namespace App\Repositories\Presenters;

use App\Transformers\ValutaPairTransformer;
use Prettus\Repository\Presenter\FractalPresenter;

/**
 * Class ValutaPairPresenter
 *
 * @package namespace App\Repositories\Presenters;
 */
class ValutaPairPresenter extends FractalRelationshipsPresenter
{
    /**
     * Transformer
     *
     * @return \League\Fractal\TransformerAbstract
     */
    public function getTransformer()
    {
        return new ValutaPairTransformer();
    }
}
