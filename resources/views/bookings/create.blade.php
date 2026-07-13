@extends('layouts.app')
@section('title', 'Book a Court')
@section('page-title', 'Book a Court')

@section('content')

<div style="max-width:680px;">
    <div class="card">
        <div class="card-header">&#128197; New Booking</div>
        <div class="card-body">

            <form method="POST" action="{{ route('bookings.store') }}" id="bookingForm">
                @csrf

                <!-- Step 1: Choose Court -->
                <div class="form-group">
                    <label for="court_id">
                        <span style="background:#2c7be5;color:#fff;border-radius:50%;
                                     display:inline-block;width:20px;height:20px;
                                     text-align:center;font-size:12px;margin-right:6px;">1</span>
                        Choose a Court
                    </label>
                    <select id="court_id" name="court_id"
                            class="{{ $errors->has('court_id') ? 'is-invalid' : '' }}" required>
                        <option value="">-- Select a court --</option>
                        @foreach($courts as $c)
                            <option value="{{ $c->id }}"
                                    data-price="{{ $c->price_per_hour }}"
                                    {{ old('court_id', $court?->id) == $c->id ? 'selected' : '' }}>
                                {{ $c->name }} &mdash; RM{{ number_format($c->price_per_hour, 2) }}/hr
                                ({{ $c->location }})
                            </option>
                        @endforeach
                    </select>
                    @error('court_id')
                        <div class="error-msg">{{ $message }}</div>
                    @enderror
                </div>

                <!-- Step 2: Choose Date -->
                <div class="form-group">
                    <label for="booking_date">
                        <span style="background:#2c7be5;color:#fff;border-radius:50%;
                                     display:inline-block;width:20px;height:20px;
                                     text-align:center;font-size:12px;margin-right:6px;">2</span>
                        Select Date
                    </label>
                    <input type="date" id="booking_date" name="booking_date"
                           min="{{ date('Y-m-d') }}"
                           value="{{ old('booking_date', $date) }}"
                           class="{{ $errors->has('booking_date') ? 'is-invalid' : '' }}"
                           required>
                    @error('booking_date')
                        <div class="error-msg">{{ $message }}</div>
                    @enderror
                </div>

                <!-- Step 3: Time Slot -->
                <div class="form-group">
                    <label>
                        <span style="background:#2c7be5;color:#fff;border-radius:50%;
                                     display:inline-block;width:20px;height:20px;
                                     text-align:center;font-size:12px;margin-right:6px;">3</span>
                        Select Time Slot
                    </label>

                    <div id="slotPlaceholder" class="info-box" style="margin-top:6px;">
                        &#128336; Please select a court and date first to see available slots.
                    </div>

                    <div id="slotLoading" style="display:none;color:#888;font-size:13px;margin-top:8px;">
                        Loading slots...
                    </div>

                    <div id="slotsGrid" class="slot-grid" style="display:none;"></div>

                    <input type="hidden" name="time_slot_id" id="time_slot_id" value="{{ old('time_slot_id') }}">
                    @error('time_slot_id')
                        <div class="error-msg">{{ $message }}</div>
                    @enderror
                </div>

                <!-- Step 4: Notes -->
                <div class="form-group">
                    <label for="notes">
                        <span style="background:#2c7be5;color:#fff;border-radius:50%;
                                     display:inline-block;width:20px;height:20px;
                                     text-align:center;font-size:12px;margin-right:6px;">4</span>
                        Notes <span style="color:#888;font-weight:normal;">(optional)</span>
                    </label>
                    <textarea id="notes" name="notes" rows="2"
                              placeholder="Any special requests...">{{ old('notes') }}</textarea>
                </div>

                <!-- Price Summary -->
                <div id="priceSummary" style="display:none;">
                    <div class="summary-box" style="margin-bottom:16px;">
                        <div class="summary-row">
                            <span style="color:#666;">Court</span>
                            <span id="summaryCourtName"></span>
                        </div>
                        <div class="summary-row">
                            <span style="color:#666;">Time Slot</span>
                            <span id="summarySlot"></span>
                        </div>
                        <div class="summary-row total">
                            <span>Total Amount</span>
                            <span class="price" id="summaryTotal"></span>
                        </div>
                    </div>
                </div>

                <div style="display:flex;gap:10px;">
                    <button type="submit" id="submitBtn" class="btn btn-success" disabled>
                        Confirm Booking
                    </button>
                    <a href="{{ route('courts.index') }}" class="btn btn-secondary">Cancel</a>
                </div>

            </form>
        </div>
    </div>
</div>

<script>
const courtSelect   = document.getElementById('court_id');
const dateInput     = document.getElementById('booking_date');
const slotsGrid     = document.getElementById('slotsGrid');
const slotPlaceholder = document.getElementById('slotPlaceholder');
const slotLoading   = document.getElementById('slotLoading');
const hiddenSlot    = document.getElementById('time_slot_id');
const submitBtn     = document.getElementById('submitBtn');
const priceSummary  = document.getElementById('priceSummary');

let selectedSlotLabel = '';

function loadSlots() {
    const courtId = courtSelect.value;
    const date    = dateInput.value;

    if (!courtId || !date) {
        slotsGrid.style.display = 'none';
        slotPlaceholder.style.display = 'block';
        return;
    }

    slotPlaceholder.style.display = 'none';
    slotsGrid.style.display = 'none';
    slotLoading.style.display = 'block';
    hiddenSlot.value = '';
    submitBtn.disabled = true;
    priceSummary.style.display = 'none';

    fetch(`{{ route('api.slots') }}?court_id=${courtId}&date=${date}`, {
        headers: { 'X-Requested-With': 'XMLHttpRequest' }
    })
    .then(r => r.json())
    .then(slots => {
        slotLoading.style.display = 'none';
        slotsGrid.innerHTML = '';

        slots.forEach(slot => {
            const btn = document.createElement('div');
            btn.className = 'slot-btn' + (slot.booked ? ' booked' : '');
            btn.textContent = slot.label;
            btn.dataset.id    = slot.id;
            btn.dataset.label = slot.label;

            if (!slot.booked) {
                btn.addEventListener('click', () => {
                    document.querySelectorAll('.slot-btn').forEach(b => b.classList.remove('selected'));
                    btn.classList.add('selected');
                    hiddenSlot.value   = slot.id;
                    selectedSlotLabel  = slot.label;
                    submitBtn.disabled = false;
                    updateSummary();
                });
            }

            slotsGrid.appendChild(btn);
        });

        slotsGrid.style.display = 'grid';
    })
    .catch(() => {
        slotLoading.style.display = 'none';
        slotPlaceholder.textContent = 'Failed to load slots. Please try again.';
        slotPlaceholder.style.display = 'block';
    });
}

function updateSummary() {
    const opt = courtSelect.options[courtSelect.selectedIndex];
    if (!opt || !hiddenSlot.value) return;
    const price = parseFloat(opt.dataset.price || 0);
    document.getElementById('summaryCourtName').textContent = opt.text.split('—')[0].trim();
    document.getElementById('summarySlot').textContent      = selectedSlotLabel;
    document.getElementById('summaryTotal').textContent     = 'RM' + price.toFixed(2);
    priceSummary.style.display = 'block';
}

courtSelect.addEventListener('change', loadSlots);
dateInput.addEventListener('change', loadSlots);

// Auto-load if court was pre-selected (from query string)
if (courtSelect.value && dateInput.value) loadSlots();
</script>

@endsection
