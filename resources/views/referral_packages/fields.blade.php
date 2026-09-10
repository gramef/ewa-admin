<div class="row">
    <!-- Name Field -->
    <div class="form-group col-md-6">
        <label for="name" class="control-label font-weight-bold">Package Name <span class="text-danger">*</span></label>
        <input type="text" name="name" id="name" class="form-control" value="{{ old('name', $referralPackage->name ?? '') }}" placeholder="e.g. Client Share & Earn £10" required>
        <small class="form-text text-muted">A clear, descriptive name for this promotional referral campaign.</small>
    </div>

    <!-- Target Role Field -->
    <div class="form-group col-md-3">
        <label for="target_role" class="control-label font-weight-bold">Target Audience <span class="text-danger">*</span></label>
        <select name="target_role" id="target_role" class="form-control select2" required>
            <option value="client" {{ (old('target_role', $referralPackage->target_role ?? 'client') === 'client') ? 'selected' : '' }}>Clients / Customers</option>
            <option value="vendor" {{ (old('target_role', $referralPackage->target_role ?? '') === 'vendor') ? 'selected' : '' }}>Vendors / Stylists</option>
            <option value="all" {{ (old('target_role', $referralPackage->target_role ?? '') === 'all') ? 'selected' : '' }}>All Users</option>
        </select>
        <small class="form-text text-muted">Who can participate in this campaign.</small>
    </div>

    <!-- Reward Type Field -->
    <div class="form-group col-md-3">
        <label for="reward_type" class="control-label font-weight-bold">Reward Type <span class="text-danger">*</span></label>
        <select name="reward_type" id="reward_type" class="form-control select2" required>
            <option value="fixed_discount" {{ (old('reward_type', $referralPackage->reward_type ?? 'fixed_discount') === 'fixed_discount') ? 'selected' : '' }}>Fixed £ Discount (Coupon)</option>
            <option value="percentage_discount" {{ (old('reward_type', $referralPackage->reward_type ?? '') === 'percentage_discount') ? 'selected' : '' }}>Percentage % Discount</option>
            <option value="wallet_credit" {{ (old('reward_type', $referralPackage->reward_type ?? '') === 'wallet_credit') ? 'selected' : '' }}>Wallet Credit</option>
            <option value="commission_reduction" {{ (old('reward_type', $referralPackage->reward_type ?? '') === 'commission_reduction') ? 'selected' : '' }}>Vendor Commission Reduction</option>
        </select>
        <small class="form-text text-muted">How the rewards will be issued.</small>
    </div>

    <!-- Referrer Reward Value -->
    <div class="form-group col-md-4">
        <label for="referrer_reward_value" class="control-label font-weight-bold">Referrer Reward Value <span class="text-danger">*</span></label>
        <div class="input-group">
            <div class="input-group-prepend"><span class="input-group-text">£ / %</span></div>
            <input type="number" step="0.01" min="0" name="referrer_reward_value" id="referrer_reward_value" class="form-control" value="{{ old('referrer_reward_value', $referralPackage->referrer_reward_value ?? 10.00) }}" required>
        </div>
        <small class="form-text text-muted">What the friend who shares their code receives.</small>
    </div>

    <!-- Referee Reward Value -->
    <div class="form-group col-md-4">
        <label for="referee_reward_value" class="control-label font-weight-bold">Referee Reward Value <span class="text-danger">*</span></label>
        <div class="input-group">
            <div class="input-group-prepend"><span class="input-group-text">£ / %</span></div>
            <input type="number" step="0.01" min="0" name="referee_reward_value" id="referee_reward_value" class="form-control" value="{{ old('referee_reward_value', $referralPackage->referee_reward_value ?? 5.00) }}" required>
        </div>
        <small class="form-text text-muted">What the invited new user receives on their first booking.</small>
    </div>

    <!-- Minimum Booking Amount -->
    <div class="form-group col-md-4">
        <label for="min_booking_amount" class="control-label font-weight-bold">Min. Booking Amount</label>
        <div class="input-group">
            <div class="input-group-prepend"><span class="input-group-text">£</span></div>
            <input type="number" step="0.01" min="0" name="min_booking_amount" id="min_booking_amount" class="form-control" value="{{ old('min_booking_amount', $referralPackage->min_booking_amount ?? 0.00) }}">
        </div>
        <small class="form-text text-muted">Minimum booking subtotal required to qualify for reward.</small>
    </div>

    <!-- Required Completed Bookings -->
    <div class="form-group col-md-4">
        <label for="required_completed_bookings" class="control-label font-weight-bold">Required Completed Bookings</label>
        <input type="number" min="1" name="required_completed_bookings" id="required_completed_bookings" class="form-control" value="{{ old('required_completed_bookings', $referralPackage->required_completed_bookings ?? 1) }}">
        <small class="form-text text-muted">Number of completed appointments by referee before referrer is rewarded.</small>
    </div>

    <!-- Starts At -->
    <div class="form-group col-md-4">
        <label for="starts_at" class="control-label font-weight-bold">Campaign Start Date</label>
        <input type="date" name="starts_at" id="starts_at" class="form-control" value="{{ old('starts_at', isset($referralPackage->starts_at) ? $referralPackage->starts_at->format('Y-m-d') : '') }}">
        <small class="form-text text-muted">Optional: leave empty to activate immediately.</small>
    </div>

    <!-- Expires At -->
    <div class="form-group col-md-4">
        <label for="expires_at" class="control-label font-weight-bold">Campaign Expiry Date</label>
        <input type="date" name="expires_at" id="expires_at" class="form-control" value="{{ old('expires_at', isset($referralPackage->expires_at) ? $referralPackage->expires_at->format('Y-m-d') : '') }}">
        <small class="form-text text-muted">Optional: leave empty for ongoing promotion.</small>
    </div>

    <!-- Description -->
    <div class="form-group col-12">
        <label for="description" class="control-label font-weight-bold">Description & Terms</label>
        <textarea name="description" id="description" rows="3" class="form-control" placeholder="Describe the promo terms for clients or vendors...">{{ old('description', $referralPackage->description ?? '') }}</textarea>
    </div>

    <!-- Enabled Field -->
    <div class="form-group col-12">
        <div class="custom-control custom-switch">
            <input type="checkbox" name="enabled" class="custom-control-input" id="enabledSwitch" value="1" {{ old('enabled', $referralPackage->enabled ?? true) ? 'checked' : '' }}>
            <label class="custom-control-label font-weight-bold" for="enabledSwitch">Activate this Referral Campaign</label>
        </div>
    </div>
</div>

<!-- Submit / Cancel -->
<div class="form-group col-12 text-right mt-4">
    <button type="submit" class="btn btn-primary px-4 shadow-sm">
        <i class="fas fa-save mr-1"></i> Save Package
    </button>
    <a href="{{ route('referralPackages.index') }}" class="btn btn-default px-4 ml-2">Cancel</a>
</div>
