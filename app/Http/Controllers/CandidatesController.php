<?php

namespace App\Http\Controllers;

use Inertia\Inertia;
use App\Models\Agency;
use App\Models\Candidate;
use Illuminate\Http\Request;
use App\Http\Requests\CandidateRequest;

class CandidatesController extends Controller
{
    /**
     * Candidate instance holder
     *
     * @var \App\Models\Candidate
     */
    private $candidate;

    /**
     * Instantiate the candidate holder.
     *
     * @param \App\Models\Candidate  $candidate
     */
    public function __construct(Candidate $candidate)
    {
        $this->candidate = $candidate;
    }

    /**
     * Display all the candidates.
     *
     * @return \Inertia\Response
     */
    public function index()
    {
        request()->validate([
            'field' => 'nullable|sometimes|in:id,name,contact_person',
            'direction' => 'nullable|sometimes|in:asc,desc',
        ]);

        $candidates = $this->candidate->query();

        $searchTerm = request('search') ?? null;
        if ($searchTerm != null || $searchTerm != "") {
            $candidates->where('name', 'LIKE', "%".$searchTerm."%")
                ->orWhere('email', 'LIKE', "%". $searchTerm ."%")
                ->orWhere('interview_by', 'LIKE', "%". $searchTerm ."%")
                ->orWhere('mobile', 'LIKE', "%". $searchTerm ."%");
        }

        $interviewDate = request('date') ?? null;
        if ($interviewDate != null || $interviewDate != "") {
            $candidates->whereDate('interview_scheduled_at', $interviewDate);
        }

        $field = request('field') ?? 'id';
        $direction = request('direction') ?? 'desc';
        $candidates = $candidates->orderBy($field, $direction)->paginate(10);

        return Inertia::render('Candidates/List', [
            'candidates' => $candidates->withQueryString(),
            'filters' => request()->only(['search', 'field', 'direction', 'date']),
        ]);
    }

    /**
     * Display the form to add a new candidate.
     *
     * @return \Inertia\Response
     */
    public function create()
    {
        $agencies = Agency::orderBy('id', 'DESC')->pluck('name', 'id');

        return Inertia::render('Candidates/Create', [
            'agencies' => $agencies,
        ]);
    }

    /**
     * Create and store the new candidate data.
     *
     * @param  \App\Http\Requests\CandidateRequest  $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(CandidateRequest $request)
    {
        $path = null;
        if ($request->cv_resume_file != null) {
            $path = $request->file('cv_resume_file')->store('cv_resume', 'public');
        }
        $request['cv_resume'] = $path;
        $request['is_selected'] = $request->is_selected == "true" ? 1 : 0;
        $this->candidate->create($request->all());

        return response()->json([
            'status' => 'success',
            'message' => 'Candidate created sucessfully. Redirecting...',
        ], 201);
    }

    /**
     * Display the candidate details of the given candidate id.
     *
     * @param  integer  $id
     * @return void|\Inertia\Response
     */
    public function show($id)
    {
        $candidate = $this->candidate->with('agency')->find($id);
        if (! $candidate) {
            abort(404);
        }

        $cvResumeFile = null;
        if ($candidate->cv_resume) {
            $cvResumeFile = \Illuminate\Support\Facades\Storage::url($candidate->cv_resume);
        }

        return Inertia::render('Candidates/Show', [
            'candidate' => $candidate,
            'cvResumeFile' => $cvResumeFile,
        ]);
    }

    /**
     * Display the candidate details of the given candidate id.
     *
     * @param  integer  $id
     * @return void|\Inertia\Response
     */
    public function edit($id)
    {
        $candidate = $this->candidate->find($id);
        if (! $candidate) {
            abort(404);
        }

        $agencies = Agency::orderBy('id', 'DESC')->pluck('name', 'id');

        return Inertia::render('Candidates/Edit', [
            'candidate' => $candidate,
            'agencies' => $agencies,
        ]);
    }

    /**
     * Update the candidate details of the given candidate id.
     *
     * @param  integer  $id
     * @param  \App\Http\Requests\CandidateRequest  $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function update($id, CandidateRequest $request)
    {
        $candidate = $this->candidate->find($id);
        if (! $candidate) {
            return response()->json([
                'status' => 'not_found',
                'message' => 'Candidate not found',
            ], 404);
        }

        $path = $candidate->cv_resume;
        if ($request->cv_resume_file != null) {
            \Illuminate\Support\Facades\Storage::disk('public')->delete($candidate->cv_resume);

            $path = $request->file('cv_resume_file')->store('cv_resume', 'public');
        }
        $request['cv_resume'] = $path;
        $request['is_selected'] = $request->is_selected == "true" ? 1 : 0;
        $candidate->update($request->all());

        return response()->json([
            'status' => 'success',
            'message' => 'Candidate updated successfully. Redirecting...',
        ], 201);
    }

    /**
     * Toggle the selection of the given candidate id.
     *
     * @param  integer  $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function toggleSelected($id)
    {
        $candidate = $this->candidate->find($id);
        if (! $candidate) {
            return response()->json([
                'status' => 'not_found',
                'message' => 'Candidate not found',
            ], 404);
        }

        $candidate->update(['is_selected' => ! $candidate->is_selected]);

        return response()->json([
            'status' => 'success',
            'message' => 'Candidate selection updated successfully.',
        ], 201);
    }

    /**
     * Delete the candidate details of the given candidate id.
     *
     * @param  integer  $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function destroy($id)
    {
        $candidate = $this->candidate->find($id);
        if (! $candidate) {
            return response()->json([
                'status' => 'not_found',
                'message' => 'Candidate not found',
            ], 404);
        }

        \Illuminate\Support\Facades\Storage::disk('public')->delete($candidate->cv_resume);
        $candidate->delete();

        return response()->json([
            'status' => 'success',
            'message' => 'Candidate deleted successfully. Redirecting...',
        ], 201);
    }
}
