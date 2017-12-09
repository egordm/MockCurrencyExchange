<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use Prettus\Validator\Contracts\ValidatorInterface;
use Prettus\Validator\Exceptions\ValidatorException;
use App\Http\Requests\OrderFillCreateRequest;
use App\Http\Requests\OrderFillUpdateRequest;
use App\Repositories\OrderFillRepository;
use App\Validators\OrderFillValidator;


class OrderFillsController extends Controller
{

    /**
     * @var OrderFillRepository
     */
    protected $repository;

    /**
     * @var OrderFillValidator
     */
    protected $validator;

    public function __construct(OrderFillRepository $repository, OrderFillValidator $validator)
    {
        $this->repository = $repository;
        $this->validator  = $validator;
    }


    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $this->repository->pushCriteria(app('Prettus\Repository\Criteria\RequestCriteria'));
        $orderFills = $this->repository->all();

        if (request()->wantsJson()) {

            return response()->json([
                'data' => $orderFills,
            ]);
        }

        return view('orderFills.index', compact('orderFills'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  OrderFillCreateRequest $request
     *
     * @return \Illuminate\Http\Response
     */
    public function store(OrderFillCreateRequest $request)
    {

        try {

            $this->validator->with($request->all())->passesOrFail(ValidatorInterface::RULE_CREATE);

            $orderFill = $this->repository->create($request->all());

            $response = [
                'message' => 'OrderFill created.',
                'data'    => $orderFill->toArray(),
            ];

            if ($request->wantsJson()) {

                return response()->json($response);
            }

            return redirect()->back()->with('message', $response['message']);
        } catch (ValidatorException $e) {
            if ($request->wantsJson()) {
                return response()->json([
                    'error'   => true,
                    'message' => $e->getMessageBag()
                ]);
            }

            return redirect()->back()->withErrors($e->getMessageBag())->withInput();
        }
    }


    /**
     * Display the specified resource.
     *
     * @param  int $id
     *
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $orderFill = $this->repository->find($id);

        if (request()->wantsJson()) {

            return response()->json([
                'data' => $orderFill,
            ]);
        }

        return view('orderFills.show', compact('orderFill'));
    }


    /**
     * Show the form for editing the specified resource.
     *
     * @param  int $id
     *
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {

        $orderFill = $this->repository->find($id);

        return view('orderFills.edit', compact('orderFill'));
    }


    /**
     * Update the specified resource in storage.
     *
     * @param  OrderFillUpdateRequest $request
     * @param  string            $id
     *
     * @return Response
     */
    public function update(OrderFillUpdateRequest $request, $id)
    {

        try {

            $this->validator->with($request->all())->passesOrFail(ValidatorInterface::RULE_UPDATE);

            $orderFill = $this->repository->update($request->all(), $id);

            $response = [
                'message' => 'OrderFill updated.',
                'data'    => $orderFill->toArray(),
            ];

            if ($request->wantsJson()) {

                return response()->json($response);
            }

            return redirect()->back()->with('message', $response['message']);
        } catch (ValidatorException $e) {

            if ($request->wantsJson()) {

                return response()->json([
                    'error'   => true,
                    'message' => $e->getMessageBag()
                ]);
            }

            return redirect()->back()->withErrors($e->getMessageBag())->withInput();
        }
    }


    /**
     * Remove the specified resource from storage.
     *
     * @param  int $id
     *
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $deleted = $this->repository->delete($id);

        if (request()->wantsJson()) {

            return response()->json([
                'message' => 'OrderFill deleted.',
                'deleted' => $deleted,
            ]);
        }

        return redirect()->back()->with('message', 'OrderFill deleted.');
    }
}
