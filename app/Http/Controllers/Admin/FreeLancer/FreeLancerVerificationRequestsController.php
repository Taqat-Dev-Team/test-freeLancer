<?php

namespace App\Http\Controllers\Admin\FreeLancer;

use App\Http\Controllers\Controller;
use App\Mail\VerificationAccepted;
use App\Mail\VerificationRejected;
use App\Models\Badge;
use App\Models\Contact;
use App\Models\Freelancer;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use Yajra\DataTables\DataTables;


class FreeLancerVerificationRequestsController extends Controller
{

    public function index()
    {
        return view('admin.FreeLancer.VerificationRequests.index');
    }


    public function data(Request $request)
    {
        $freelancers = Freelancer::with(['user.country'])
            ->whereHas('identityVerification', function ($query) {
                $query->where('status', '0');
            });

        if ($request->filled('search')) {
            $search = $request->search;

            $freelancers = $freelancers->whereHas('user', function ($query) use ($search) {
                $query->where('name', 'like', "%{$search}%")
                    ->orWhere('email', 'like', "%{$search}%")
                    ->orWhere('mobile', 'like', "%{$search}%");
            });
        }

        return DataTables::of($freelancers)
            ->addColumn('photo', fn($row) => '<img src="' . optional($row->user)->getImageUrl() . '" class="w-50px h-50px rounded-circle">')
            ->editColumn('mobile', function ($row) {
                if (!$row->user || !$row->user->country) {
                    return '-';
                }
                $flag = optional($row->user->country)->flag;
                $code = optional($row->user->country)->number_code ?? '';
                $mobile = optional($row->user)->mobile ?? '';

                return '<span class="d-flex align-items-center gap-2">
                <img src="' . $flag . '"  class="w-30px h-30px rounded-circle"  alt="Flag" >
                <span class="badge badge-light-primary">' . $code . ' ' . $mobile . '</span>
            </span>';
            })
            ->editColumn('date', function ($row) {
                return optional($row->user)->created_at
                    ? $row->user->created_at->format('d M, Y') . ' , ' . $row->user->created_at->diffForHumans()
                    : '-';
            })
            ->addColumn('name', fn($row) => optional($row->user)->name ?? '-')
            ->addColumn('email', fn($row) => optional($row->user)->email ?? '-')
            ->editColumn('actions', function ($row) {
                return '
    <div class="d-flex align-items-center gap-2">
        <button class="btn btn-light-primary btn-sm view-request" data-id="' . $row->id . '">
            <i class="ki-outline ki-eye"></i> View
        </button>
        <button class="btn btn-light-success btn-sm verify-action-btn" data-id="' . $row->id . '" data-action="accept">
            <i class="ki-outline ki-check"></i> Accept
        </button>
        <button class="btn btn-light-warning btn-sm verify-action-btn" data-id="' . $row->id . '" data-action="reject">
            <i class="ki-outline ki-cross"></i> Reject
        </button>
    </div>';
            })
            ->addIndexColumn()
            ->rawColumns(['actions', 'photo', 'mobile', 'times'])
            ->make(true);
    }

    public function show($id)
    {
        $freelancer = Freelancer::with(['user.country', 'identityVerification'])->findOrFail($id);

        $data = [
            'user' => [
                'name' => $freelancer->user->name,
                'email' => $freelancer->user->email,
                'mobile' => $freelancer->user->mobile,
                'created_at' => Carbon::parse($freelancer->user->created_at)->format('d M, Y') . ', ' . Carbon::parse($freelancer->user->created_at)->diffForHumans(),
                'photo' => $freelancer->user->getImageUrl(),
            ],
            'identity_verification' => [
                'created_at' => Carbon::parse($freelancer->identityVerification->created_at)->format('d M, Y') . ', ' . Carbon::parse($freelancer->identityVerification->created_at)->diffForHumans(),
                'first_name' => $freelancer->identityVerification->first_name,
                'father_name' => $freelancer->identityVerification->father_name,
                'grandfather_name' => $freelancer->identityVerification->grandfather_name,
                'family_name' => $freelancer->identityVerification->family_name,
                'id_number' => $freelancer->identityVerification->id_number,
                'full_address' => $freelancer->identityVerification->full_address,
                'id_image' => $freelancer->identityVerification->getImageUrl(),
            ]
        ];

        return response()->json($data);
    }

    public function handleAction(Request $request, $id, $action)
    {
        $freelancer = Freelancer::with('identityVerification', 'user')->findOrFail($id);

        if (!$freelancer->identityVerification) {
            return response()->json(['message' => 'Verification request not found'], 404);
        }

        if (!in_array($action, ['accept', 'reject'])) {
            return response()->json(['message' => 'Invalid action'], 400);
        }

        $freelancer->identityVerification->status = $action === 'accept' ? '1' : '2';
        if ($action === 'accept') {
            Mail::to($freelancer->user->email)->send(new VerificationAccepted($freelancer->user,$freelancer->user->lang));

            $badge = Badge::whereId(1)->first();
            if ($badge) {
                $freelancer->badges()->syncWithoutDetaching([$badge->id]);
            }
        }


        $freelancer->identityVerification->save();

        if ($action === 'reject') {
            $reason = $request->input('reason', 'No reason provided.');
            Mail::to($freelancer->user->email)->send(
                new VerificationRejected($freelancer->user, $freelancer->user->lang, $reason)
            );
        }

        return response()->json([
            'message' => $action === 'accept'
                ? 'Verification accepted successfully'
                : 'Verification rejected successfully',
        ]);
    }


    public function destroy($id)
    {
        $badge = Contact::findOrFail($id);
        $badge->delete();
        return response()->json(['message' => 'Contact deleted successfully.']);
    }


}
