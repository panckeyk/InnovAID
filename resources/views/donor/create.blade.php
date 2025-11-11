<x-navbar :isCampaignDetails="false" :role="$role"> 
    <script src="//unpkg.com/alpinejs" defer></script>
    <style>[x-cloak]{ display:none !important; }</style>
    {{-- This view is loaded when the donor clicks the 'Back this Project' link --}}
    
    {{-- Use Alpine.js to control the modal state --}}
    <div x-data="{
            open: true,
            detailsOpen: false,
            confirmOpen: false,
            method: '{{ old('payment_method', '') }}',
            // credit card
            cc_name: '',
            cc_number: '',
            cc_exp: '',
            cc_cvv: '',
            // paypal
            pp_email: '',
            // bank transfer
            bt_name: '',
            bt_number: '',
            bt_reference: ''
        }">
        
        <div x-show="open" x-cloak
             class="fixed inset-0 z-40 bg-gray-900 bg-opacity-20 transition-opacity" 
             aria-hidden="true" 
             @click="open=false; window.location.href='{{ route('campaigns.show', $campaign) }}';"
             x-transition:enter="ease-out duration-300" 
             x-transition:enter-start="opacity-0" 
             x-transition:enter-end="opacity-100" 
             x-transition:leave="ease-in duration-200" 
             x-transition:leave-start="opacity-100" 
             x-transition:leave-end="opacity-0">
        </div>

        <div x-show="open" x-cloak
             class="fixed inset-0 z-50 overflow-y-auto" 
             aria-labelledby="modal-title" 
             role="dialog" 
             aria-modal="true"
             x-transition:enter="ease-out duration-300" 
             x-transition:enter-start="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95" 
             x-transition:enter-end="opacity-100 translate-y-0 sm:scale-100" 
             x-transition:leave="ease-in duration-200" 
             x-transition:leave-start="opacity-100 translate-y-0 sm:scale-100" 
             x-transition:leave-end="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95">

            <div class="flex items-end justify-center min-h-screen pt-4 px-4 pb-20 text-center sm:block sm:p-0">
                
                <span class="hidden sm:inline-block sm:align-middle sm:h-screen" aria-hidden="true">&#8203;</span>

                <div class="relative inline-block align-bottom bg-white rounded-lg text-left overflow-hidden shadow-xl transform transition-all sm:my-8 sm:align-middle sm:max-w-lg sm:w-full">
                    
                    <form id="donation-form" action="{{ route('donor.store', $campaign) }}" method="POST">
                        @csrf
                        
                        <div class="bg-white px-4 pt-5 pb-4 sm:p-6 sm:pb-4">
                            <div class="sm:flex sm:items-start">
                                <div class="mt-3 text-center sm:mt-0 sm:ml-4 sm:text-left w-full">
                                    <h3 class="text-2xl leading-6 font-bold text-gray-900" id="modal-title">
                                        Back: {{ $campaign->title }}
                                    </h3>
                                    <p class="text-sm text-gray-500 mt-2">
                                        You are donating to {{ $campaign->creator->name ?? 'this creator' }}.
                                    </p>

                                    @if ($errors->any())
                                        <div class="mt-4 p-3 bg-red-100 text-red-700 rounded-lg">
                                            Please correct the errors below.
                                        </div>
                                    @endif

                                    <div class="mt-4">
                                        <label for="amount" class="block text-sm font-medium text-gray-700">Donation Amount ($)</label>
                                        <div class="mt-1 relative rounded-md shadow-sm">
                                            <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                                <span class="text-gray-500 sm:text-sm">$</span>
                                            </div>
                                            <input type="number" name="amount" id="amount" 
                                                   class="focus:ring-blue-500 focus:border-blue-500 block w-full pl-7 pr-12 sm:text-lg border-gray-300 rounded-md @error('amount') @enderror" 
                                                   placeholder="10.00" min="1" step="0.01" required value="{{ old('amount') }}">
                                        </div>
                                        @error('amount')
                                            <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                                        @enderror
                                    </div>
                                    
                                    <div class="mt-4">
                                        <label for="payment_method" class="block text-sm font-medium text-gray-700">Payment Method</label>
                                        <select id="payment_method" name="payment_method" required x-model="method"
                                                class="mt-1 block w-full py-2 px-3 border border-gray-300 bg-white rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500 sm:text-sm @error('payment_method') @enderror">
                                            <option value="">Select a method</option>
                                            <option value="credit_card" {{ old('payment_method') == 'credit_card' ? 'selected' : '' }}>Credit Card (Simulated)</option>
                                            <option value="paypal" {{ old('payment_method') == 'paypal' ? 'selected' : '' }}>PayPal (Simulated)</option>
                                            <option value="bank_transfer" {{ old('payment_method') == 'bank_transfer' ? 'selected' : '' }}>Bank Transfer (Simulated)</option>
                                        </select>
                                        @error('payment_method')
                                            <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                                        @enderror
                                    </div>

                                    <div class="mt-4">
                                        <label for="message" class="block text-sm font-medium text-gray-700">Message (Optional)</label>
                                        <textarea id="message" name="message" rows="3" maxlength="500"
                                                  class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500 sm:text-sm"
                                                  placeholder="Say something nice to the creator...">{{ old('message') }}</textarea>
                                        @error('message')
                                            <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                                        @enderror
                                    </div>
                                    
                                    <div class="mt-4 flex items-start">
                                        <div class="flex items-center h-5">
                                            <input id="anonymous" name="anonymous" type="checkbox" value="1"
                                                   class="focus:ring-blue-500 h-4 w-4 text-blue-600 border-gray-300 rounded"
                                                   {{ old('anonymous') ? 'checked' : '' }}>
                                        </div>
                                        <div class="ml-3 text-sm">
                                            <label for="anonymous" class="font-medium text-gray-700">Donate Anonymously</label>
                                            <p class="text-gray-500">Your name will not be publicly displayed.</p>
                                        </div>
                                    </div>

                                </div>
                            </div>
                        </div>
                        
                        <div class="bg-gray-50 px-4 py-3 sm:px-6 sm:flex sm:flex-row-reverse relative">
                            <button type="button" @click="if (!method) { return; } detailsOpen = true"
                                    class="w-full inline-flex justify-center rounded-md border border-transparent shadow-sm px-4 py-2 bg-blue-600 text-base font-medium text-white hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 sm:ml-3 sm:w-auto sm:text-sm">
                                Continue
                            </button>
                            
                            {{-- Cancel button logic: Go back to the campaign show page --}}
                            <button type="button" 
                                    @click="open = false; window.location.href='{{ route('campaigns.show', $campaign) }}';"
                                    class="mt-3 w-full inline-flex justify-center rounded-md border border-gray-300 shadow-sm px-4 py-2 bg-white text-base font-medium text-gray-700 hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 sm:mt-0 sm:ml-3 sm:w-auto sm:text-sm">
                                Cancel
                            </button>
                        </div>

                    </form>
                </div>
            </div>
        </div>

        {{-- Payment Method Details Modal --}}
        <div x-show="detailsOpen" x-cloak
             class="fixed inset-0 z-[60] overflow-y-auto"
             aria-modal="true" role="dialog"
             x-transition:enter="ease-out duration-200"
             x-transition:enter-start="opacity-0" 
             x-transition:enter-end="opacity-100"
             x-transition:leave="ease-in duration-150"
             x-transition:leave-start="opacity-100" 
             x-transition:leave-end="opacity-0">

            <div class="fixed inset-0 bg-gray-900 bg-opacity-20 z-[60]" @click="detailsOpen=false"></div>

            <div class="flex items-center justify-center min-h-screen px-4 py-8 relative z-[70]">
                <div class="bg-white rounded-lg shadow-xl w-full max-w-md overflow-hidden relative z-[70]">
                    <div class="px-6 py-4 border-b">
                        <h3 class="text-lg font-semibold">Enter Card Details</h3>
                        <p class="text-sm text-gray-500">This is a simulation only.</p>
                    </div>

                    <div class="px-6 py-4 space-y-4">
                        {{-- Credit Card Fields --}}
                        <template x-if="method === 'credit_card'">
                            <div class="space-y-4">
                                <div>
                                    <label class="block text-sm font-medium text-gray-700">Cardholder Name</label>
                                    <input type="text" name="cc_name" x-model="cc_name" form="donation-form" placeholder="Jane Q. Donor"
                                           class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500 sm:text-sm">
                                </div>
                                <div>
                                    <label class="block text-sm font-medium text-gray-700">Card Number</label>
                                    <input type="text" name="cc_number" x-model="cc_number" form="donation-form" placeholder="4242 4242 4242 4242" maxlength="19"
                                           class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500 sm:text-sm">
                                </div>
                                <div class="grid grid-cols-2 gap-3">
                                    <div>
                                        <label class="block text-sm font-medium text-gray-700">Expiry (MM/YY)</label>
                                        <input type="text" name="cc_exp" x-model="cc_exp" form="donation-form" placeholder="12/28" maxlength="5"
                                               class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500 sm:text-sm">
                                    </div>
                                    <div>
                                        <label class="block text-sm font-medium text-gray-700">CVV</label>
                                        <input type="text" name="cc_cvv" x-model="cc_cvv" form="donation-form" placeholder="123" maxlength="4"
                                               class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500 sm:text-sm">
                                    </div>
                                </div>
                            </div>
                        </template>

                        {{-- PayPal Fields --}}
                        <template x-if="method === 'paypal'">
                            <div class="space-y-4">
                                <div>
                                    <label class="block text-sm font-medium text-gray-700">PayPal Email</label>
                                    <input type="email" name="pp_email" x-model="pp_email" form="donation-form" placeholder="you@example.com"
                                           class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500 sm:text-sm">
                                </div>
                            </div>
                        </template>

                        {{-- Bank Transfer Fields --}}
                        <template x-if="method === 'bank_transfer'">
                            <div class="space-y-4">
                                <div>
                                    <label class="block text-sm font-medium text-gray-700">Account Name</label>
                                    <input type="text" name="bt_name" x-model="bt_name" form="donation-form" placeholder="John D. Donor"
                                           class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500 sm:text-sm">
                                </div>
                                <div>
                                    <label class="block text-sm font-medium text-gray-700">Account Number</label>
                                    <input type="text" name="bt_number" x-model="bt_number" form="donation-form" placeholder="000123456789"
                                           class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500 sm:text-sm">
                                </div>
                                <div>
                                    <label class="block text-sm font-medium text-gray-700">Reference</label>
                                    <input type="text" name="bt_reference" x-model="bt_reference" form="donation-form" placeholder="INV-12345"
                                           class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500 sm:text-sm">
                                </div>
                            </div>
                        </template>

                        <p class="text-xs text-gray-500">Your inputs are stored only for this simulation and are not sent to a real gateway.</p>
                    </div>

                    <div class="px-6 py-4 bg-gray-50 flex justify-end gap-3">
                        <button type="button" @click="detailsOpen=false"
                                class="px-4 py-2 border border-gray-300 rounded-md text-gray-700 hover:bg-gray-100 text-sm">Back</button>
                        <button type="button" @click="detailsOpen=false; confirmOpen=true"
                                class="px-4 py-2 bg-blue-600 text-white rounded-md hover:bg-blue-700 text-sm">Next</button>
                    </div>
                </div>
            </div>
        </div>

        {{-- Confirmation Modal (Payment Credentials Simulation) --}}
        <div x-show="confirmOpen" x-cloak
             class="fixed inset-0 z-[60] overflow-y-auto"
             aria-modal="true" role="dialog"
             x-transition:enter="ease-out duration-200"
             x-transition:enter-start="opacity-0" 
             x-transition:enter-end="opacity-100"
             x-transition:leave="ease-in duration-150"
             x-transition:leave-start="opacity-100" 
             x-transition:leave-end="opacity-0">

            <div class="fixed inset-0 bg-gray-900 bg-opacity-20 z-[60]" @click="confirmOpen=false"></div>

            <div class="flex items-center justify-center min-h-screen px-4 py-8 relative z-[70]">
                <div class="bg-white rounded-lg shadow-xl w-full max-w-md overflow-hidden relative z-[70]">
                    <div class="px-6 py-4 border-b">
                        <h3 class="text-lg font-semibold">Confirm Payment Details</h3>
                        <p class="text-sm text-gray-500">Enter credentials for <span class="font-medium" x-text="method || 'selected method'"></span></p>
                    </div>

                    <div class="px-6 py-4 space-y-4">
                        {{-- Credit Card --}}
                        <template x-if="method === 'credit_card'">
                            <div class="space-y-3">
                                <div>
                                    <label class="block text-sm font-medium text-gray-700">Cardholder Name</label>
                                    <input type="text" name="cc_name" placeholder="Jane Q. Donor"
                                        class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500 sm:text-sm">
                                </div>
                                <div>
                                    <label class="block text-sm font-medium text-gray-700">Card Number</label>
                                    <input type="text" name="cc_number" placeholder="4242 4242 4242 4242" maxlength="19"
                                        class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500 sm:text-sm">
                                </div>
                                <div class="grid grid-cols-2 gap-3">
                                    <div>
                                        <label class="block text-sm font-medium text-gray-700">Expiry (MM/YY)</label>
                                        <input type="text" name="cc_exp" placeholder="12/28" maxlength="5"
                                            class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500 sm:text-sm">
                                    </div>
                                    <div>
                                        <label class="block text-sm font-medium text-gray-700">CVV</label>
                                        <input type="text" name="cc_cvv" placeholder="123" maxlength="4"
                                            class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500 sm:text-sm">
                                    </div>
                                </div>
                            </div>
                        </template>

                        {{-- PayPal --}}
                        <template x-if="method === 'paypal'">
                            <div>
                                <label class="block text-sm font-medium text-gray-700">PayPal Email</label>
                                <input type="email" name="pp_email" placeholder="you@example.com"
                                    class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500 sm:text-sm">
                            </div>
                        </template>

                        {{-- Bank Transfer --}}
                        <template x-if="method === 'bank_transfer'">
                            <div class="space-y-3">
                                <div>
                                    <label class="block text-sm font-medium text-gray-700">Account Name</label>
                                    <input type="text" name="bt_name" placeholder="John D. Donor"
                                        class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500 sm:text-sm">
                                </div>
                                <div>
                                    <label class="block text-sm font-medium text-gray-700">Account Number</label>
                                    <input type="text" name="bt_number" placeholder="000123456789"
                                        class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500 sm:text-sm">
                                </div>
                                <div>
                                    <label class="block text-sm font-medium text-gray-700">Reference</label>
                                    <input type="text" name="bt_reference" placeholder="INV-12345"
                                        class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500 sm:text-sm">
                                </div>
                            </div>
                        </template>

                        <p class="text-xs text-gray-500">Note: This is a simulation only. Credentials are not processed by a real gateway.</p>
                    </div>

                    <div class="px-6 py-4 bg-gray-50 flex justify-end gap-3">
                        <button type="button" @click="confirmOpen=false"
                            class="px-4 py-2 border border-gray-300 rounded-md text-gray-700 hover:bg-gray-100 text-sm">Back</button>
                        <button type="submit" form=""
                            class="px-4 py-2 bg-blue-600 text-white rounded-md hover:bg-blue-700 text-sm"
                            @click="$root.querySelector('form').submit()">Confirm Payment</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-navbar>