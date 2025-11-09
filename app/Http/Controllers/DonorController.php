<?php

namespace App\Http\Controllers;

use App\Models\Campaign;
use App\Models\Donation;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log; // Added for better error logging
use Illuminate\Support\Str;

class DonorController extends Controller
{
    /**
     * Display the list of active campaigns for the donor discovery page (Donor Dashboard).
     */
    public function index()
    {
        // Fetch campaigns that are active
        $campaigns = Campaign::with('creator')
            ->where('status', 'active')
            ->orderBy('deadline', 'asc')
            ->get();

        return view('donor.donorlayoutpage', [
            'campaigns' => $campaigns,
            'role' => Auth::check() ? Auth::user()->role : 'guest',
        ]);
    }

    /**
     * Display the donor profile page.
     */
    public function profile()
    {
        return view('donor.donorprofilepage');
    }

    // --- DONATION FLOW METHODS ---

    /**
     * Display the donation form for a specific campaign.
     */
    public function create(Campaign $campaign)
    {
        $user = Auth::user();
        $role = $user ? $user->role : 'guest';

        if ($campaign->status !== 'active') {
            return redirect()->route('campaigns.show', $campaign)
                ->with('error', 'This campaign is not currently accepting donations.');
        }

        // NEW: Check if campaign has reached its goal
        if ($campaign->current_amount >= $campaign->goal_amount) {
            return redirect()->route('campaigns.show', $campaign)
                ->with('info', 'Great news! This campaign has already reached its funding goal and donations are now closed.');
        }

        return view('donor.create', [
            'campaign' => $campaign,
            'role' => $role,
        ]);
    }

    /**
     * Handle the submission and processing of the donation.
     */
    public function store(Request $request, Campaign $campaign)
    {
        // 1. Validation
        $request->validate([
            'amount' => 'required|numeric|min:1',
            'payment_method' => 'required|in:credit_card,paypal,bank_transfer',
            'anonymous' => 'nullable|boolean',
            'message' => 'nullable|string|max:500',
        ]);

        $donor = Auth::user();
        $grossAmount = $request->amount;

        // 2. Pre-Payment Checks
        if ($campaign->status !== 'active') {
            return back()->with('error', 'This campaign is no longer active.');
        }

        if ($campaign->current_amount >= $campaign->goal_amount) {
            return back()->with('error', 'Great news! This campaign has already reached its funding goal and donations are now closed.');
        }

        // --- SIMULATED PAYMENT PROCESSING & FEE CALCULATION ---
        $paymentProcessorFee = ($grossAmount * 0.029) + 0.30;
        $netAmount = $grossAmount - $paymentProcessorFee;
        $transactionId = 'TXN_' . Str::random(12);

        try {
            DB::beginTransaction();

            // 3. Create the Donation record
            $donation = Donation::create([
                'campaign_id' => $campaign->id,
                'donor_id' => $donor->id,
                'amount' => $grossAmount,
                'anonymous' => $request->boolean('anonymous'),
                'message' => $request->message,
                'payment_method' => $request->payment_method,
                'transaction_id' => $transactionId,
                'payment_status' => 'completed',
                'payment_processor' => 'SimulatedProcessor',
                'processor_fee' => round($paymentProcessorFee, 2),
                'net_amount' => round($netAmount, 2),
            ]);

            // 4. Update the Campaign's current amount
            $campaign->increment('current_amount', $donation->net_amount);

            if ($campaign->current_amount >= $campaign->goal_amount) {
                $campaign->update(['status' => 'completed']);
            }

            DB::commit();

            return redirect()->route('campaigns.show', $campaign)
                ->with('success', "Thank you! Your donation of **$" . number_format($grossAmount, 2) . "** has been successfully processed.");
        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('Donation processing failed in DonorController: ' . $e->getMessage());

            return back()->withInput()->with('error', 'There was an error processing your donation. Please try again.');
        }
    }
}
