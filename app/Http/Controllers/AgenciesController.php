<?php

namespace App\Http\Controllers;

use Inertia\Inertia;
use App\Models\Agency;
use Illuminate\Http\Request;
use App\Http\Requests\AgencyRequest;

class AgenciesController extends Controller
{
    /**
     * Agency instance holder
     *
     * @var \App\Models\Agency
     */
    private $agency;

    /**
     * Instantiate the agency holder.
     *
     * @param \App\Models\Agency  $agency
     */
    public function __construct(Agency $agency)
    {
        $this->agency = $agency;
    }

    /**
     * Display all the agencies.
     *
     * @return \Inertia\Response
     */
    public function index()
    {
        $agencies = $this->agency->orderBy('id', 'DESC')->get() ?? collect();

        return Inertia::render('Agencies/List', [
            'agencies' => $agencies,
        ]);
    }

    /**
     * Display the form to add a new agency.
     *
     * @return \Inertia\Response
     */
    public function create()
    {
        return Inertia::render('Agencies/Create');
    }

    /**
     * Create and store the new agency data.
     *
     * @param  \App\Http\Requests\AgencyRequest  $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(AgencyRequest $request)
    {
        $this->agency->create($request->all());

        return response()->json([
            'status' => 'success',
            'message' => 'Agency created sucessfully.',
        ], 201);
    }

    /**
     * Display the agency details of the given agency id.
     *
     * @param  integer  $id
     * @return void|\Inertia\Response
     */
    public function show($id)
    {
        $agency = $this->agency->find($id);
        if (! $agency) {
            abort(404);
        }

        return Inertia::render('Agencies/Show', [
            'agency' => $agency,
        ]);
    }

    /**
     * Display the agency details of the given agency id.
     *
     * @param  integer  $id
     * @return void|\Inertia\Response
     */
    public function edit($id)
    {
        $agency = $this->agency->find($id);
        if (! $agency) {
            abort(404);
        }

        return Inertia::render('Agencies/Edit', [
            'agency' => $agency,
        ]);
    }

    /**
     * Update the agency details of the given agency id.
     *
     * @param  integer  $id
     * @param  \App\Http\Requests\AgencyRequest  $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function update($id, AgencyRequest $request)
    {
        $agency = $this->agency->find($id);
        if (! $agency) {
            return response()->json([
                'status' => 'not_found',
                'message' => 'Agency not found',
            ], 404);
        }

        $agency->update($request->all());

        return response()->json([
            'status' => 'success',
            'message' => 'Agency updated successfully.',
        ], 201);
    }

    /**
     * Delete the agency details of the given agency id.
     *
     * @param  integer  $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function destroy($id)
    {
        $agency = $this->agency->find($id);
        if (! $agency) {
            return response()->json([
                'status' => 'not_found',
                'message' => 'Agency not found',
            ], 404);
        }

        $agency->delete();

        return response()->json([
            'status' => 'success',
            'message' => 'Agency deleted successfully. Redirecting...',
        ], 201);
    }
}
